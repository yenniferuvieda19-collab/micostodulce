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

        if (strlen($password) <= 6) {
            return redirect()->back()->with('error', 'La contraseña debe tener al menos 6 caracteres.');
        }
 
         if (strlen($password) > 15) {
            return redirect()->back()->with('error', 'La contraseña solo puede tener maximo 15 caracteres.');
        }

        $data = [
            'Nombre' => $nombre_negocio,
            'Correo' => $email,
            'Contraseña' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $model->insert($data);

                $emailService = \Config\Services::email();
                $data2 =  [
                        'nombre_negocio' =>  $nombre_negocio
                ];
                $body = view('email/bienvenido_template', $data2);
        $emailService->setTo($email);
        $emailService->setSubject('Bienvenido a Mi Costo Dulce');
        $emailService->setMessage("$body");
        $emailService->send();




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


        $token = bin2hex(random_bytes(32)); //genera el token
        
               
       $link = base_url('resetPassword/' . $token . '?uid=' . $user['Id_usuario']); //link que ira en el correo

        $db = \Config\Database::connect();
        $db->table('tokens_temporales')->insert([
            'id_usuario'    => $user['Id_usuario'],
            'token' => password_hash($token, PASSWORD_DEFAULT), //encripta el token
            'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);


        $emailService = \Config\Services::email();

        $data=[
            'nombre_negocio' => $user['Nombre'],
            'link' => $link
        ];
        $body= view ('email/ResetPasword', $data);

        $emailService->setTo($user['Correo']);
        $emailService->setSubject('Recuperación de contraseña');
        $emailService->setMessage($body);
        $emailService->send();

        return redirect()->to(base_url('login'))->with('mensaje', 'Si el correo existe, recibirás instrucciones en tu correo.');
    }
   

        public function verificacionGmail($token = null )
                      {
                       


                           // 1) Conexión a base de datos
    $db = \Config\Database::connect();

    // 2) Obtener parámetros desde la URL
    $idUsuario = $this->request->getGet('uid');
   if (!$idUsuario || !$token) {
        return "Enlace incompleto o inválido.";
    }

    // 3) Consultar el token más reciente del usuario
    $tokenData = $db->table('tokens_temporales')
                    ->where('Id_usuario', $idUsuario)
                    ->orderBy('Id_token', 'DESC')
                    ->get()
                    ->getRow();

    // 4) Validar existencia del registro de token
    if (!$tokenData) {
        return "Token inválido.";
    }

    // 5) Bloquear si ya fue usado (fecha_uso no es NULL ni vacío)
    if (!is_null($tokenData->fecha_uso) && $tokenData->fecha_uso !== '') {
       return redirect()->to(base_url('login'))
                 ->with('error', 'El link ya fue utilizado');
    }

    // 6) Comparar token plano contra hash almacenado
    if (!password_verify($token, $tokenData->token)) {
       return redirect()->to(base_url('login'))
                 ->with('error', 'link invalido');


    }

    // 7) Comprobar si aun es valido
    if (strtotime($tokenData->fecha_expiracion) < time()) {
        return redirect()->to(base_url('login'))
                 ->with('error', 'El link ya expiro');


    }

    // 8) Marcar el token como usado 
    $db->table('tokens_temporales')
       ->where('Id_token', $tokenData->Id_token)
       ->update(['fecha_uso' => date('Y-m-d H:i:s')]);    

    // 9) Renderizar la vista para cambiar contraseña 
    return view('auth/resetpassword', [
        'Id_usuario' => $idUsuario,
        'token'      => $token
    ]);


                
                       }  


                       public function ProcesarContrasena()
            {
                $model=new UsuarioModel();

                $idUsuario=$this->request->getPost('Id_usuario');
                //die(var_dump($idUsuario));
                $contrasena=$this->request->getPost('password');
                $Confirmcontrasena=$this->request->getPost('confirm_password');


                 if (strlen($contrasena) < 6) {
            return redirect()->back()->with('error', 'La contraseña debe tener al menos 6 caracteres.');
        }

                if($contrasena !== $Confirmcontrasena)
                    {
              return redirect()->back()->with('error', 'las contraseñas no son iguales');
                     }

                $NuevaContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

                $model->update($idUsuario, ['Contraseña' => $NuevaContrasena]);
              
                return redirect()->to(base_url('login'))->with('mensaje', 'cambio de contraseña exitoso');

            }


    public function panel()
    {

        if (!session()->get("isLoggedIn")) {
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
