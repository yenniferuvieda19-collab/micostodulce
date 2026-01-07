<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadModel extends Model
{
    protected $table            = 'unidades';
    protected $primaryKey       = 'Id_unidad';
    protected $allowedFields    = ['nombre_unidad'];
    protected $returnType       = 'array';
}
