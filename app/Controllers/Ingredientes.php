<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IngredienteModel;
use App\Models\UnidadModel;
use App\Models\RecetaModel;
use App\Models\RecetaDetalleModel;

class Ingredientes extends BaseController
{
    // Listar ingredientes
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $modelo = new IngredienteModel();
        $userId = session()->get('Id_usuario');

        $data['ingredientes'] = $modelo->select('ingredientes.*, unidades.nombre_unidad')
            ->join('unidades', 'unidades.Id_unidad = ingredientes.Id_unidad_base')
            ->where('ingredientes.Id_usuario', $userId)
            ->orderBy('nombre_ingrediente', 'ASC') // Ordenamos los ingredientes por orden alfabético
            ->findAll();

        return view('ingredientes/index', $data);
    }

    // Mostrar formulario de crear
    public function crear()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $unidadModel = new UnidadModel();
        $data['unidades'] = $unidadModel->findAll();

        return view('ingredientes/crear', $data);
    }

    // Guardar nuevo ingrediente
    public function guardar()
    {
        $modelo = new IngredienteModel();

        $datos = [
            'Id_usuario'         => session()->get('Id_usuario'),
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'costo_unidad'       => $this->request->getPost('precio'),
            'cantidad_paquete'   => $this->request->getPost('cantidad'),
            'Id_unidad_base'     => $this->request->getPost('unidad_id')
        ];

        $modelo->insert($datos);

        return redirect()->to('/ingredientes');
    }

    // Mostrar formulario de editar
    public function editar($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $modelo = new IngredienteModel();
        $unidadModel = new UnidadModel();

        $ingrediente = $modelo->find($id);

        if ($ingrediente['Id_usuario'] != session()->get('Id_usuario')) {
            return redirect()->to('/ingredientes');
        }

        $data = [
            'ingrediente' => $ingrediente,
            'unidades'    => $unidadModel->findAll()
        ];

        return view('ingredientes/editar', $data);
    }

    // Actualizar
    public function actualizar($id)
    {
        $modelo = new IngredienteModel();

        $datos = [
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'costo_unidad'       => $this->request->getPost('precio'),
            'cantidad_paquete'   => $this->request->getPost('cantidad'),
            'Id_unidad_base'     => $this->request->getPost('unidad_id')
        ];

        $modelo->update($id, $datos);

        $this->recalcularRecetasAfectadas($id);

        return redirect()->to('/ingredientes');
    }

    // Borrar ingrediente
    public function borrar($id = null)
    {
        $model = new IngredienteModel();

        // Verificar si el insumo está en uso
        $relacionModel = new \App\Models\IngredientesRecetasModel();

        $estaEnUso = $relacionModel->where('id_ingrediente', $id)->first();

        if ($estaEnUso) {
            // Alto, este insumo está en uso, por lo que no borramos nada y devolvemos error
            return redirect()->back()->with('error', 'No se puede eliminar este insumo porque es parte de una o más recetas.');
        }

        // Si llegamos aquí, es seguro borrar
        $model->delete($id);

        return redirect()->to(base_url('ingredientes'))->with('mensaje', 'Insumo eliminado correctamente.');
    }

    // Función para recalcular costos
    private function recalcularRecetasAfectadas($idIngrediente)
    {
        $detalleModel = new RecetaDetalleModel();
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();

        $recetasAfectadas = $detalleModel->select('Id_receta')
            ->where('Id_ingrediente', $idIngrediente)
            ->distinct()
            ->findAll();

        if (empty($recetasAfectadas)) {
            $recetasAfectadas = $detalleModel->select('Id_receta')
                ->where('id_ingrediente', $idIngrediente)
                ->distinct()
                ->findAll();
        }

        foreach ($recetasAfectadas as $fila) {
            $idReceta = $fila['Id_receta'];

            $ingredientesDeLaReceta = $detalleModel->where('Id_receta', $idReceta)->findAll();

            $nuevoCostoTotal = 0;

            foreach ($ingredientesDeLaReceta as $detalle) {
                if (isset($detalle['Id_ingrediente'])) {
                    $idReal = $detalle['Id_ingrediente'];
                } elseif (isset($detalle['id_ingrediente'])) {
                    $idReal = $detalle['id_ingrediente'];
                } else {
                    continue; // Si no encuentra el ID, salta al siguiente
                }

                $infoIngrediente = $ingModel->find($idReal);

                if ($infoIngrediente) {
                    // Cálculo: (Costo / Cantidad Paquete) * Cantidad Usada
                    // Usamos floatval para asegurar que sean números
                    $precioUnitario = floatval($infoIngrediente['costo_unidad']) / floatval($infoIngrediente['cantidad_paquete']);
                    $costoIngrediente = $precioUnitario * floatval($detalle['cantidad_requerida']);

                    $nuevoCostoTotal += $costoIngrediente;
                }
            }

            $datosReceta = $recetaModel->find($idReceta);
            $updateData = ['costo_total' => $nuevoCostoTotal];

            if ($datosReceta) {
                $gananciaDecimal = $datosReceta['porcentaje_ganancia'] / 100;
                if ($gananciaDecimal < 1) {
                    $nuevoPrecioVenta = $nuevoCostoTotal / (1 - $gananciaDecimal);
                    $updateData['precio_venta_sug'] = $nuevoPrecioVenta;
                }
            }

            $recetaModel->update($idReceta, $updateData);
        }
    }
}
