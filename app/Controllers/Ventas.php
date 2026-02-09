<?php

namespace App\Controllers;
use App\Models\InventarioModel;
use App\Models\VentasModel;

// Usamos el BaseController para heredar funciones de CodeIgniter
class Ventas extends BaseController
{
    // Este método carga la página principal de ventas
    public function index()
    {
        // 1. Aquí más adelante llamaremos al modelo de ventas para traer el historial
        // Por ahora, enviamos un array vacío para que la vista no de error
        $data['ventas'] = []; 
        
        // 2. Cargamos la vista de la tabla de ventas
        return view('ventas/index', $data);
    }

    // Este método mostrará el formulario para registrar una venta nueva
    public function crear()
    //controlador de pruebaa, lo cambian según necesiten muchachos
{
    // Aquí llamamos al modelo de Inventario/Producción
    $inventarioModel = new InventarioModel();
    
    // Traemos solo lo que tenga porciones disponibles > 0
    $data['producciones'] = $inventarioModel->where('Id_usuario', session()->get('id'))
                                            ->where('porciones_disponibles >', 0)
                                            ->findAll();

    return view('ventas/crear', $data);
}

    public function detalle($id = null)
    {
    // Por ahora solo cargamos la vista para probar el botón
    return view('ventas/detalle'); 
    }
}