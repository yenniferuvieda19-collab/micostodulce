<?php

namespace App\Controllers;

use App\Models\IngredienteModel;
use App\Models\RecetaModel;

class Home extends BaseController
{
    /**
     * Muestra el Dashboard principal con el resumen del negocio y la guía de inicio
     */
    public function index()
    {
        // 1. Control de acceso: Verificar si el usuario está logueado
        if (!session()->get("isLoggedIn")) {
            return redirect()->to(base_url('login'));
        }

        // 2. Inicialización de modelos e identificación de usuario
        $ingredientesModel = new IngredienteModel();
        $recetasModel = new RecetaModel();
        $idUsuario = session()->get('Id_usuario');

        // 3. Obtención de métricas en tiempo real
        $totalIngredientes = $ingredientesModel->where('Id_usuario', $idUsuario)->countAllResults();
        $totalRecetas = $recetasModel->where('Id_usuario', $idUsuario)->countAllResults();

        // 4. Lógica de Onboarding (Pasos del usuario)
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

        // 5. Sincronización con la sesión (opcional, para uso en otras vistas)
        session()->set('pasoActual', $pasoActual);

        // 6. Preparación de datos para la vista
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