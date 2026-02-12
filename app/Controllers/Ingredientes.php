<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IngredienteModel;
use App\Models\UnidadModel;
use App\Models\RecetaModel;
use App\Models\RecetaDetalleModel;
use App\Models\IngredientesRecetasModel; // Asegúrate de que este modelo exista para borrar

class Ingredientes extends BaseController
{
    // Muestra la tabla de insumos del usuario con JOIN a unidades
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
            ->orderBy('nombre_ingrediente', 'ASC')
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

    /**
     * Guarda un nuevo ingrediente y actualiza el progreso del usuario
     */
    public function guardar()
    {
        $modelo = new IngredienteModel();
        $userId = session()->get('Id_usuario');

        // Recibimos los datos del formulario POST
        $datos = [
            'Id_usuario'         => $userId,
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'costo_unidad'       => $this->request->getPost('precio'),
            'cantidad_paquete'   => $this->request->getPost('cantidad'),
            'Id_unidad_base'     => $this->request->getPost('unidad_id')
        ];

        // Insertamos en la base de datos
        if ($modelo->insert($datos)) {
            
            // --- LÓGICA DE ONBOARDING (GUÍA) ---
            // Contamos los ingredientes actuales del usuario
            $totalIngredientes = $modelo->where('Id_usuario', $userId)->countAllResults();

            // Si es su primer ingrediente, activamos el Paso 2 en la sesión
            if ($totalIngredientes >= 1) {
                session()->set('pasoActual', 2);
            }
            // ----------------------------------

            return redirect()->to('/ingredientes')->with('mensaje_exito', '¡Insumo agregado! Ya puedes avanzar al paso 2.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo guardar el insumo.');
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

        if (!$ingrediente || $ingrediente['Id_usuario'] != session()->get('Id_usuario')) {
            return redirect()->to('/ingredientes');
        }

        $data = [
            'ingrediente' => $ingrediente,
            'unidades'    => $unidadModel->findAll()
        ];

        return view('ingredientes/editar', $data);
    }

    // Actualizar datos del ingrediente
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

        // Recalcular costos de recetas que usan este insumo
        $this->recalcularRecetasAfectadas($id);
        
        return redirect()->to('/ingredientes')->with('mensaje_exito', 'Insumo actualizado y costos recalculados.');
    }

    // Borrar ingrediente verificando que no esté en uso
    public function borrar($id = null)
{
    if (!$id) return redirect()->to(base_url('ingredientes'));

    $model = new IngredienteModel();
    //Ojo aquí gente, ya que verifica que el modelo RecetaDetalleModel sea el correcto para ver si se usa el insumo
    $detalleModel = new \App\Models\RecetaDetalleModel();

    // Verificamos si el ingrediente está siendo usado en alguna receta
    // Ajusta 'Id_ingrediente' según el nombre real en la tabla receta_detalle
    $estaEnUso = $detalleModel->where('Id_ingrediente', $id)->first();

    if ($estaEnUso) {
        // Si está en uso, enviamos un mensaje de error que capturaremos en la vista
        return redirect()->to(base_url('ingredientes'))->with('error', 'No se puede eliminar: este insumo es parte de una receta activa.');
    }

    // Si no está en uso, lo borro
    $model->delete($id);

    return redirect()->to(base_url('ingredientes'))->with('mensaje_exito', 'Insumo eliminado correctamente.');
}

    // Gente, creé esto acá para actualizar costos de recetas automáticamente con una función privadaa
    private function recalcularRecetasAfectadas($idIngrediente)
    {
        $detalleModel = new RecetaDetalleModel();
        $recetaModel  = new RecetaModel();
        $ingModel     = new IngredienteModel();

        $recetasAfectadas = $detalleModel->select('Id_receta')
            ->groupStart()
                ->where('Id_ingrediente', $idIngrediente)
                ->orWhere('id_ingrediente', $idIngrediente)
            ->groupEnd()
            ->distinct()
            ->findAll();

        foreach ($recetasAfectadas as $fila) {
            $idReceta = $fila['Id_receta'];
            $ingredientesDeLaReceta = $detalleModel->where('Id_receta', $idReceta)->findAll();

            $nuevoCostoTotal = 0;

            foreach ($ingredientesDeLaReceta as $detalle) {
                $idReal = $detalle['Id_ingrediente'] ?? $detalle['id_ingrediente'] ?? null;
                if (!$idReal) continue;

                $infoIngrediente = $ingModel->find($idReal);

                if ($infoIngrediente && floatval($infoIngrediente['cantidad_paquete']) > 0) {
                    $precioUnitario = floatval($infoIngrediente['costo_unidad']) / floatval($infoIngrediente['cantidad_paquete']);
                    $costoIngrediente = $precioUnitario * floatval($detalle['cantidad_requerida']);
                    $nuevoCostoTotal += $costoIngrediente;
                }
            }

            $datosReceta = $recetaModel->find($idReceta);
            if ($datosReceta) {
                $updateData = ['costo_total' => $nuevoCostoTotal];
                $gananciaDecimal = $datosReceta['porcentaje_ganancia'] / 100;

                if ($gananciaDecimal < 1) {
                    $nuevoPrecioVenta = $nuevoCostoTotal / (1 - $gananciaDecimal);
                    $updateData['precio_venta_sug'] = $nuevoPrecioVenta;
                }
                $recetaModel->update($idReceta, $updateData);
            }
        }
    }
}