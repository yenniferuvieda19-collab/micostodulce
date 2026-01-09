<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <form action="<?= base_url('recetas/guardar') ?>" method="POST" id="formReceta">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold" style="color: var(--marron-logo);">Nueva Receta</h2>
                    <p class="text-muted small">Calcula el costo exacto de tu postre</p>
                </div>
                <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Nombre del Postre</label>
                            <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Ej: Torta de Chocolate" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Porciones</label>
                            <input type="number" name="porciones" class="form-control form-control-lg" placeholder="Ej: 8" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-success">Ganancia Deseada</label>
                            <div class="input-group input-group-lg">
                                <input type="number" name="ganancia" class="form-control border-success" value="30" required>
                                <span class="input-group-text bg-success text-white border-success">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: var(--azul-logo);">
                        <i class="fa-solid fa-blender me-2"></i>Ingredientes
                    </h5>
                </div>
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table class="table" id="tablaIngredientes">
                            <thead>
                                <tr class="text-secondary small text-uppercase">
                                    <th style="width: 50%;">Ingrediente</th>
                                    <th style="width: 30%;">Cantidad a Usar</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody id="listaIngredientes">
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-light text-primary fw-bold w-100 border-dashed mt-2" onclick="agregarFila()">
                        <i class="fa-solid fa-plus me-2"></i>Agregar Ingrediente
                    </button>

                </div>
            </div>

            <div class="d-grid gap-2 mb-5">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold" style="background-color: var(--marron-logo); border:none;">
                    <i class="fa-solid fa-calculator me-2"></i> Calcular y Guardar Receta
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Preparamos los datos con las unidades
    const ingredientesDisponibles = [
        <?php foreach ($ingredientes as $ing): ?>
            <?php
            $txtUnidad = '-';
            switch ($ing['Id_unidad_base']) {
                case 1:
                    $txtUnidad = 'gr';
                    break;
                case 2:
                    $txtUnidad = 'Kg';
                    break;
                case 3:
                    $txtUnidad = 'ml';
                    break;
                case 4:
                    $txtUnidad = 'Lt';
                    break;
                case 5:
                    $txtUnidad = 'Und';
                    break;
            }
            ?> {
                id: "<?= $ing['Id_ingrediente'] ?>",
                nombre: "<?= esc($ing['nombre_ingrediente']) ?>",
                unidad: "<?= $txtUnidad ?>"
            },
        <?php endforeach; ?>
    ];

    function agregarFila() {
        const tbody = document.getElementById('listaIngredientes');
        const row = document.createElement('tr');

        // Creamos las opciones con el atributo data-unidad
        let opciones = '<option value="" data-unidad="-">-- Selecciona --</option>';
        ingredientesDisponibles.forEach(ing => {
            opciones += `<option value="${ing.id}" data-unidad="${ing.unidad}">${ing.nombre}</option>`;
        });

        row.innerHTML = `
            <td>
                <select name="ingrediente_id[]" class="form-select" onchange="actualizarUnidad(this)" required>
                    ${opciones}
                </select>
            </td>
            <td>
                <div class="input-group">
                    <input type="number" step="0.01" name="cantidades[]" class="form-control" placeholder="0.00" required>
                    <span class="input-group-text fw-bold text-secondary unidad-label" style="min-width: 60px; justify-content: center;">
                        -
                    </span>
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger border-0 btn-sm" onclick="eliminarFila(this)">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function actualizarUnidad(selectElement) {
        const opcionSeleccionada = selectElement.options[selectElement.selectedIndex];
        const unidad = opcionSeleccionada.getAttribute('data-unidad');
        const fila = selectElement.closest('tr');
        const labelUnidad = fila.querySelector('.unidad-label');

        labelUnidad.textContent = unidad ? unidad : '-';
    }

    function eliminarFila(boton) {
        boton.closest('tr').remove();
    }

    // Al iniciar, agregamos una fila vacía para empezar
    document.addEventListener('DOMContentLoaded', function() {
        agregarFila();
    });
</script>

<style>/*Agregué el estilo del fondo*/
    body {background-image: linear-gradient(rgba(255, 255, 255, 0.75), 
         rgba(255, 255, 255, 0.75)), 
        url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important; /*Agregué la ruta de la imagen*/
         background-size: cover !important; 
         background-position: center !important; 
         background-attachment: fixed !important; 
         background-repeat: no-repeat !important; 
        }

    main, .wrapper, #content {background: transparent !important;}

    .dashboard-container { background: transparent !important; 
        width: 100% !important; 
        min-height: 100vh; 
        padding-top: 1rem; 
        padding-bottom: 3rem; 
    }

    .card {background-color: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(8px); 
        border-radius: 15px; 
        border: none !important; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
</style>

<?= $this->endSection() ?>