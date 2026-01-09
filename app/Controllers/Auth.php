<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\IngredienteModel;
use App\Models\RecetaModel;

class Auth extends BaseController
{
    // Muestra la vista de inicio de sesión
    public function login()
    {
        return view('auth/login');
    }

    // Validación de credenciales contra la tabla 'usuarios'
    public function ingresar()
    {
        $session = session();
        $model = new UsuarioModel();

        $correo = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('Correo', $correo)->first();

        if ($user && password_verify($password, $user['Contraseña'])) {
            $session->set([
                'Id_usuario' => $user['Id_usuario'],
                'Nombre'     => $user['Nombre'],
                'isLoggedIn' => true
            ]);
            return redirect()->to(base_url("panel"));
        }

        return redirect()->back()->with('error', 'Credenciales inválidas.');
    }

    // Cierra la sesión del usuario
    public function salir()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('mensaje', '¡Sesión cerrada! Gracias por trabajar en Mi Costo Dulce.');
    }

    // Muestra la vista de registro
    public function registro()
    {
        return view('auth/registro');
    }

    // Procesa el registro de nuevos usuarios
    public function registrar()
    {
        $model = new UsuarioModel();

        $nombre_negocio = $this->request->getPost('nombre_negocio');
        $email = $this->request->getPost('email');  
        $password = $this->request->getPost('password');
        
        // Recibimos la confirmación
        $password_confirm = $this->request->getPost('password_confirm');

        if (empty($nombre_negocio) || empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Validamos que coincidan
        if ($password !== $password_confirm) {
            return redirect()->back()->withInput()->with('error', 'Las contraseñas no coinciden.');
        }

        if ($model->where('Correo', $email)->first()) {
            return redirect()->back()->with('error', 'El correo ya está registrado.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'La contraseña debe tener al menos 6 caracteres.');
        }

        $data = [
            'Nombre' => $nombre_negocio,
            'Correo' => $email,
            'Contraseña' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $model->insert($data);

        return redirect()->to(base_url('login'))->with('mensaje', 'Registro exitoso. ¡Bienvenido a Mi Costo Dulce!');
    }

    // Muestra la vista para solicitar recuperación de clave
    public function recuperar()
    {
        return view('auth/recuperar');
    }

    // Procesa el envío del correo de recuperación
    public function enviarRecuperacion()
    {
        $email = $this->request->getPost('email');

        if (empty($email)) {
            return redirect()->back()->with('error', 'Por favor, ingresa tu correo electrónico.');
        }

        $model = new UsuarioModel();
        $user = $model->where('Correo', $email)->first();

        if ($user) {
            
            return redirect()->to(base_url('login'))->with('mensaje', 'Si el correo existe, recibirás instrucciones pronto.');
        }

        return redirect()->back()->with('error', 'No encontramos una cuenta con ese correo.');
    }

    public function panel()
    {

        if (!session()->get("isLoggedIn")){
            return redirect()->to(base_url('login'));
        }

        $ingredientesModel = new IngredienteModel(); 
        $recetasModel = new RecetaModel();

        $idUsuario = session()->get('Id_usuario');

        $data = [
        'totalIngredientes' => $ingredientesModel->where('Id_usuario', $idUsuario)->countAllResults(),
        'totalRecetas'      => $recetasModel->where('Id_usuario', $idUsuario)->countAllResults(),
        // Traemos las últimas 5 recetas para la tabla
        'ultimasRecetas'           => $recetasModel->where('Id_usuario', $idUsuario)->orderBy('Id_receta', 'DESC')->findAll(5)
        ];

        return view('panel_inicio', $data);

    }
}