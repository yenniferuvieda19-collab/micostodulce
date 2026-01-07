<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredientesRecetasModel extends Model
{
    // Apuntamos a la misma tabla de siempre
    protected $table            = 'ingredientes_recetas';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['Id_receta', 'id_ingrediente', 'cantidad_requerida', 'unidad_receta'];
    protected $returnType       = 'array';
}
