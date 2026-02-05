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
        $idUsuario = session()->get('Id_usuario');

        // Filtramos insumos válidos (precio > 0) y los ordenamos alfabéticamente para facilitar la búsqueda al usuario.
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.01)
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        return view('recetas/crear', $data);
    }

    /*
     * LÓGICA PRINCIPAL DEL SISTEMA
     * 1. Guarda la cabecera de la receta
     * 2. Procesa los ingredientes uno por uno
     * 3. Convierte unidades (Paquete -> Gramos -> Costo real)
     * 4. Calcula el precio final sumando la ganancia deseada
     */
    public function guardar()
    {
        // Instanciamos los modelos necesarios para la operación transaccional
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();
        $detalleModel = new IngredientesRecetasModel();

        // Recibimos los arrays del formulario (Ingredientes y Cantidades)
        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades      = $this->request->getPost('cantidades');
        $inputGanancia   = $this->request->getPost('ganancia');

        // Validación básica del porcentaje de ganancia (Default: 30%), aunque puede ser el porcentaje que el cliente desee
        $gananciaReal    = ($inputGanancia > 0) ? $inputGanancia : 30;
        $margen_ganancia = $gananciaReal / 100;

        $idUsuario = session()->get('Id_usuario');

        // PASO 1: Crear la "Carpeta" de la receta (Cabecera). Inicializamos costos en 0, se calcularán más abajo.
        $dataReceta = [
            'Id_usuario'          => $idUsuario,
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => 0,
            'precio_venta_sug'    => 0,
            'porcentaje_ganancia' => $gananciaReal,
            'notas'               => $this->request->getPost('notas')
        ];

        // Insertamos y recuperamos el ID generado para relacionar los ingredientes
        $idReceta = $recetaModel->insert($dataReceta, true);

        // PASO 2: Procesamiento de Costos, lo que vendría siendo el algoritmo de costeo
        $costoTotalReceta = 0;

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                // Verificamos que el ingrediente y la cantidad sean válidos, es decir, no sean menor a 0 (> 0)
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
                        // Datos base del insumo comprado
                        $precioPaquete  = floatval($infoIngrediente['costo_unidad']);
                        $tamanoPaquete  = floatval($infoIngrediente['cantidad_paquete']);
                        $cantidadUsada  = floatval($cantidades[$index]);
                        $idUnidadBase   = intval($infoIngrediente['Id_unidad_base']);

                        // Lógica de conversión de unidades Si la unidad base es KG (2) o Litro (4), multiplicamos el tamaño del paquete por 1000, esto lo hacemos para estandarizar todo a Gramos o Mililitros
                        $factor = 1;
                        if ($idUnidadBase == 2 || $idUnidadBase == 4) {
                            $factor = 1000;
                        }

                        $tamanoRealEnGramos = $tamanoPaquete * $factor;

                        // Cálculo del costo proporcional (Regla de tres)
                        $costoInsumo = 0;
                        if ($tamanoRealEnGramos > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoRealEnGramos;
                            $costoInsumo = $costoUnitarioReal * $cantidadUsada;
                        }

                        // Acumulamos al costo total de la receta 
                        $costoTotalReceta += $costoInsumo;

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

        // PASO 3: Cálculo financiero, fórmula simple Costo de Inversión + % de Ganancia en Dinero = Precio Venta
        $gananciaDinero = $costoTotalReceta * ($gananciaReal / 100);
        $precioVenta    = $costoTotalReceta + $gananciaDinero;

        // PASO 4: Actualización final, Guardamos los totales calculados en la cabecera de la receta
        $recetaModel->update($idReceta, [
            'costo_ingredientes' => $costoTotalReceta,
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
            ->where('costo_unidad >', 0.01)
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
        $margen_ganancia = $gananciaReal / 100;

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
                        $idUnidadBase   = intval($infoIngrediente['Id_unidad_base']); // Obtenemos el ID de unidad

                        $factor = 1;
                        if ($idUnidadBase == 2 || $idUnidadBase == 4) { // KG o Lt
                            $factor = 1000;
                        }

                        $tamanoRealEnGramos = $tamanoPaquete * $factor;

                        $costoInsumo = 0;
                        if ($tamanoRealEnGramos > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoRealEnGramos;
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

        // Calculos finales; Correción al calcular porcentaje
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

    // Elimina una receta y sus detalles, además maneja redirección inteligente dependiendo de dónde se hizo clic al borrar  ya sea en el Panel o en la Lista
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
