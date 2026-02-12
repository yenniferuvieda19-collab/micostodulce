<?php

namespace App\Controllers;

use App\Models\GastoAdicionalModel;

class Gastos extends BaseController
{
    // Lista los Costos Indirectos (Cajas, Servicios, Mano de Obra).
    public function index()
    {
        // Verificar si está logueado
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // Traer los gastos del usuario
        $model = new GastoAdicionalModel();
        $data['gastos'] = $model->getGastosPorUsuario(session()->get('Id_usuario'));

        return view('gastos/index', $data);
    }

    public function crear()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('gastos/crear');
    }

    // Guarda un nuevo gasto. Incluye lógica para calcular costo unitario si el usuario ingresa un paquete
    public function guardar()
    {
        $model = new GastoAdicionalModel();

        // Verificamos el switch: 
        // Si viene '1', es Fijo ($). Si no viene nada, es Porcentaje (%).
        $esFijo = $this->request->getPost('es_fijo') ? 1 : 0;
        
        // El valor que escribió el usuario (puede ser 10% o $10)
        $valorIngresado = $this->request->getPost('valor_gasto');

       $datos = [
            'Id_usuario'      => session()->get('Id_usuario'),
            'nombre_gasto'    => $this->request->getPost('nombre_gasto'),
            'categoria'       => $this->request->getPost('categoria'),
            'es_fijo'         => $esFijo, // 1 = Dólar, 0 = Porcentaje
            'precio_unitario' => $this->request->getPost('valor_gasto'),
            'es_paquete'      => 0,
            'cantidad_paquete'=> 1
        ];

        $model->save($datos);
        return redirect()->to('gastos')->with('mensaje', 'Gasto guardado correctamente.');
    }

    public function borrar($id = null)
    {
        $model = new GastoAdicionalModel();

        // Por seguridad vamos a verificar que el gasto pertenezca al usuario antes de borrar
        $gasto = $model->find($id);

        if ($gasto && $gasto['Id_usuario'] == session()->get('Id_usuario')) {
            $model->delete($id);
            return redirect()->to('gastos')->with('mensaje', 'Gasto eliminado.');
        }

        return redirect()->to('gastos')->with('error', 'No se pudo eliminar el gasto.');
    }

    // Cargar formulario de edición
    public function editar($id = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $model = new GastoAdicionalModel();
        $gasto = $model->find($id);

        // Verificar que el gasto exista y sea del usuario
        if (!$gasto || $gasto['Id_usuario'] != session()->get('Id_usuario')) {
            return redirect()->to('gastos')->with('error', 'Gasto no encontrado.');
        }

        $data['gasto'] = $gasto;
        return view('gastos/editar', $data);
    }

    // Actualizar los cambios en los gasto
    public function actualizar($id = null)
    {
        $model = new GastoAdicionalModel();
        
        // Recibimos el Switch si está marcado "on", vale 1 (Dólares) Si no, vale 0 (Porcentaje)
        $esFijo = $this->request->getPost('es_fijo') ? 1 : 0;

        $datos = [
            'nombre_gasto'    => $this->request->getPost('nombre_gasto'),
            'categoria'       => $this->request->getPost('categoria'),
            
            // Guardamos la lógica nueva ($ o %)
            'es_fijo'         => $esFijo,
            
            // Guardamos el valor (sea 15% o $3.00)
            'precio_unitario' => $this->request->getPost('valor_gasto')
        ];

        $model->update($id, $datos);

        return redirect()->to('gastos')->with('mensaje', 'Gasto actualizado correctamente.');
    }
}