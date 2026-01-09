<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\IngredientesRecetasModel;

class Recetas extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $model = new RecetaModel();
        $idUsuario = session()->get('Id_usuario');

        $data['recetas'] = $model->where('Id_usuario', $idUsuario)->findAll();

        return view('recetas/index', $data);
    }

    // Función crear
    public function crear()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $ingModel = new IngredienteModel();
        $idUsuario = session()->get('Id_usuario');

        // Filtro: solo ingredientes con precio > 0.01
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.01)
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        return view('recetas/crear', $data);
    }

    // Función guardar
    public function guardar()
    {
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();
        $detalleModel = new IngredientesRecetasModel();

        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades      = $this->request->getPost('cantidades');
        $inputGanancia   = $this->request->getPost('ganancia');

        $gananciaReal    = ($inputGanancia > 0) ? $inputGanancia : 30;
        $margen_ganancia = $gananciaReal / 100;

        $idUsuario = session()->get('Id_usuario');

        // Guardar Cabecera
        $dataReceta = [
            'Id_usuario'          => $idUsuario,
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => 0,
            'precio_venta_sug'    => 0,
            'porcentaje_ganancia' => $gananciaReal,
            'notas'               => $this->request->getPost('notas')
        ];

        $idReceta = $recetaModel->insert($dataReceta, true);

        // Procesar Ingredientes
        $costoTotalReceta = 0;

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
                        $precioPaquete  = floatval($infoIngrediente['costo_unidad']);
                        $tamanoPaquete  = floatval($infoIngrediente['cantidad_paquete']);
                        $cantidadUsada  = floatval($cantidades[$index]);
                        $idUnidadBase   = intval($infoIngrediente['Id_unidad_base']);

                        // Lógica de conversión
                        // Si es KG (2) o Litro (4), multiplicamos el tamaño del paquete por 1000
                        $factor = 1;
                        if ($idUnidadBase == 2 || $idUnidadBase == 4) {
                            $factor = 1000;
                        }

                        $tamanoRealEnGramos = $tamanoPaquete * $factor;

                        $costoInsumo = 0;
                        if ($tamanoRealEnGramos > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoRealEnGramos;
                            $costoInsumo = $costoUnitarioReal * $cantidadUsada;
                        }

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

        // Calculos finales
        $precioVenta = 0;
        if ($margen_ganancia < 0.99) {
            $precioVenta = $costoTotalReceta / (1 - $margen_ganancia);
        } else {
            $precioVenta = $costoTotalReceta * (1 + $margen_ganancia);
        }

        $recetaModel->update($idReceta, [
            'costo_ingredientes' => $costoTotalReceta,
            'precio_venta_sug'   => $precioVenta
        ]);

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta creada exitosamente.');
    }

    // Muestra la ficha técnica de solo olo lectura
    public function ver($id = null)
    {
        if (!session()->get('isLoggedIn')) { return redirect()->to('login'); }

        $recetaModel  = new RecetaModel();
        $detalleModel = new IngredientesRecetasModel();
        
        $data['receta'] = $recetaModel->find($id);

        if (!$data['receta']) {
            return redirect()->to(base_url('recetas'))->with('error', 'Receta no encontrada');
        }

        $data['detalles'] = $detalleModel->select('ingredientes_recetas.*, ingredientes.nombre_ingrediente, ingredientes.Id_unidad_base')
                                         ->join('ingredientes', 'ingredientes.Id_ingrediente = ingredientes_recetas.id_ingrediente')
                                         ->where('ingredientes_recetas.Id_receta', $id)
                                         ->findAll();

        return view('recetas/VerReceta', $data); 
    }

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

        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.01)
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        $data['detalles'] = $detalleModel->where('Id_receta', $id)->findAll();

        return view('recetas/editar', $data);
    }

    // Función actualizar
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

        $costoTotalReceta = 0;
        $detallesNuevos = [];

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
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

        // Cálculos Finales
        $precioVenta = 0;
        if ($margen_ganancia < 0.99) {
            $precioVenta = $costoTotalReceta / (1 - $margen_ganancia);
        } else {
            $precioVenta = $costoTotalReceta * (1 + $margen_ganancia);
        }

        $recetaModel->update($id, [
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => $costoTotalReceta,
            'precio_venta_sug'    => $precioVenta,
            'porcentaje_ganancia' => $gananciaReal,
            'notas'               => $this->request->getPost('notas')
        ]);

        $detalleModel->where('Id_receta', $id)->delete();

        if (!empty($detallesNuevos)) {
            $detalleModel->insertBatch($detallesNuevos);
        }

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta actualizada exitosamente.');
    }

    public function borrar($id = null)
    {
        $recetaModel = new RecetaModel();
        $detalleModel = new IngredientesRecetasModel();

        if ($id) {
            $detalleModel->where('Id_receta', $id)->delete();
            $recetaModel->delete($id);
        }

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta eliminada correctamente.');
    }
}
