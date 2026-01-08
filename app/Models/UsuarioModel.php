<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
      protected $table      = 'usuarios';
    protected $allowedFields = ['Nombre', 'Correo', 'Contraseña'];
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
}