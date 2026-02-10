<?php

//Muchachos, creé este controlador temporal para probar la vista del inventario y ver que todo se esté creando bien
//Ya luego lo modifican para añadir las funciones principales y así

namespace App\Controllers;

class Inventario extends BaseController
{
    public function index()
    {
         $inventarioModel=  new \App\Models\inventarioModel();


         $data['producciones'] = $inventarioModel->orderBy('fecha_produccion', 'DESC')->findAll();

        // Por ahora envío un array vacío para que no de error el foreach
       // $data['produccion'] = []; 
        return view('inventario/index', $data);
    }

    public function crear(){
        $recetaModel = new \App\Models\RecetaModel(); // Asegúrate de que el nombre del modelo sea correcto
    
        // Obtenemos solo las recetas del usuario activo
        $data['recetas'] = $recetaModel->where('Id_usuario', session()->get('Id_usuario'))
                                    ->orderBy('nombre_postre', 'ASC')
                                    ->findAll();

        return view('inventario/crear', $data);
    }

    public function guardar() {
    $recetaModel = new \App\Models\RecetaModel();
    $inventarioModel = new \App\Models\inventarioModel();

    // 1. Recibimos los datos del formulario
    $id_receta = $this->request->getPost('id_receta');
    $cantidad_nueva = $this->request->getPost('cantidad'); 
    $fecha = $this->request->getPost('fecha');
    $nombre_receta = $this->request->getPost('nombre_postre');

    // 2. Buscamos la receta base para obtener los costos unitarios actuales
    $receta = $recetaModel->find($id_receta);
    if (!$receta) {
        return redirect()->back()->with('error', 'Receta no encontrada');
    }

    // --- PASO CLAVE: VERIFICAR SI EXISTE EN LA TABLA PRODUCCIÓN ---
    $registroExistente = $inventarioModel->where('Id_receta', $id_receta)->first();

    if ($registroExistente) {
        // --- SI EXISTE: SUMAR ---
        
        // Sumamos la cantidad que ya había + la nueva
        $nueva_cantidad_total = $registroExistente['cantidad_producida'] + $cantidad_nueva;

        // Recalculamos los costos totales multiplicando el valor unitario por la nueva cantidad total
        $dataUpdate = [
            'cantidad_producida'    => $nueva_cantidad_total,
            'fecha_produccion'      => $fecha, // Actualizamos a la fecha más reciente de producción
            'costo_adicional_total' => $registroExistente['costo_adicional_total'] + $receta['precio_venta_sug'], 
            'costo_total_lote'      => $registroExistente['costo_total_lote'] + $receta['costo_ingredientes']
        ];

        // Actualizamos la fila existente usando su ID primario
        $inventarioModel->update($registroExistente['Id_produccion'], $dataUpdate);
        $mensaje = "Inventario actualizado: ahora tienes $nueva_cantidad_total porciones de {$receta['nombre_postre']}.";

    } else {
        // --- NO EXISTE: INSERTAR NUEVO ---
        
        $dataInsert = [
            'Id_receta'             => $id_receta,
            'nombre_receta'         => $receta['nombre_postre'],
            'cantidad_producida'    => $cantidad_nueva,
            'fecha_produccion'      => $fecha,
            'costo_adicional_total' => $receta['precio_venta_sug']  ,
            'costo_total_lote'      => $receta['costo_ingredientes'] 
        ];

        $inventarioModel->insert($dataInsert);
        $mensaje = '¡Producción registrada con éxito!';
    }

    return redirect()->to(base_url('inventario'))->with('mensaje', $mensaje);
}




    
}