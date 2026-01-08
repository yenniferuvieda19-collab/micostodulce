<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredienteModel extends Model
{
    protected $table            = 'ingredientes';
    protected $primaryKey       = 'Id_ingrediente';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'Id_usuario',
        'nombre_ingrediente',
        'costo_unidad',
        'cantidad_paquete',
        'Id_unidad_base'
    ];
}
