<?php

namespace App\Models;

use CodeIgniter\Model;

class GastosRecetasModel extends Model
{
    protected $table      = 'gastos_recetas';
    protected $primaryKey = 'Id_detalle_gasto';
    protected $allowedFields = ['Id_receta', 'id_gasto', 'precio_aplicado'];
}