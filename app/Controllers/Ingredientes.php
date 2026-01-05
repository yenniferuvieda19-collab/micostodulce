<?php

namespace App\Controllers;

use App\Models\IngredienteModel;

class Ingredientes extends BaseController
{
    // Listar mis ingredientes
    public function index()
    {
        $model = new IngredienteModel();

        // Filtramos para ver SOLO lo que el usuario ha registrado
        $idUsuario = session()->get('Id_usuario');

        // Ordenamos alfabéticamente para que se vea ordenado
        $data['ingredientes'] = $model->where('Id_usuario', $idUsuario)
                                      ->orderBy('nombre_ingrediente', 'ASC')
                                      ->findAll();
        
        return view('ingredientes/index', $data);
    }

    // Mostrar formulario de registro
    public function crear()
    {
        return view('ingredientes/crear');
    }

    // La lógica matemática (Costo Unitario)
    public function guardar()
    {
        $model = new IngredienteModel();

        // Recibimos los datos
        $nombre   = $this->request->getPost('nombre');
        $precio   = $this->request->getPost('precio');
        $cantidad = $this->request->getPost('cantidad');
        $unidad   = $this->request->getPost('unidad_medida');

        // Lógica de conversión
        // Si es Kilogramos o Litros, multiplicamos por 1000 para guardar como gramos o mililitros
        // Si es Unidad (ejemplo, Huevos), multiplicamos por 1 (queda igual)
        
        $factor = 1; // Por defecto (gr, ml, unidad)

        if ($unidad == 'kg' || $unidad == 'lt') {
            $factor = 1000;
        }

        $cantidad_final = $cantidad * $factor;

        // Costo Unitario
        // Para Huevos: Precio / 24 (si es un carton de huevos)
        // Para Harina: Precio / 1000 (si es 1kg)
        $costo_u = ($cantidad_final > 0) ? ($precio / $cantidad_final) : 0;

        $datos = [
            'nombre_ingrediente' => $nombre, // ¡Nombre LIMPIO! Sin (KG)
            'cantidad_paquete'   => $cantidad_final, 
            'precio_compra'      => $precio,
            'Id_usuario'         => session()->get('Id_usuario'),
            'Id_unidad_base'     => 1, 
            'costo_unidad'       => $costo_u,
        ];

        if ($model->insert($datos)) {
            return redirect()->to(base_url('ingredientes'))->with('mensaje', 'Insumo registrado correctamente.');
        }

        return redirect()->back()->withInput()->with('error', 'Error al guardar.');
    }
}