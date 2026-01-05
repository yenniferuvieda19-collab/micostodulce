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
        $unidad   = $this->request->getPost('unidad_medida'); // Recibe: 'gr', 'kg', 'ml', 'lt', 'unidad'

        // Lógica de conversión y códigos
        $factor = 1; 
        $codigoUnidad = 1; // Por defecto 1 (gr, ml, unidad)

        // Asignamos el código según lo que eligió el usuario
        switch ($unidad) {
            case 'kg':
                $factor = 1000;      // Multiplicamos por 1000
                $codigoUnidad = 2;   // Código 2 para Kilos
                break;
            case 'lt':
                $factor = 1000;      // Multiplicamos por 1000
                $codigoUnidad = 4;   // Código 4 para Litros
                break;
            case 'ml':
                $codigoUnidad = 3;   // Código 3 para ml
                break;
            case 'unidad':
                $codigoUnidad = 5;   // Código 5 para Unidades
                break;
            default: // 'gr'
                $codigoUnidad = 1;   // Código 1 para Gramos
                break;
        }

        // Convertimos la cantidad a la base estándar (gr/ml) para el cálculo matemático
        $cantidad_final = $cantidad * $factor;

        // Costo Unitario
        // Evitamos división por cero
        $costo_u = ($cantidad_final > 0) ? ($precio / $cantidad_final) : 0;

        $datos = [
            'nombre_ingrediente' => $nombre, // ¡Nombre LIMPIO! Sin (KG)
            'cantidad_paquete'   => $cantidad_final, 
            'precio_compra'      => $precio,
            'Id_usuario'         => session()->get('Id_usuario'),
            'Id_unidad_base'     => $codigoUnidad,
            'costo_unidad'       => $costo_u,
        ];

        if ($model->insert($datos)) {
            return redirect()->to(base_url('ingredientes'))->with('mensaje', 'Insumo registrado correctamente.');
        }

        return redirect()->back()->withInput()->with('error', 'Error al guardar.');
    }
}