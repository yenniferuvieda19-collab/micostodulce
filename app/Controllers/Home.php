<?php

namespace App\Controllers;

use App\Models\IngredienteModel;
use App\Models\RecetaModel;

class Home extends BaseController
{
    //Muestra el Dashboard principal con el resumen del negocio y la guía de inicio
    public function index()
    {
        //Control de acceso: Verifica si el usuario está logueado
        if (!session()->get("isLoggedIn")) {
            return redirect()->to(base_url('login'));
        }

        //Inicialización de modelos e identificación de usuario
        $ingredientesModel = new IngredienteModel();
        $recetasModel = new RecetaModel();
        $idUsuario = session()->get('Id_usuario');

        $totalIngredientes = $ingredientesModel->where('Id_usuario', $idUsuario)->countAllResults();
        $totalRecetas = $recetasModel->where('Id_usuario', $idUsuario)->countAllResults();

        // La guía se muestra solo si el usuario aún no tiene recetas creadas
        $mostrarGuia = ($totalRecetas == 0);
        $pasoActual = 1;
        $porcentajeProgreso = 10; // Estado inicial

        // Si ya registró al menos un insumo, avanzamos al paso 2
        if ($totalIngredientes > 0) {
            $pasoActual = 2;
            $porcentajeProgreso = 50;
        }

        // Si ya completó su primera receta, el progreso es total
        if ($totalRecetas > 0) {
            $pasoActual = 3; // Paso "completado"
            $porcentajeProgreso = 100;
        }

        session()->set('pasoActual', $pasoActual);

        $data = [
            'totalIngredientes'  => $totalIngredientes,
            'totalRecetas'       => $totalRecetas,
            'mostrarGuia'        => $mostrarGuia,
            'pasoActual'         => $pasoActual,
            'porcentajeProgreso' => $porcentajeProgreso,
            'ultimasRecetas'     => $recetasModel->where('Id_usuario', $idUsuario)
                                                 ->orderBy('Id_receta', 'DESC')
                                                 ->findAll(5)
        ];

        return view('panel_inicio', $data);
    }
}