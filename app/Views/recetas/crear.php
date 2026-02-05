<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center">
    <div class="col-lg-12">

        <form action="<?= base_url('recetas/guardar') ?>" method="POST" id="formReceta">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold" style="color: var(--azul-logo);">Nueva Receta</h2>
                <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Nombre del Postre</label>
                            <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Ej: Torta de Vainilla" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Porciones</label>
                            <input type="number" name="porciones" class="form-control form-control-lg" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-success">Ganancia Deseada</label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="1" name="ganancia" class="form-control border-success" value="30" required>
                                <span class="input-group-text bg-success text-white border-success">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold" style="color: var(--azul-logo);">
                        <i class="fa-solid fa-blender me-2"></i>Ingredientes
                    </h5>
                    <div class="bg-light px-3 py-1 rounded border">
                        <small class="text-muted fw-bold">COSTO TOTAL:</small>
                        <span id="displayTotalCosto" class="fw-bold text-danger ms-2">$ 0.00</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle" id="tablaIngredientes">
                            <thead class="bg-light">
                                <tr class="text-secondary small text-uppercase">
                                    <th style="width: 35%;">Ingrediente</th>
                                    <th style="width: 20%;" class="text-center">Costo Unitario</th>
                                    <th style="width: 25%;">Cantidad a Usar</th>
                                    <th style="width: 15%;" class="text-end">Subtotal ($)</th>
                                    <th style="width: 5%;"></th>
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

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: var(--azul-logo);">
                        <i class="fa-solid fa-hand-holding-dollar me-2"></i>Costos Indirectos
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">Selecciona los gastos adicionales (Cajas, Servicios, Mano de Obra) que aplican a esta receta.</p>
                    
                    <div class="row g-3">
                        <?php if(!empty($gastos)): ?>
                            <?php foreach($gastos as $gasto): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check p-3 border rounded bg-light custom-check-card position-relative h-100">
                                        <input class="form-check-input position-absolute top-50 start-0 ms-3 translate-middle-y" 
                                               type="checkbox" 
                                               name="gasto_id[]" 
                                               value="<?= $gasto['Id_gasto'] ?>" 
                                               id="gasto_<?= $gasto['Id_gasto'] ?>"
                                               style="transform: scale(1.2);">
                                        
                                        <label class="form-check-label w-100 ps-5 cursor-pointer d-flex flex-column justify-content-center" 
                                               for="gasto_<?= $gasto['Id_gasto'] ?>" style="min-height: 40px;">
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <span class="fw-bold text-dark"><?= esc($gasto['nombre_gasto']) ?></span>
                                                <span class="badge bg-white text-success border border-success shadow-sm">
                                                    $<?= number_format($gasto['precio_unitario'], 2) ?>
                                                </span>
                                            </div>
                                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-tag me-1"></i><?= esc($gasto['categoria']) ?>
                                            </small>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                                    <i class="fa-solid fa-triangle-exclamation me-3 fs-4"></i>
                                    <div>
                                        <strong>No hay costos indirectos registrados.</strong><br>
                                        <a href="<?= base_url('gastos') ?>" class="alert-link text-decoration-none">Haz clic aquí para crear tus gastos (Cajas, Gas, etc.)</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <label class="form-label fw-bold text-secondary">
                        <i class="fa-solid fa-comment-dots me-2"></i>Nota Adicional (Opcional)
                    </label>
                    <textarea name="notas" class="form-control" rows="2" placeholder="Ej: Mantener refrigerado..."></textarea>
                </div>
            </div>

            <div class="d-grid gap-2 mb-5">
                <button type="submit" class="btn btn-success btn-lg rounded-pill text-white fw-bold shadow-sm" style="background-color: var(--azul-logo); border:none;">
                    Guardar Receta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const ingredientesDisponibles = [
        <?php foreach ($ingredientes as $ing): ?> {
                id: "<?= $ing['Id_ingrediente'] ?>",
                nombre: "<?= esc($ing['nombre_ingrediente']) ?>",
                unidad_id: <?= $ing['Id_unidad_base'] ?>,
                precio: <?= $ing['costo_unidad'] ?>,
                paquete: <?= $ing['cantidad_paquete'] ?>
            },
        <?php endforeach; ?>
    ];

    function formatearDinero(cantidad) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(cantidad);
    }

    function agregarFila() {
        const tbody = document.getElementById('listaIngredientes');
        const row = document.createElement('tr');

        let opciones = '<option value="" data-unidad="-" data-precio="0" data-paquete="0" data-tipo="0">-- Selecciona --</option>';

        ingredientesDisponibles.forEach(ing => {
            opciones += `<option value="${ing.id}" data-unidad-id="${ing.unidad_id}" data-precio="${ing.precio}" data-paquete="${ing.paquete}">${ing.nombre}</option>`;
        });

        row.innerHTML = `
            <td><select name="ingrediente_id[]" class="form-select" onchange="actualizarCalculos(this)" required>${opciones}</select></td>
            <td class="text-center"><small class="text-muted d-block" style="font-size: 0.7rem;">Costo por <span class="lbl-unidad">-</span>:</small><span class="fw-bold text-secondary lbl-costo-unitario">$ 0.0000</span></td>
            <td><div class="input-group"><input type="number" step="0.01" name="cantidades[]" class="form-control" placeholder="0" oninput="actualizarCalculos(this)" required><span class="input-group-text fw-bold text-secondary lbl-unidad" style="min-width: 50px; justify-content: center;">-</span></div></td>
            <td class="text-end"><span class="fw-bold text-dark lbl-subtotal">$ 0.00</span></td>
            <td class="text-center"><button type="button" class="btn btn-outline-danger border-0 btn-sm" onclick="eliminarFila(this)"><i class="fa-solid fa-trash"></i></button></td>
        `;
        tbody.appendChild(row);
    }

    function actualizarCalculos(elemento) {
        const fila = elemento.closest('tr');
        const select = fila.querySelector('select');
        const inputCant = fila.querySelector('input[name="cantidades[]"]');
        const labelsUnidad = fila.querySelectorAll('.lbl-unidad');
        const labelCostoUnit = fila.querySelector('.lbl-costo-unitario');
        const labelSubtotal = fila.querySelector('.lbl-subtotal');
        const opcion = select.options[select.selectedIndex];
        const unidadId = parseInt(opcion.getAttribute('data-unidad-id')) || 0;
        const precioPaquete = parseFloat(opcion.getAttribute('data-precio')) || 0;
        const tamanoPaquete = parseFloat(opcion.getAttribute('data-paquete')) || 0;

        let factor = 1;
        let etiquetaUnidad = 'Und';
        if (unidadId === 1) {
            etiquetaUnidad = 'gr';
            factor = 1;
        } else if (unidadId === 2) {
            etiquetaUnidad = 'gr';
            factor = 1000;
        } else if (unidadId === 3) {
            etiquetaUnidad = 'ml';
            factor = 1;
        } else if (unidadId === 4) {
            etiquetaUnidad = 'ml';
            factor = 1000;
        }

        labelsUnidad.forEach(lbl => lbl.textContent = etiquetaUnidad);
        let costoUnitario = 0;
        let tamanoRealEnGramos = tamanoPaquete * factor;
        if (tamanoRealEnGramos > 0) {
            costoUnitario = precioPaquete / tamanoRealEnGramos;
        }
        labelCostoUnit.textContent = '$ ' + costoUnitario.toFixed(4);
        const cantidadUsada = parseFloat(inputCant.value) || 0;
        const subtotal = costoUnitario * cantidadUsada;
        labelSubtotal.textContent = '$ ' + formatearDinero(subtotal);
        calcularTotalGeneral();
    }

    function calcularTotalGeneral() {
        const subtotales = document.querySelectorAll('.lbl-subtotal');
        let total = 0;
        subtotales.forEach(span => {
            let textoValor = span.textContent.replace('$', '').trim();
            textoValor = textoValor.replace(/,/g, '');
            const valor = parseFloat(textoValor) || 0;
            total += valor;
        });
        const displayTotal = document.getElementById('displayTotalCosto');
        if (displayTotal) {
            displayTotal.textContent = '$ ' + formatearDinero(total);
        }
    }

    function eliminarFila(boton) {
        boton.closest('tr').remove();
        calcularTotalGeneral();
    }

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

        /* Estilos para los Checkboxes de Gastos */
        .custom-check-card {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        border: 1px solid #dee2e6 !important;
    }
    
    .custom-check-card:hover {
        background-color: #fff !important;
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        border-color: var(--azul-logo) !important;
    }

    /* Esta regla detecta si el checkbox dentro de la tarjeta está marcado */
    .custom-check-card:has(.form-check-input:checked) {
        background-color: #e8f0fe !important; 
        border-color: var(--azul-logo) !important;
        box-shadow: inset 0 0 0 1px var(--azul-logo);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<?= $this->endSection() ?>