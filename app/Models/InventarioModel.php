<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    // Nombre de la tabla en tu base de datos
    protected $table      = 'produccion'; 
    // Nombre de la llave primaria
    protected $primaryKey = 'Id_produccion'; 

    // Campos que permitiremos que el sistema escriba o lea
    // Asegúrate de que coincidan con los nombres en tu base de datos
    protected $allowedFields = [
        'Id_produccion', 
        'Id_receta', 
        'nombre_receta', 
        'cantidad_producida',  
        'costo_adicional_total', 
        'costo_total_lote', 
        'fecha_produccion'
    ];

    // Esto hará que CodeIgniter nos devuelva los datos como arreglos
    protected $returnType = 'array';
}