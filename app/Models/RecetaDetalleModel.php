<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaDetalleModel extends Model
{
    protected $table            = 'ingredientes_recetas';

    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'Id_receta',
        'id_ingrediente',
        'cantidad_requerida'
    ];

    protected $returnType       = 'array';
}
