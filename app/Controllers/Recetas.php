<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\IngredientesRecetasModel;

// Muestra el listado de todas las recetas del usuario y valida la sesión antes de mostrar datos    
class Recetas extends BaseController
{
    public function index()
    {
        // Seguridad: Si no está logueado, va pa afuera XD ↓
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $model = new RecetaModel();
        $idUsuario = session()->get('Id_usuario');

        // Consulta: Traemos solo las recetas que pertenecen a este usuario ↓
        $data['recetas'] = $model->where('Id_usuario', $idUsuario)->findAll();

        return view('recetas/index', $data);
    }

    // Carga la vista para crear una nueva receta. Prepara la lista de insumos disponibles para el select.
    public function crear()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $ingModel = new IngredienteModel();
        $gastoModel = new \App\Models\GastoAdicionalModel();
        $idUsuario = session()->get('Id_usuario');

        // Filtramos insumos válidos (precio > 0) y los ordenamos alfabéticamente para facilitar la búsqueda al usuario.
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.0001) // Ajustado para permitir insumos baratos
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        $data['gastos'] = $gastoModel->where('Id_usuario', $idUsuario)->findAll();

        return view('recetas/crear', $data);
    }

    /*
     * LÓGIhhCA PRINCIPAL DEL SISTEMA
     * 1. Guarda la cabecera de la receta
     * 2. Procesa los ingredientes uno por uno
     * 3. Procesa los COSTOS INDIRECTOS (Fijos y Porcentajes)
     * 4. Calcula el precio final sumando la ganancia deseada
     */
    public function guardar()
    {
        // Instanciamos los modelos necesarios para la operación transaccional
        $recetaModel      = new RecetaModel();
        $ingModel         = new IngredienteModel();
        $detalleModel     = new IngredientesRecetasModel();
        
        // Modelos nuevos para los Gastos Indirectos
        $gastoModel       = new \App\Models\GastoAdicionalModel();
        // Asegúrate de haber creado este modelo o úsalo directo si usas query builder, 
        // pero lo ideal es tener el modelo App\Models\GastosRecetasModel
        $gastoRecetaModel = new \App\Models\GastosRecetasModel(); 

        // Recibimos la info del formulario (Ingredientes y Cantidades)
        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades      = $this->request->getPost('cantidades');
        $gastosIds       = $this->request->getPost('gasto_id'); // Checkboxes de Gastos
        $inputGanancia   = $this->request->getPost('ganancia');

        // Validación básica del porcentaje de ganancia (Default: 30%)
        $gananciaReal    = ($inputGanancia > 0) ? $inputGanancia : 30;
        $idUsuario       = session()->get('Id_usuario');

        // 1. Crear la receta Cabecera, inicializamos costos en 0
        $dataReceta = [
            'Id_usuario'          => $idUsuario,
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => 0, // Se actualizará al final
            'precio_venta_sug'    => 0, // Se actualizará al final
            'porcentaje_ganancia' => $gananciaReal,
            'notas'               => $this->request->getPost('notas')
        ];

        // Insertamos y recuperamos el ID generado
        $idReceta = $recetaModel->insert($dataReceta, true);

        // 2. Procesamiento de Ingredientes e Insumos
        $costoTotalIngredientes = 0;

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                // Verificamos que el ingrediente y la cantidad sean válidos
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
                        // Datos base del insumo comprado
                        $precioPaquete  = floatval($infoIngrediente['costo_unidad']);
                        $tamanoPaquete  = floatval($infoIngrediente['cantidad_paquete']);
                        $cantidadUsada  = floatval($cantidades[$index]);
                        $idUnidadBase   = intval($infoIngrediente['Id_unidad_base']);

                        // Lógica de conversión de unidades
                        $factor = 1;
                        if ($idUnidadBase == 2 || $idUnidadBase == 4) { // KG o Litros
                            $factor = 1000;
                        }

                        $tamanoReal = $tamanoPaquete * $factor;

                        // Cálculo del costo proporcional
                        $costoInsumo = 0;
                        if ($tamanoReal > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoReal;
                            $costoInsumo = $costoUnitarioReal * $cantidadUsada;
                        }

                        // Acumulamos al costo parcial de ingredientes
                        $costoTotalIngredientes += $costoInsumo;

                        $detalleModel->insert([
                            'Id_receta'          => $idReceta,
                            'id_ingrediente'     => $idIng,
                            'cantidad_requerida' => $cantidadUsada,
                            'unidad_receta'      => 'unidad'
                        ]);
                    }
                }
            }
        }

        // P3. Procesamiento de Gastos Indirectos (Fijos vs Porcentajes)
        $costoTotalIndirectos = 0;

        if ($gastosIds) {
            foreach ($gastosIds as $idGasto) {
                $infoGasto = $gastoModel->find($idGasto);
                
                if ($infoGasto) {
                    $valorGasto = floatval($infoGasto['precio_unitario']);
                    $esFijo     = ($infoGasto['es_fijo'] == 1);
                    $montoAplicado = 0;

                    if ($esFijo) {
                        // Si es fijo (ej: Delivery $3), se suma directo
                        $montoAplicado = $valorGasto;
                    } else {
                        // Si es porcentaje (ej: Mano de obra 10%), se calcula sobre los ingredientes
                        $montoAplicado = $costoTotalIngredientes * ($valorGasto / 100);
                    }

                    $costoTotalIndirectos += $montoAplicado;

                    // Guardamos la relación en la tabla intermedia
                    $gastoRecetaModel->insert([
                        'Id_receta'       => $idReceta,
                        'Id_gasto'        => $idGasto,
                        'precio_aplicado' => $montoAplicado // Guardamos cuánto valió en ese momento
                    ]);
                }
            }
        }

        // 4. Cálculo financiero final
        // El costo de producción real es: Ingredientes + Indirectos
        $costoProduccionTotal = $costoTotalIngredientes + $costoTotalIndirectos;

        // La ganancia se calcula sobre el costo de producción total
        $gananciaDinero = $costoProduccionTotal * ($gananciaReal / 100);
        $precioVenta    = $costoProduccionTotal + $gananciaDinero;

        // PASO 5: Actualización final de la cabecera
        $recetaModel->update($idReceta, [
            'costo_ingredientes' => $costoProduccionTotal, // Guardamos el costo total aquí
            'precio_venta_sug'   => $precioVenta
        ]);

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta creada exitosamente.');
    }

    // Muestra la ficha técnica de la receta (Solo lectura) y realiza un JOIN para traer los nombres de los ingredientes
    public function ver($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $recetaModel  = new RecetaModel();
        $detalleModel = new IngredientesRecetasModel();

        $data['receta'] = $recetaModel->find($id);

        if (!$data['receta']) {
            return redirect()->to(base_url('recetas'))->with('error', 'Receta no encontrada');
        }

        // JOIN: Unimos la tabla intermedia con la tabla de ingredientes para mostrar nombres
        $data['detalles'] = $detalleModel->select('ingredientes_recetas.*, ingredientes.nombre_ingrediente, ingredientes.Id_unidad_base')
            ->join('ingredientes', 'ingredientes.Id_ingrediente = ingredientes_recetas.id_ingrediente')
            ->where('ingredientes_recetas.Id_receta', $id)
            ->findAll();

        return view('recetas/VerReceta', $data);
    }

    // Carga la vista de edición con los datos actuales
    public function editar($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();
        $detalleModel = new IngredientesRecetasModel();

        $idUsuario = session()->get('Id_usuario');

        $data['receta'] = $recetaModel->find($id);

        if (!$data['receta']) {
            return redirect()->to(base_url('recetas'))->with('error', 'Receta no encontrada');
        }

        // Traemos todos los ingredientes para así poder agregar nuevos si se desea
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.0001)
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        // Traemos los ingredientes que ya tiene la receta
        $data['detalles'] = $detalleModel->where('Id_receta', $id)->findAll();

        return view('recetas/editar', $data);
    }

    // Recalcula toda la receta al editarla; Estrategia: Borrar los detalles viejos e insertar los nuevos para evitar posibles conflictos
    public function actualizar($id = null)
    {
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();
        $detalleModel = new IngredientesRecetasModel();

        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades      = $this->request->getPost('cantidades');
        $inputGanancia   = $this->request->getPost('ganancia');

        $gananciaReal    = ($inputGanancia > 0) ? $inputGanancia : 30;
        
        // Reiniciamos el contador de costos
        $costoTotalReceta = 0;
        $detallesNuevos = [];

        // Volvemos a iterar y calcular (Igual que en guardar)
        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
                        // Repetimos lógica de conversión de unidades
                        $precioPaquete  = floatval($infoIngrediente['costo_unidad']);
                        $tamanoPaquete  = floatval($infoIngrediente['cantidad_paquete']);
                        $cantidadUsada  = floatval($cantidades[$index]);
                        $idUnidadBase   = intval($infoIngrediente['Id_unidad_base']); 

                        $factor = 1;
                        if ($idUnidadBase == 2 || $idUnidadBase == 4) { // KG o Lt
                            $factor = 1000;
                        }

                        $tamanoReal = $tamanoPaquete * $factor;

                        $costoInsumo = 0;
                        if ($tamanoReal > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoReal;
                            $costoInsumo = $costoUnitarioReal * $cantidadUsada;
                        }

                        $costoTotalReceta += $costoInsumo;

                        // Preparamos el array para inserción masiva (Batch)
                        $detallesNuevos[] = [
                            'Id_receta'          => $id,
                            'id_ingrediente'     => $idIng,
                            'cantidad_requerida' => $cantidadUsada,
                            'unidad_receta'      => 'unidad'
                        ];
                    }
                }
            }
        }

        // Calculos finales
        $gananciaDinero = $costoTotalReceta * ($gananciaReal / 100);
        $precioVenta    = $costoTotalReceta + $gananciaDinero;

        // Actualizamos Cabecera
        $recetaModel->update($id, [
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => $costoTotalReceta,
            'precio_venta_sug'    => $precioVenta,
            'porcentaje_ganancia' => $gananciaReal,
            'notas'               => $this->request->getPost('notas')
        ]);

        // Eliminamos todos los ingredientes viejos de esta receta para evitar conflictos y actualizar sin problemas
        $detalleModel->where('Id_receta', $id)->delete();

        // Si hay ingredintes nuevos los agregamos, si no pues se queda igual
        if (!empty($detallesNuevos)) {
            $detalleModel->insertBatch($detallesNuevos);
        }

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta actualizada exitosamente.');
    }

    // Elimina una receta y sus detalles, además maneja redirección inteligente dependiendo de dónde se hizo clic al borrar    ya sea en el Panel o en la Lista
    public function borrar($id = null)
    {
        $recetaModel = new RecetaModel();
        $detalleModel = new IngredientesRecetasModel();

        // Ejecutar el borrado
        if ($id) {
            // Usamos 'builder' para permitir el delete con where manual
            $detalleModel->builder()->where('Id_receta', $id)->delete();
            $recetaModel->delete($id);
        }

        // Verificamos si en la URL venía el parámetro "?ref=panel", si es así volvemos al dashboard
        $origen = $this->request->getGet('ref');

        if ($origen === 'panel') {
            // Si vino del panel, lo devolvemos al panel, para que no nos lleve al apartado de mis recetas como hacia anteriormente
            return redirect()->to(base_url('panel'))->with('mensaje', 'Receta eliminada correctamente.');
        }

        // Si no, lo mandamos a la lista normal de recetas (comportamiento por defecto)
        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta eliminada correctamente.');
    }
}