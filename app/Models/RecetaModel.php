<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaModel extends Model
{
    protected $table      = 'recetas';
    protected $primaryKey = 'Id_receta';
    protected $allowedFields = ['Id_usuario', 'nombre_postre', 'porciones', 'costo_ingredientes', 'precio_venta_sug'];
}