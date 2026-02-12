<?php

namespace App\Controllers;

use App\Models\inventarioModel;
use App\Models\RecetaModel;

class Inventario extends BaseController
{
    //  LISTAR INVENTARIO (Con JOIN para ver los nombres)
    public function index()
    {
        $inventarioModel = new inventarioModel();
        
        // Unimos la tabla 'produccion' con 'recetas' para traer 'nombre_postre'
        $data['producciones'] = $inventarioModel->select('produccion.*, recetas.nombre_postre')
            ->join('recetas', 'recetas.Id_receta = produccion.Id_receta', 'left')
            ->orderBy('fecha_produccion', 'DESC')
            ->findAll();

        return view('inventario/index', $data);
    }

    //  FORMULARIO DE NUEVA PRODUCCIÓN
    public function crear()
    {
        $recetaModel = new RecetaModel();
        
        $data['recetas'] = $recetaModel->where('Id_usuario', session()->get('Id_usuario'))
                                     ->orderBy('nombre_postre', 'ASC')
                                     ->findAll();

        return view('inventario/crear', $data);
    }

    //  GUARDAR O ACTUALIZAR PRODUCCIÓN
    public function guardar() 
    {
        $recetaModel = new RecetaModel();
        $inventarioModel = new inventarioModel();

        $id_receta = $this->request->getPost('id_receta');
        $cantidad_nueva = $this->request->getPost('stock_disponible'); 
        $fecha = date('Y-m-d');
        $idUsuario= session()->get('Id_usuario');
       // $idUsuario = $this->request->getPost('Id_usuario'); 

        $receta = $recetaModel->find($id_receta);
        if (!$receta) {
            return redirect()->back()->with('error', 'Receta no encontrada');
        }
         
        $costo_unitario = $receta['precio_venta_sug'] / $cantidad_nueva;

        $registroExistente = $inventarioModel->where('Id_receta', $id_receta)->first();

        if ($registroExistente) {
            $nueva_cantidad_total = $registroExistente['cantidad_producida'] + $cantidad_nueva;

            $dataUpdate = [
                'Id_usuario'            => $idUsuario,
                'cantidad_producida'    => $nueva_cantidad_total,
                'fecha_produccion'      => $fecha, 
                'costo_adicional_total' => $registroExistente['costo_adicional_total'] + ($receta['precio_venta_sug'] ), 
                'costo_total_lote'      => $registroExistente['costo_total_lote'] + ($receta['costo_ingredientes'] ),
                'costo_unitario'        => $costo_unitario // Se sobrescribe con el valor actual, no se suma
            ];

            $inventarioModel->update($registroExistente['Id_produccion'], $dataUpdate);
          $mensaje = "Inventario actualizado: ahora tienes $nueva_cantidad_total porciones de {$receta['nombre_postre']}.";
        } else {
            $dataInsert = [
                'Id_usuario'            => $idUsuario,
                'Id_receta'             => $id_receta,
                'nombre_receta'         => $receta['nombre_postre'],
                'cantidad_producida'    => $cantidad_nueva,
                'fecha_produccion'      => $fecha,
                'costo_adicional_total' => $receta['precio_venta_sug'] ,
                'costo_total_lote'      => $receta['costo_ingredientes'] ,
                'costo_unitario'        => $costo_unitario //  Se guarda por primera vez
            ];

            $inventarioModel->insert($dataInsert);
            $mensaje = '¡Producción registrada con éxito!';
        }

        return redirect()->to(base_url('inventario'))->with('mensaje', $mensaje);
    }

    // VER DETALLES
    public function ver($id)
    {
        $inventarioModel = new inventarioModel();
        $data['p'] = $inventarioModel->select('produccion.*, recetas.nombre_postre')
            ->join('recetas', 'recetas.Id_receta = produccion.Id_receta', 'left')
            ->find($id);

        if (!$data['p']) {
            return redirect()->to(base_url('inventario'))->with('error', 'No se encontró el registro.');
        }

        return view('inventario/ver', $data);
    }

    // ELIMINAR
    public function eliminar($id)
    {
        $inventarioModel = new inventarioModel();
        if ($inventarioModel->delete($id)) {
            return redirect()->to(base_url('inventario'))->with('mensaje', 'Registro eliminado.');
        }
        return redirect()->to(base_url('inventario'))->with('error', 'No se pudo eliminar.');
    }
}