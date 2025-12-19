<?php

namespace App\Controllers;

use App\Models\IngredienteModel;

class Ingredientes extends BaseController
{
    /**
     * Muestra el listado principal de insumos registrados
     */
    public function index()
    {
        $model = new IngredienteModel();
        
        // Se ordena por nombre_ingrediente según la estructura SQL importada
        $data['ingredientes'] = $model->orderBy('nombre_ingrediente', 'ASC')->findAll();
        
        return view('ingredientes/index', $data);
    }

    /**
     * Carga la vista del formulario para registrar un nuevo insumo
     * Este es el método que causaba el error 404
     */
    public function crear()
    {
        return view('ingredientes/crear');
    }

    /**
     * Procesa la inserción de datos en la tabla 'ingredientes'
     */
    public function guardar()
    {
        $model = new IngredienteModel();

        // Cálculo de costo unitario basado en precio de compra y cantidad del paquete
        $precio   = $this->request->getPost('precio');
        $cantidad = $this->request->getPost('cantidad');
        $costo_u  = ($cantidad > 0) ? ($precio / $cantidad) : 0;

        $datos = [
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'cantidad_paquete'   => $cantidad,
            'precio_compra'      => $precio,
            'Id_usuario'         => 1, // @todo: Integrar con session()->get('Id_usuario')
            'Id_unidad_base'     => 1, // @todo: Implementar catálogo de unidades de conversión
            'costo_unidad'       => $costo_u,
        ];

        if ($model->insert($datos)) {
            return redirect()->to(base_url('ingredientes'))->with('mensaje', 'Insumo guardado correctamente.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo registrar el ingrediente.');
    }
}