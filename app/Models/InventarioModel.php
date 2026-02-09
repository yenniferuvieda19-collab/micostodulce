<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    // Nombre de la tabla en tu base de datos
    protected $table      = 'inventario'; 
    // Nombre de la llave primaria
    protected $primaryKey = 'id_inventario'; 

    // Campos que permitiremos que el sistema escriba o lea
    // Asegúrate de que coincidan con los nombres en tu base de datos
    protected $allowedFields = [
        'Id_usuario', 
        'id_receta', 
        'nombre_postre', 
        'cantidad_preparada', 
        'porciones_totales', 
        'porciones_disponibles', 
        'precio_venta_sug', 
        'costo_reinversion', 
        'fecha_elaboracion'
    ];

    // Esto hará que CodeIgniter nos devuelva los datos como arreglos
    protected $returnType = 'array';
}