<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;

class Recetas extends BaseController
{
    public function index()
    {
        $model = new RecetaModel();
    
        $data['recetas'] = $model->where('Id_usuario', 1)->findAll();
        return view('recetas/index', $data);
    }

    public function crear()
    {
        $ingModel = new IngredienteModel();
        // Pasamos los ingredientes a la vista para el selector dinámico
        $data['ingredientes'] = $ingModel->findAll();
        return view('recetas/crear', $data);
    }

    public function guardar()
    {
        $recetaModel = new RecetaModel();
        // Para guardar el detalle de cada ingrediente necesitamos este modelo 
        $detalleModel = new \CodeIgniter\Model(); 
        $detalleModel->setTable('ingredientes_recetas');

      
        $costoMateriales = 0;
        $ingredientesIds = $this->request->getPost('ingrediente_id');
        $cantidades = $this->request->getPost('cantidades');

        //guardamos la cabecera de la receta
        $dataReceta = [
            'Id_usuario'    => 1,
            'nombre_postre' => $this->request->getPost('nombre'),
            'porciones'     => $this->request->getPost('porciones'),
        ];
        
        $idReceta = $recetaModel->insert($dataReceta, true);

        //  Guardamos cada ingrediente en la tabla 'ingredientes_recetas'
        if ($ingredientesIds) {
            foreach ($ingredientesIds as $index => $idIng) {
                if (!empty($idIng)) {
                    $detalleModel->insert([
                        'Id_receta'          => $idReceta,
                        'Id_ingrediente'     => $idIng,
                        'cantidad_requerida' => $cantidades[$index],
                        'unidad_receta'      => 'unidad' 
                    ]);
                }
            }
        }

        return redirect()->to(base_url('recetas'))->with('mensaje', 'Receta guardada con materiales');
    }
}