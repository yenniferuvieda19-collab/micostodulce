<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredienteModel extends Model
{
    // Nombre de la tabla SQL
    protected $table      = 'ingredientes';

    protected $primaryKey = 'Id_ingrediente';

    // Campos permitidos según la estructura
    protected $allowedFields = [
        'Id_usuario', 
        'Id_unidad_base', 
        'nombre_ingrediente', 
        'precio_compra', 
        'cantidad_paquete', 
        'costo_unidad'
    ];

  
    protected $useTimestamps = false;
}