
<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container py-2 py-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <form action="<?= base_url('recetas/guardar') ?>" method="POST" id="formReceta" novalidate>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: var(--marron-logo);">Nueva Receta</h2>
                        <p class="text-muted mb-0">Configura los costos y márgenes de tu nuevo postre.</p>
                    </div>
                    <div class="d-flex gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end">
                        <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-bold flex-fill flex-md-grow-0">
                            Cancelar
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nombre del Postre</label>
                                <input type="text" name="nombre" class="form-control form-control-lg fs-6" placeholder="Ej: Torta de Vainilla" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Porciones</label>
                                <input type="number" name="porciones" class="form-control form-control-lg fs-6" value="1" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold text-success small text-uppercase">Ganancia (%)</label>
                                <div class="input-group input-group-lg">
                                    <input type="number" step="1" name="ganancia" class="form-control border-success fs-6" value="30" required>
                                    <span class="input-group-text bg-success text-white border-success small">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0 fw-bold" style="color: var(--azul-logo);">
                            <i class="fa-solid fa-blender me-2"></i>Ingredientes e Insumos
                        </h5>
                        <div class="bg-light px-3 py-2 rounded-pill border d-flex align-items-center">
                            <small class="text-muted fw-bold me-2">COSTO TOTAL:</small>
                            <span id="displayTotalCosto" class="fw-bold text-danger fs-5">$ 0.00</span>
                        </div>
                    </div>

                    <div class="card-body p-0 p-md-4">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="tablaIngredientes" style="min-width: 700px;">
                                <thead class="bg-light">
                                    <tr class="text-secondary small text-uppercase">
                                        <th style="width: 35%;" class="ps-4">Ingrediente o Insumo</th>
                                        <th style="width: 20%;" class="text-center">Costo Unitario</th>
                                        <th style="width: 25%;">Cantidad a Usar</th>
                                        <th style="width: 15%;" class="text-end">Subtotal</th>
                                        <th style="width: 5%;" class="pe-4"></th>
                                    </tr>
                                </thead>
                                <tbody id="listaIngredientes"></tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            <button type="button" class="btn btn-light text-primary fw-bold w-100 border-dashed py-3" onclick="agregarFila()">
                                <i class="fa-solid fa-plus me-2"></i>Añadir un Ingrediente o Insumo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold" style="color: var(--azul-logo);">
                            <i class="fa-solid fa-hand-holding-dollar me-2"></i>Costos Indirectos
                        </h5>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <p class="text-muted small mb-3">Selecciona los adicionales que aplican a esta receta:</p>
                        <div class="row g-3">
                            <?php if(!empty($gastos)): ?>
                                <?php foreach($gastos as $gasto): ?>
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="form-check p-3 border rounded bg-light custom-check-card position-relative h-100">
                                            <input class="form-check-input position-absolute top-50 start-0 ms-3 translate-middle-y check-gasto" 
                                                   type="checkbox" 
                                                   name="gasto_id[]" 
                                                   value="<?= $gasto['Id_gasto'] ?>" 
                                                   data-precio="<?= $gasto['precio_unitario'] ?>"
                                                   data-fijo="<?= $gasto['es_fijo'] ?>"
                                                   id="gasto_<?= $gasto['Id_gasto'] ?>"
                                                   onchange="calcularTotalGeneral()"
                                                   style="transform: scale(1.3);">
                                            
                                            <label class="form-check-label w-100 ps-5 cursor-pointer d-flex flex-column justify-content-center" 
                                                   for="gasto_<?= $gasto['Id_gasto'] ?>" style="min-height: 45px;">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span class="fw-bold text-dark small"><?= esc($gasto['nombre_gasto']) ?></span>
                                                    <span class="badge bg-white text-dark border <?= $gasto['es_fijo'] ? 'border-success text-success' : 'border-primary text-primary' ?>">
                                                        <?= $gasto['es_fijo'] ? '$' : '' ?><?= number_format($gasto['precio_unitario'], 2) ?><?= !$gasto['es_fijo'] ? '%' : '' ?>
                                                    </span>
                                                </div>
                                                <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                                                    <i class="fa-solid fa-tag me-1"></i><?= esc($gasto['categoria']) ?>
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-0">
                                        <i class="fa-solid fa-triangle-exclamation me-3 fs-4"></i>
                                        <div>
                                            <strong>No hay costos indirectos.</strong><br>
                                            <a href="<?= base_url('gastos') ?>" class="alert-link">Configúralos aquí primero.</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3 p-md-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase" for="notas">
                            <i class="fa-solid fa-list-check me-2"></i>Pasos de la preparación / Receta (Opcional)
                        </label>
                        <textarea 
                            name="notas" 
                            id="notas"
                            class="form-control" 
                            rows="6" 
                            style="border-left: 5px solid var(--azul-logo); resize: none;" 
                            placeholder="Describe aquí el paso a paso detallado (opcional)..."></textarea>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-5">
                    <button type="submit" class="btn btn-lg rounded-pill text-white fw-bold shadow py-3 btn-guardar-receta">
                        <i class="fa-solid fa-check-double me-2"></i>GUARDAR RECETA COMPLETA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const ingredientesDisponibles = [
        <?php foreach ($ingredientes as $ing): ?> {
                id: "<?= $ing['Id_ingrediente'] ?>",
                nombre: "<?= esc($ing['nombre_ingrediente']) ?>",
                unidad_id: <?= $ing['Id_unidad_base'] ?>,
                precio: <?= $ing['costo_unitario'] ?? $ing['costo_unidad'] ?>,
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
        let opciones = '<option value="" data-unidad="-" data-precio="0" data-paquete="0">-- Selecciona --</option>';
        ingredientesDisponibles.forEach(ing => {
            opciones += `<option value="${ing.id}" data-unidad-id="${ing.unidad_id}" data-precio="${ing.precio}" data-paquete="${ing.paquete}">${ing.nombre}</option>`;
        });

        row.innerHTML = `
            <td class="ps-4"><select name="ingrediente_id[]" class="form-select form-select-lg fs-6" onchange="actualizarCalculos(this)" required>${opciones}</select></td>
            <td class="text-center"><small class="text-muted d-block" style="font-size: 0.7rem;">Costo por <span class="lbl-unidad">-</span>:</small><span class="fw-bold text-secondary lbl-costo-unitario">$ 0.0000</span></td>
            <td><div class="input-group input-group-lg"><input type="number" step="0.01" name="cantidades[]" class="form-control fs-6" placeholder="0" oninput="actualizarCalculos(this)" required><span class="input-group-text fw-bold text-secondary lbl-unidad" style="min-width: 60px; justify-content: center; font-size: 0.8rem;">-</span></div></td>
            <td class="text-end"><span class="fw-bold text-dark lbl-subtotal fs-6">$ 0.00</span></td>
            <td class="text-center pe-4"><button type="button" class="btn btn-outline-danger border-0" onclick="eliminarFila(this)"><i class="fa-solid fa-trash"></i></button></td>
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
        if (unidadId === 1) { etiquetaUnidad = 'gr'; factor = 1; } 
        else if (unidadId === 2) { etiquetaUnidad = 'gr'; factor = 1000; } 
        else if (unidadId === 3) { etiquetaUnidad = 'ml'; factor = 1; } 
        else if (unidadId === 4) { etiquetaUnidad = 'ml'; factor = 1000; }

        labelsUnidad.forEach(lbl => lbl.textContent = etiquetaUnidad);
        
        let costoUnitario = 0;
        let tamanoReal = tamanoPaquete * factor;
        if (tamanoReal > 0) { costoUnitario = precioPaquete / tamanoReal; }
        
        labelCostoUnit.textContent = '$ ' + costoUnitario.toFixed(4);
        const cantidadUsada = parseFloat(inputCant.value) || 0;
        const subtotal = costoUnitario * cantidadUsada;
        labelSubtotal.textContent = '$ ' + subtotal.toFixed(4);
        calcularTotalGeneral();
    }

    // Lógica de cálculo unificada para ingredientes + costos indirectos
    function calcularTotalGeneral() {
        const subtotales = document.querySelectorAll('.lbl-subtotal');
        let totalIngredientes = 0;

        subtotales.forEach(span => {
            let textoValor = span.textContent.replace('$', '').trim().replace(/,/g, '');
            totalIngredientes += parseFloat(textoValor) || 0;
        });

        let totalIndirectos = 0;
        const checks = document.querySelectorAll('.check-gasto:checked');
        
        checks.forEach(check => {
            const precio = parseFloat(check.getAttribute('data-precio')) || 0;
            const esFijo = check.getAttribute('data-fijo') === "1";

            if (esFijo) {
                totalIndirectos += precio; 
            } else {
                totalIndirectos += (totalIngredientes * (precio / 100)); 
            }
        });

        const granTotal = totalIngredientes + totalIndirectos;
        const displayTotal = document.getElementById('displayTotalCosto');
        if (displayTotal) {
            displayTotal.textContent = '$ ' + formatearDinero(granTotal);
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

<style>
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), 
            rgba(255, 255, 255, 0.75)), 
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important; 
        background-position: center !important; 
        background-attachment: fixed !important; 
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9) !important; 
        backdrop-filter: blur(8px); 
        border-radius: 15px; 
    }

    .border-dashed {
        border: 2px dashed #dee2e6 !important;
        background-color: #f8f9fa !important;
    }

    .btn-guardar-receta {
        background-color: var(--azul-logo) !important;
        border: none !important;
    }

    .btn-guardar-receta:hover {
        background-color: var(--marron-logo) !important;
        transform: translateY(-2px);
    }
</style>

<?= $this->endSection() ?>