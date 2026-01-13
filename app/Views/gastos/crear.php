<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-center" style="color: var(--azul-logo);">Nuevo Gasto Indirecto</h3>
                    
                    <form action="<?= base_url('gastos/guardar') ?>" method="post">
                        
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Nombre del Gasto</label>
                                <input type="text" class="form-control" name="nombre_gasto" placeholder="Ej: Vasos 12oz, Gas, Cajas..." required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Categoría</label>
                                <select class="form-select" name="categoria" required>
                                    <option value="Empaque">Empaque</option>
                                    <option value="Servicio">Servicio (Gas/Luz)</option>
                                    <option value="Mano de Obra">Mano de Obra</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="form-check form-switch mb-4 p-3 rounded bg-light border">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="switchPaquete" name="es_paquete" value="1">
                            <label class="form-check-label fw-bold" for="switchPaquete">
                                ¿Esto es un Paquete / Caja?
                                <div class="text-muted small fw-normal">Actívalo si compraste una bolsa de vasos o una caja de servilletas y quieres saber el costo por unidad.</div>
                            </label>
                        </div>

                        <div id="modoUnidad">
                            <label class="form-label fw-bold">Costo Unitario ($)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">$</span>
                                <input type="number" step="0.01" class="form-control form-control-lg" name="precio_unitario" id="inputUnitario" placeholder="0.00">
                            </div>
                            <div class="form-text">El precio de una sola unidad o una sola hora.</div>
                        </div>

                        <div id="modoPaquete" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-primary">Costo TOTAL del Paquete</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">$</span>
                                        <input type="number" step="0.01" class="form-control" name="costo_paquete" id="inputCostoPaquete" placeholder="Ej: 5.00">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-primary">Cantidad de Unidades</label>
                                    <input type="number" class="form-control" name="cantidad_paquete" id="inputCantidadPaquete" placeholder="Ej: 50">
                                    <div class="form-text">¿Cuántos vienen en el paquete?</div>
                                </div>
                            </div>
                            
                            <div class="alert alert-primary d-flex align-items-center mt-2">
                                <i class="fa-solid fa-calculator me-3 fs-4"></i>
                                <div>
                                    <small class="text-uppercase fw-bold opacity-75">Costo calculado por unidad:</small>
                                    <h3 class="mb-0 fw-bold" id="resultadoCalculo">$ 0.00</h3>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary fw-bold p-3" style="background-color: var(--azul-logo); border:none;">Guardar Gasto</button>
                            <a href="<?= base_url('gastos') ?>" class="btn btn-light text-muted">Cancelar</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover; background-attachment: fixed;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const switchPaquete = document.getElementById('switchPaquete');
        const modoUnidad = document.getElementById('modoUnidad');
        const modoPaquete = document.getElementById('modoPaquete');
        
        // Inputs para calcular
        const inputCostoPaquete = document.getElementById('inputCostoPaquete');
        const inputCantidadPaquete = document.getElementById('inputCantidadPaquete');
        const resultadoCalculo = document.getElementById('resultadoCalculo');

        // Función para mostrar/ocultar campos
        function toggleModo() {
            if (switchPaquete.checked) {
                modoUnidad.style.display = 'none';
                modoPaquete.style.display = 'block';
                // Limpiar el campo unitario para evitar conflictos
                document.getElementById('inputUnitario').value = '';
                calcularUnitario(); // Recalcular al cambiar
            } else {
                modoUnidad.style.display = 'block';
                modoPaquete.style.display = 'none';
            }
        }

        // Función matemática
        function calcularUnitario() {
            const costo = parseFloat(inputCostoPaquete.value) || 0;
            const cantidad = parseFloat(inputCantidadPaquete.value) || 1;
            
            if(cantidad > 0) {
                const unitario = costo / cantidad;
                resultadoCalculo.innerText = '$ ' + unitario.toFixed(4); // 4 decimales para precisión
            } else {
                resultadoCalculo.innerText = '$ 0.00';
            }
        }

        // Eventos
        switchPaquete.addEventListener('change', toggleModo);
        inputCostoPaquete.addEventListener('input', calcularUnitario);
        inputCantidadPaquete.addEventListener('input', calcularUnitario);
    });
</script>
<?= $this->endSection() ?>