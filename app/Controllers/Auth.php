<?php

namespace App\Controllers;

use App\Models\UsuarioModel; // @todo: Crear modelo para la tabla 'usuarios'

class Auth extends BaseController
{
    /**
     * Muestra la vista de inicio de sesión personalizada
     */
    public function login()
    {
        // Se carga la vista ubicada en app/Views/auth/login.php
        return view('auth/login');
    }

    /**
     * Validación de credenciales contra la tabla 'usuarios'
     */
    public function ingresar()
    {
        $session = session();
        $model = new UsuarioModel();
        
        // Mapeo según columnas SQL: Correo y Contraseña
        $correo = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('Correo', $correo)->first();

        if ($user && password_verify($password, $user['Contraseña'])) {
            $session->set([
                'Id_usuario' => $user['Id_usuario'],
                'isLoggedIn' => true
            ]);
            return redirect()->to(base_url('ingredientes'));
        }

        return redirect()->back()->with('error', 'Credenciales inválidas.');
    }

   public function salir()
{
    session()->destroy(); // Limpia la mesa de trabajo
    // Redirige al login con un mensaje de despedida
    return redirect()->to(base_url('login'))->with('mensaje', '¡Sesión cerrada! Gracias por trabajar en Mi Costo Dulce.');
}
}