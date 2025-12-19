<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<form action="<?= base_url('recetas/guardar') ?>" method="POST">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: var(--rosa-logo);">
                        <i class="fa-solid fa-utensils me-2"></i>Nueva Receta
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small">Nombre del Postre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Alfajores de Maicena" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Porciones que rinde</label>
                            <input type="number" id="porciones" name="porciones" class="form-control" value="1" min="1" required>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3" style="color: var(--azul-logo);">Ingredientes de la mezcla</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle" id="tabla_ingredientes">
                            <thead class="bg-light">
                                <tr class="small text-muted text-uppercase">
                                    <th>Ingrediente</th>
                                    <th style="width: 140px;">Cantidad</th>
                                    <th style="width: 100px;">Costo</th>
                                    <th style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="agregarFila()">
                        <i class="fa-solid fa-plus me-1"></i> Agregar Ingrediente
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3" style="border-top: 5px solid var(--marron-logo) !important;">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Resumen de Costos</h6>
                    
                    <div class="mb-3">
                        <label class="small fw-bold">Costo Materiales:</label>
                        <div class="h5 fw-bold" id="resumen_materiales" style="color: var(--negro-logo);">$ 0.00</div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-muted">Mano de Obra / Gastos (%)</label>
                        <input type="number" id="p_obra" name="porcentaje_adicional" class="form-control form-control-sm" value="30" oninput="calcularTodo()">
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted">Beneficio Esperado (%)</label>
                        <input type="number" id="p_ganancia" name="porcentaje_beneficio" class="form-control form-control-sm" value="100" oninput="calcularTodo()">
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="small fw-bold">VALOR VENTA UNITARIO:</span>
                        <span class="h4 fw-bold mb-0" id="resumen_venta" style="color: var(--rosa-logo);">$ 0.00</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Receta
                    </button>
                </div>
            </div>

            <div class="p-3 bg-white shadow-sm rounded border-start border-4 border-info">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-lightbulb text-warning me-2"></i>
                    <span class="small fw-bold" style="color: var(--marron-logo);">Tip de Dulce Capricho:</span>
                </div>
                <p class="small text-muted mb-0">
                    Recuerda que el <b>100% de beneficio</b> significa que cobrarás el doble del costo total de producción. ¡Valora tu talento!
                </p>
            </div>
        </div>
    </div>
</form>

<script>
// Pasamos los ingredientes desde PHP para que JS pueda calcular costos al instante
const ingredientesDB = <?= json_encode($ingredientes) ?>;

function agregarFila() {
    const tbody = document.querySelector('#tabla_ingredientes tbody');
    const row = document.createElement('tr');
    
    let opciones = ingredientesDB.map(i => `<option value="${i.Id_ingrediente}" data-precio="${i.costo_unidad}">${i.nombre_ingrediente}</option>`).join('');

    row.innerHTML = `
        <td>
            <select class="form-select form-select-sm" name="ingrediente_id[]" onchange="calcularTodo()" required>
                <option value="">Seleccionar...</option>
                ${opciones}
            </select>
        </td>
        <td>
            <input type="number" step="0.01" class="form-control form-control-sm" name="cantidades[]" oninput="calcularTodo()" placeholder="Cant." required>
        </td>
        <td class="small fw-bold text-muted">$ <span class="costo_fila">0.00</span></td>
        <td>
            <button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove(); calcularTodo();">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
}

function calcularTodo() {
    let totalMateriales = 0;
    document.querySelectorAll('#tabla_ingredientes tbody tr').forEach(tr => {
        const select = tr.querySelector('select');
        const precio = select.options[select.selectedIndex]?.dataset.precio || 0;
        const cant = tr.querySelector('input').value || 0;
        const costo = precio * cant;
        tr.querySelector('.costo_fila').innerText = costo.toFixed(2);
        totalMateriales += costo;
    });

    const porciones = document.getElementById('porciones').value || 1;
    const pObra = document.getElementById('p_obra').value / 100;
    const pGanancia = document.getElementById('p_ganancia').value / 100;

    const costoReceta = totalMateriales + (totalMateriales * pObra);
    // Venta Sugerida = Costo Receta + %Beneficio
    const ventaTotal = costoReceta * (1 + pGanancia);
    const ventaUnit = ventaTotal / porciones;

    document.getElementById('resumen_materiales').innerText = '$ ' + totalMateriales.toFixed(2);
    document.getElementById('resumen_venta').innerText = '$ ' + ventaUnit.toFixed(2);
}

// Iniciar con una fila vacía
window.onload = agregarFila;
</script>
<?= $this->endSection() ?>