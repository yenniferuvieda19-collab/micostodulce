<?php

namespace App\Controllers;

use App\Models\GastoAdicionalModel;

class Gastos extends BaseController
{
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

    public function guardar()
    {
        $model = new GastoAdicionalModel();

        // Recibimos los datos básicos
        $esPaquete = $this->request->getPost('es_paquete'); // Será "1" o null
        $costoUnitarioFinal = 0;

        // Calculadora inteligente
        if ($esPaquete == 1) {
            // Si es por paquete dividimos Costo Total / Cantidad del Paquete
            $costoPaquete = $this->request->getPost('costo_paquete');
            $cantidad = $this->request->getPost('cantidad_paquete');

            // Evitamos dividir por cero
            if ($cantidad > 0) {
                $costoUnitarioFinal = $costoPaquete / $cantidad;
            } else {
                $costoUnitarioFinal = 0;
            }
        } else {
            // Si es por unidad tomamos el precio directo
            $costoUnitarioFinal = $this->request->getPost('precio_unitario');
        }

        // Preparamos los datos para guardar
        $datos = [
            'Id_usuario'       => session()->get('Id_usuario'),
            'nombre_gasto'     => $this->request->getPost('nombre_gasto'),
            'categoria'        => $this->request->getPost('categoria'),
            'es_paquete'       => $esPaquete ?? 0,
            'costo_paquete'    => $this->request->getPost('costo_paquete') ?? 0,
            'cantidad_paquete' => $this->request->getPost('cantidad_paquete') ?? 1,
            'precio_unitario'  => $costoUnitarioFinal // Aquí guardamos el resultado de la división
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
}
