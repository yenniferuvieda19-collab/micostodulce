<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoAdicionalModel extends Model
{
    protected $table            = 'gastos_adicionales';
    protected $primaryKey       = 'Id_gasto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['Id_usuario', 'nombre_gasto', 'categoria', 'precio_unitario', 'es_paquete', 'cantidad_paquete', 'costo_paquete'];

    // Validaciones básicas para que no metan datos vacíos
    protected $validationRules = [
        'nombre_gasto'    => 'required|min_length[3]|max_length[100]',
        'precio_unitario' => 'required|numeric|greater_than[0]',
        'categoria'       => 'required'
    ];

    protected $validationMessages = [
        'nombre_gasto' => [
            'required' => 'El nombre del gasto es obligatorio.'
        ],
        'precio_unitario' => [
            'numeric' => 'El precio debe ser un número.'
        ]
    ];

    // Función para obtener solo los gastos del usuario logueado
    public function getGastosPorUsuario($idUsuario)
    {
        return $this->where('Id_usuario', $idUsuario)
            ->orderBy('nombre_gasto', 'ASC')
            ->findAll();
    }
}
