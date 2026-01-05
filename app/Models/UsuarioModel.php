<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
      protected $table      = 'usuarios';
    protected $allowedFields = ['Nombre', 'Correo', 'Contraseña'];
    // Uncomment below if you want add primary key
<<<<<<< HEAD
    protected $primaryKey = 'Id_usuario';
=======
    protected $primaryKey = 'id';
>>>>>>> 10d6151b1c435ca1dba5e99bf628a48ae3aff430
}