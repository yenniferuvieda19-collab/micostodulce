<?php

namespace App\Controllers;

use App\Models\inventarioModel;
use App\Models\RecetaModel;

class Inventario extends BaseController
{
    //  listo inventario (Con join para ver los nombres)
    public function index()
    {
        $inventarioModel = new inventarioModel();
        $idUsuario = session()->get('Id_usuario'); //Con esto obtengo el ID del usuario logueado
        
        //Agrego el where para filtrar solo la búsqueda de recetas del usuario logueado, así corrijo el error de anyel. 
        // También uno la tabla 'produccion' con 'recetas' para traer 'nombre_postre'
        $data['producciones'] = $inventarioModel->select('produccion.*, recetas.nombre_postre')
            ->join('recetas', 'recetas.Id_receta = produccion.Id_receta', 'left')
            ->where ('produccion.Id_usuario', $idUsuario) //Aquí agregué el filtro chicosss
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

    //  función para guardar o registrar producción
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

        /*Modifiqué esta línea Anyel, para que pueda filtrar que la receta de producción que estoy obteniendo al
        actualizar, sea la misma de mi usuario, o sea, evito que sin querer modifique la de otro usuario por
        estar en la misma base de datos.*/
        $registroExistente = $inventarioModel->where('Id_receta', $id_receta)
                                     ->where('Id_usuario', $idUsuario) //Aquí me aseguro que coincida con la producción de mi usuario 
                                     ->first();

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

    // Ver detalles
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

    // eliminar
    public function eliminar($id)
{
    $inventarioModel = new inventarioModel();

    try {
        // Intentamos borrar el registro
        if ($inventarioModel->delete($id)) {
            return redirect()->to(base_url('inventario'))->with('mensaje', 'Registro eliminado correctamente.');
        }
        
        return redirect()->to(base_url('inventario'))->with('error', 'No se pudo encontrar el registro para eliminar.');

    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
        // Verificamos si el error es por la restricción de llave foránea (Error 1451)
        if (strpos($e->getMessage(), '1451') !== false) {
            return redirect()->to(base_url('inventario'))->with('error', 'No puedes eliminar esta producción porque ya tiene ventas registradas asociadas.');
        }

        // Si es otro tipo de error de base de datos
        return redirect()->to(base_url('inventario'))->with('error', 'no puedes borrar este registro porque tienes ventas de esta produccion.');
    }
}
}