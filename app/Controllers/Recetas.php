<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\IngredientesRecetasModel;

class Recetas extends BaseController
{
    // Muestra las recetas del usuario
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

    // Muestra el formulario de crear
    public function crear()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $ingModel = new IngredienteModel();
        $idUsuario = session()->get('Id_usuario');

        // Filtramos ingredientes con costo > 0.01 y ordenamos
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)
            ->where('costo_unidad >', 0.01)
            ->orderBy('nombre_ingrediente', 'ASC')
            ->findAll();

        return view('recetas/crear', $data);
    }

    // Guardar
    public function guardar()
    {
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();
        $detalleModel = new IngredientesRecetasModel();

        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades      = $this->request->getPost('cantidades');
        $inputGanancia   = $this->request->getPost('ganancia');

        // Lógica de ganancia
        $gananciaReal    = ($inputGanancia > 0) ? $inputGanancia : 30;
        $margen_ganancia = $gananciaReal / 100;

        $idUsuario = session()->get('Id_usuario');

        // Guardar cabecera
        $dataReceta = [
            'Id_usuario'          => $idUsuario,
            'nombre_postre'       => $this->request->getPost('nombre'),
            'porciones'           => $this->request->getPost('porciones'),
            'costo_ingredientes'  => 0,
            'precio_venta_sug'    => 0,
            'porcentaje_ganancia' => $gananciaReal
        ];

        $idReceta = $recetaModel->insert($dataReceta, true);

        // Procesar ingredientes
        $costoTotalReceta = 0;

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {

                    $infoIngrediente = $ingModel->find($idIng);

                    if ($infoIngrediente) {
                        $precioPaquete  = floatval($infoIngrediente['costo_unidad']);
                        $tamanoPaquete  = floatval($infoIngrediente['cantidad_paquete']);
                        $cantidadUsada  = floatval($cantidades[$index]);

                        $costoInsumo = 0;
                        if ($tamanoPaquete > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoPaquete;
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

        // Cálculos finales
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

    // Editar y mostrar formulario
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

    // Actualizar y guardar cambios
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

                        $costoInsumo = 0;
                        if ($tamanoPaquete > 0) {
                            $costoUnitarioReal = $precioPaquete / $tamanoPaquete;
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
            'porcentaje_ganancia' => $gananciaReal
        ]);

        $detalleModel->where('Id_receta', $id)->delete();

        if (!empty($detallesNuevos)) {
            $detalleModel->insertBatch($detallesNuevos);
        }

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta actualizada exitosamente.');
    }

    // Borrar
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
