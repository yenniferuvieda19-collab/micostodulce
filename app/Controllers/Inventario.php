<?php

//Muchachos, creé este controlador temporal para probar la vista del inventario y ver que todo se esté creando bien
//Ya luego lo modifican para añadir las funciones principales y así

namespace App\Controllers;

class Inventario extends BaseController
{
    public function index()
    {
        // Por ahora envío un array vacío para que no de error el foreach
        $data['produccion'] = []; 
        return view('inventario/index', $data);
    }

    public function crear(){
        $recetaModel = new \App\Models\RecetaModel(); // Asegúrate de que el nombre del modelo sea correcto
    
        // Obtenemos solo las recetas del usuario activo
        $data['recetas'] = $recetaModel->where('Id_usuario', session()->get('id'))
                                    ->orderBy('nombre_postre', 'ASC')
                                    ->findAll();

        return view('inventario/crear', $data);
    }
}