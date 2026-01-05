<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;

class Recetas extends BaseController
{
    // Muestra las recetas del usuario
    public function index()
    {
        $model = new RecetaModel();
        
        // Obtenemos el ID del usuario que está logueado
        $idUsuario = session()->get('Id_usuario');
        
        // Buscamos SOLO las recetas que tengan ese ID
        $data['recetas'] = $model->where('Id_usuario', $idUsuario)->findAll();
        
        return view('recetas/index', $data);
    }

    // Muestra el formulario de crear (Carga los ingredientes)
    public function crear()
    {
        $ingModel = new IngredienteModel();
        
        $idUsuario = session()->get('Id_usuario');
        
        $data['ingredientes'] = $ingModel->where('Id_usuario', $idUsuario)->findAll();
        
        return view('recetas/crear', $data);
    }

    // La lógica matemática
    public function guardar()
    {
        $recetaModel = new RecetaModel();
        $ingModel    = new IngredienteModel(); 
        
        // Instancia genérica para guardar en la tabla intermedia (ingredientes_recetas)
        $detalleModel = new \CodeIgniter\Model(); 
        $detalleModel->setTable('ingredientes_recetas');

        // Recibimos los datos del HTML
        $ingredientesIds = $this->request->getPost('ingrediente_id'); // Lista de IDs
        $cantidades      = $this->request->getPost('cantidades');     // Lista de cantidades
        $margen_ganancia = 0.50; // 50% de ganancia (Fijo por ahora)

        $idUsuario = session()->get('Id_usuario');

        // Creamos la receta "vacía" primero
        $dataReceta = [
            'Id_usuario'    => $idUsuario,
            'nombre_postre' => $this->request->getPost('nombre'),
            'porciones'     => $this->request->getPost('porciones'),
            'costo_ingredientes' => 0, // Se calculará abajo
            'precio_venta_sug'   => 0  // Se calculará abajo
        ];
        
        // Guardamos y obtenemos el ID de la receta nueva (ej: Receta #01)
        $idReceta = $recetaModel->insert($dataReceta, true);

        // Bucle
        $costoTotalReceta = 0; // Acumulador

        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                // Verificamos que no hayan campos vacíos
                if (!empty($idIng) && !empty($cantidades[$index]) && $cantidades[$index] > 0) {
                    
                    // Buscamos el precio de ese ingrediente en la BD
                    $infoIngrediente = $ingModel->find($idIng);
                    
                    if ($infoIngrediente) {
                        $costoUnitario = $infoIngrediente['costo_unidad'];
                        $cantidadUsada = $cantidades[$index];

                        // Fórmula 1: Costo = Precio x Cantidad
                        $costoInsumo = $costoUnitario * $cantidadUsada;

                        // Sumamos al total
                        $costoTotalReceta += $costoInsumo;

                        // Guardamos el detalle en la BD (Tabla intermedia)
                        $detalleModel->insert([
                            'Id_receta'          => $idReceta,
                            'Id_ingrediente'     => $idIng,
                            'cantidad_requerida' => $cantidadUsada,
                            'unidad_receta'      => 'unidad' 
                        ]);
                    }
                }
            }
        }

        // Cálculo final del precio
        // Precio Venta = Costo + (Costo * 0.50)
        $precioVenta = $costoTotalReceta + ($costoTotalReceta * $margen_ganancia);

        // Actualizamos la receta con la información final
        $recetaModel->update($idReceta, [
            'costo_ingredientes' => $costoTotalReceta,
            'precio_venta_sug'   => $precioVenta
        ]);

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta calculada correctamente.');
    }
}