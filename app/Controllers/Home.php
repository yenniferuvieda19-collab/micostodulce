<?php

namespace App\Controllers;

use App\Models\IngredienteModel;
use App\Models\RecetaModel;

class Home extends BaseController
{
    public function index()
    {
        // Verificamos si hay sesión iniciada
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('Id_usuario');

        // Conectamos con los modelos
        $ingModel = new IngredienteModel();
        $recetaModel = new RecetaModel();

        // Contamos cuántos registros tiene este usuario
        $data['totalIngredientes'] = $ingModel->where('Id_usuario', $userId)->countAllResults();
        $data['totalRecetas']      = $recetaModel->where('Id_usuario', $userId)->countAllResults();

        // Buscamos las últimas 3 recetas para mostrarlas
        $data['ultimasRecetas'] = $recetaModel->where('Id_usuario', $userId)
            ->orderBy('Id_receta', 'DESC')
            ->findAll(3);

        // Cargar la vista nueva
        return view('panel_inicio', $data);
    }
}
