<?php

namespace App\Controllers;
use App\Models\InventarioModel;
use App\Models\VentaModel;


// Usamos el BaseController para heredar funciones de CodeIgniter
class Ventas extends BaseController
{
    // Este método carga la página principal de ventas
    public function index()
    {
        $ventaModel = new VentaModel;
        //  Aquí más adelante llamaremos al modelo de ventas para traer el historial
        // Por ahora, enviamos un array vacío para que la vista no de error
        $data['ventas'] = $ventaModel->where('Id_usuario', session()->get('Id_usuario'))
                                 ->orderBy('fecha_venta', 'DESC')
                                 ->findAll();
        
        //  Cargamos la vista de la tabla de ventas
        return view('ventas/index', $data);
    }

    // Este método mostrará el formulario para registrar una venta nueva
    public function crear()
    //controlador de pruebaa, lo cambian según necesiten muchachos
{
    // Aquí llamamos al modelo de Inventario/Producción
    $inventarioModel = new InventarioModel();
    
    // Traemos solo lo que tenga porciones disponibles > 0
    $data['producciones'] = $inventarioModel -> where('Id_usuario', session()->get('Id_usuario'))
                                            ->where('cantidad_producida >', 0)
                                            ->findAll();

    return view('ventas/crear', $data);
}



    public function guardar(){
 
    $ventaModel = new VentaModel();
    $inventarioModel = new InventarioModel();
    

    
    $IdProduccion = $this->request->getVar('id_inventario');
    $idUsuario   = session()->get('Id_usuario');
    $CantidadVendida=$this->request->getPost('vendidas');
    $PrecioUnitario=$this->request->getPost('precio_unitario');
    $VentaTotal=$this->request->getPost('precio_total');
    $fecha = date('Y-m-d');


    //  Buscamos el registro actual en la tabla de Producción
    $registroInventario = $inventarioModel ->find($IdProduccion);
                                         
    
   

    // Si esto sale, es que el modelo no está trayendo la columna
    /*if (!isset($registroInventario['cantidad_producida'])) {
        return redirect()->back()->with('error', 'Error interno: No se pudo leer el stock de la base de datos.');
    }*/

    if (!$registroInventario) {
        return redirect()->back()->with('error', 'El registro de inventario no existe.');
    }

    
    $NombrePostre = $registroInventario['nombre_receta'];

    //  Verificamos si hay stock suficiente
    if ($registroInventario['cantidad_producida'] < $CantidadVendida) {
        return redirect()->back()->with('error', 'No tienes suficientes unidades. Stock actual: ' . $registroInventario['cantidad_producida']);
    }

   

    // Restamos las unidades del stock
    $nuevo_stock = $registroInventario['cantidad_producida'] - $CantidadVendida;

    // Restamos el valor proporcional del costo adicional total
    // (Total actual - Total de lo que se acaba de vender)
    $nuevo_costo_adicional = $registroInventario['costo_adicional_total'] - $VentaTotal;

    //  Actualizamos la tabla de PRODUCCIÓN
    $inventarioModel->update($IdProduccion, [
        'cantidad_producida'    => $nuevo_stock,
        'costo_adicional_total' => $nuevo_costo_adicional
    ]);
                                
    //  Insertamos el registro en la tabla de VENTAS para el historial
    $ventaModel->insert([
        'nombre_receta'   => $NombrePostre,
        'Id_usuario'         => $idUsuario,
        'Id_produccion'          => $IdProduccion,
        'cantidad_vendida'   => $CantidadVendida,
        'precio_unitario'    => $PrecioUnitario,
        'precio_venta_total' => $VentaTotal,
        'fecha_venta'        => date('Y-m-d')
    ]);      

    return redirect()->to(base_url('ventas'))->with('mensaje', 'Venta registrada e inventario actualizado.');
}
    

   public function detalle($id = null)
    {
        $ventaModel = new VentaModel();

        // busco la venta específica por su ID
        $venta = $ventaModel->find($id);

        // si no existe el ID o no hay registro, mandamos al index con error
        if (!$venta) {
            return redirect()->to(base_url('ventas'))->with('error', 'No se encontró el registro de la venta.');
        }

        // paso los datos a la vista.
        $data['venta'] = $venta;

        return view('ventas/detalles', $data); 
    }

    public function eliminar($id = null)
    {
        $ventaModel = new VentaModel();
        
        // vwerifico que la venta exista y pertenezca al usuario logueado por seguridad
        $venta = $ventaModel->where('Id_venta', $id)
                            ->where('Id_usuario', session()->get('Id_usuario'))
                            ->first();

        if (!$venta) {
            return redirect()->to(base_url('ventas'))->with('error', 'Registro no encontrado o no tienes permiso.');
        }

        //se eejecuta la la eliminación
        if ($ventaModel->delete($id)) {
            return redirect()->to(base_url('ventas'))->with('mensaje', 'El registro de venta ha sido eliminado.');
        } else {
            return redirect()->to(base_url('ventas'))->with('error', 'No se pudo eliminar el registro.');
        }
    }

}




