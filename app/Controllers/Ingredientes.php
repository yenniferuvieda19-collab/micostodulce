<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IngredienteModel;
use App\Models\UnidadModel;
use App\Models\RecetaModel;
use App\Models\RecetaDetalleModel;

class Ingredientes extends BaseController
{
    // Muestra la tabla de insumos del usuario. Hace un JOIN con unidades de medida para mostrar "Kg", "Lt", etc
    public function index()
    {
        // Control de sesión, bloqueamos acceso si no hay sesión iniciada
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $modelo = new IngredienteModel();
        $userId = session()->get('Id_usuario');

        // Seleccionamos todos los campos de ingredientes Y el nombre de la unidad. JOIN: Unimos la tabla "ingredientes" con "unidades" usando el ID como puente
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

        // Pasamos las unidades base para llenar el select (Kg, Gr, Lt, Und)
        $unidadModel = new UnidadModel();
        $data['unidades'] = $unidadModel->findAll();

        return view('ingredientes/crear', $data);
    }

    // Guarda un nuevo ingrediente en la base de datos, además almacena el precio de compra y el tamaño del paquete
    public function guardar()
    {
        $modelo = new IngredienteModel();

        // Recibimos los datos del formulario POST
        $datos = [
            'Id_usuario'         => session()->get('Id_usuario'),
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'costo_unidad'       => $this->request->getPost('precio'),
            'cantidad_paquete'   => $this->request->getPost('cantidad'),
            'Id_unidad_base'     => $this->request->getPost('unidad_id')
        ];

        // Insertamos en la base de datos
        $modelo->insert($datos);

        return redirect()->to('/ingredientes')->with('mensaje_exito', '¡Nuevo insumo agregado con éxito!');
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

        // Verificamos que el ingrediente pertenezca al usuario logueado. Si alguien intenta cambiar el ID en la URL para ver datos ajenos, es expulsado
        if ($ingrediente['Id_usuario'] != session()->get('Id_usuario')) {
            return redirect()->to('/ingredientes');
        }

        $data = [
            'ingrediente' => $ingrediente,
            'unidades'    => $unidadModel->findAll()
        ];

        return view('ingredientes/editar', $data);
    }

    // Mostrar formulario de Actualizar
    public function actualizar($id)
    {
        $modelo = new IngredienteModel();

        $datos = [
            'nombre_ingrediente' => $this->request->getPost('nombre'),
            'costo_unidad'       => $this->request->getPost('precio'),
            'cantidad_paquete'   => $this->request->getPost('cantidad'),
            'Id_unidad_base'     => $this->request->getPost('unidad_id')
        ];

        // Actualizamos el ingrediente
        $modelo->update($id, $datos);

        // Como el precio del insumo cambió, debemos actualizar el costo de todas las recetas que lo utilizan para que la ganancia sea real
        $this->recalcularRecetasAfectadas($id);
        
        return redirect()->to('/ingredientes')->with('mensaje_exito', 'Insumo actualizado y costos recalculados.');
    }

    // Borrar ingrediente, en este caso elimina un ingrediente, pero primero verifica que no esté en uso por alguna receta
    public function borrar($id = null)
    {
        $model = new IngredienteModel();

        // Buscamos si este ID del ingrediente existe en la tabla intermedia "recetas_detalles"
        $relacionModel = new \App\Models\IngredientesRecetasModel();// Se asegura que el namespace sea correcto
        $estaEnUso = $relacionModel->where('id_ingrediente', $id)->first();

        if ($estaEnUso) {
            // Si está en uso, detenemos el proceso y mostramos error. Esto evita que las recetas se rompan y se descontrolen los calculos al eliminarse algún ingrediente
            return redirect()->back()->with('error', 'No se puede eliminar este insumo porque es parte de una o más recetas.');
        }

        // Si llegamos aquí, es seguro borrar
        $model->delete($id);

        return redirect()->to(base_url('ingredientes'))->with('mensaje_exito', 'Insumo eliminado correctamente.');
    }

    // Función para recalcular costos, en este caso buscamos todas las recetas que contienen el ingrediente modificado y vuelve a sumar sus costos y precios de venta
    private function recalcularRecetasAfectadas($idIngrediente)
    {
        $detalleModel = new RecetaDetalleModel(); // Tabla intermedia
        $recetaModel  = new RecetaModel(); // Tabla recetas
        $ingModel     = new IngredienteModel(); // Tabla ingredientes

        // Encontrar qué recetas usan este ingrediente
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

        // Verificamos cada receta afectada y recalculamos desde cero
        foreach ($recetasAfectadas as $fila) {
            $idReceta = $fila['Id_receta'];

            // Obtenemos todos los ingredientes de wsa receta
            $ingredientesDeLaReceta = $detalleModel->where('Id_receta', $idReceta)->findAll();

            $nuevoCostoTotal = 0;

            // Sumamos costo por costo
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
                    // Cálculo: (Costo / Cantidad Paquete) * Cantidad Usada, usamos floatval para asegurar que sean números
                    $precioUnitario = floatval($infoIngrediente['costo_unidad']) / floatval($infoIngrediente['cantidad_paquete']);
                    $costoIngrediente = $precioUnitario * floatval($detalle['cantidad_requerida']);

                    $nuevoCostoTotal += $costoIngrediente;
                }
            }

            // Actualizar la Receta con los nuevos valores
            $datosReceta = $recetaModel->find($idReceta);
            $updateData = ['costo_total' => $nuevoCostoTotal];

            // Usamos la fórmula simple (Costo + Ganancia) para mantener consistencia con el controlador de Recetas
            if ($datosReceta) {
                // Calculamos la ganancia en dinero (Ej: 30% de $10 = $3)
                $gananciaDecimal = $datosReceta['porcentaje_ganancia'] / 100;
                if ($gananciaDecimal < 1) {
                    // Precio Venta = Costo + Ganancia (Ej: $10 + $3 = $13)
                    $nuevoPrecioVenta = $nuevoCostoTotal / (1 - $gananciaDecimal);
                    $updateData['precio_venta_sug'] = $nuevoPrecioVenta;
                }
            }

            // Guardamos los cambios en la BD
            $recetaModel->update($idReceta, $updateData);
        }
    }
}
