<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    /**
     * Muestra la vista de inicio de sesión
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Validación de credenciales contra la tabla 'usuarios'
     */
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
            return redirect()->to(base_url('ingredientes'));
        }

        return redirect()->back()->with('error', 'Credenciales inválidas.');
    }

    /**
     * Cierra la sesión del usuario
     */
    public function salir()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('mensaje', '¡Sesión cerrada! Gracias por trabajar en Mi Costo Dulce.');
    }

    /**
     * Muestra la vista de registro
     */
    public function registro()
    {
        return view('auth/registro');
    }

    /**
     * Procesa el registro de nuevos usuarios
     */
    public function registrar()
    {
        $model = new UsuarioModel();

        $nombre_negocio = $this->request->getPost('nombre_negocio');
        $email = $this->request->getPost('email');  
        $password = $this->request->getPost('password');
        
        // 1. Recibimos la confirmación
        $password_confirm = $this->request->getPost('password_confirm');

        if (empty($nombre_negocio) || empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // 2. Validamos que coincidan
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

    /**
     * Muestra la vista para solicitar recuperación de clave
     */
    public function recuperar()
    {
        return view('auth/recuperar');
    }

    /* Procesa el envío del correo de recuperación     */
    public function enviarRecuperacion()
    {
        $model = new UsuarioModel();
        $email = $this->request->getPost('email');
// recibe la info del formulario de recuperar

        if (empty($email)) {
            return redirect()->back()->with('error', 'Por favor, ingresa tu correo electrónico.');
        }

        
        $user = $model->where('Correo', $email)->first();

        if (!$user) {
    // Si no existe el usuario
    return redirect()->back()->with('error', 'No encontramos una cuenta con ese correo.');
   }
   //si existe se ejecuta lo siguinte

         
         $token = bin2hex(random_bytes(32));

         $db = \Config\Database::connect();
         $db->table('tokens_temporales')->insert([
                   'id_usuario'    => $user['Id_usuario'],
                   'token' => password_hash($token, PASSWORD_DEFAULT),
                   'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+1 hour'))
                 ]);
        
               
                 $link = base_url('auth/resetPassword/' . $token);

                 $emailService = \Config\Services::email();
                 $emailService->setTo($user['Correo']);
                 $emailService->setSubject('Recuperación de contraseña');
                 $emailService->setMessage("Haz clic en el siguiente enlace para recuperar tu contraseña: <a href='{$link}'>Recuperar contraseña</a>");
                 $emailService->send();







return redirect()->to(base_url('login'))->with('mensaje', 'Si el correo existe, recibirás instrucciones pronto.');

    }
}