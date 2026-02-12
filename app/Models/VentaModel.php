<?php 
namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model{
    protected $table      = 'ventas';
    protected $primaryKey = 'Id_venta';

    protected $allowedFields = [
        'Id_venta',
        'Id_produccion', 
        'Id_usuario', 
        'cantidad_vendida', 
        'precio_unitario',  
        'precio_venta_total', 
        'nombre_receta', 
        'fecha_venta'
    ];

}