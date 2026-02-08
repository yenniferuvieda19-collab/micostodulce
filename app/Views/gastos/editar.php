<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3 p-sm-4 p-md-5">
                    <h3 class="fw-bold mb-4 text-center" style="color: var(--azul-logo);">Editar Gasto</h3>
                    
                    <form action="<?= base_url('gastos/actualizar/' . $gasto['Id_gasto']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-7">
                                <label class="form-label fw-bold small">Nombre del Gasto</label>
                                <input type="text" class="form-control form-control-lg fs-6" name="nombre_gasto" 
                                       value="<?= esc($gasto['nombre_gasto']) ?>" required>
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold small">Categoría</label>
                                <select class="form-select form-select-lg fs-6" name="categoria" required>
                                    <option value="Empaque" <?= ($gasto['categoria'] == 'Empaque') ? 'selected' : '' ?>>Empaque</option>
                                    <option value="Servicio" <?= ($gasto['categoria'] == 'Servicio') ? 'selected' : '' ?>>Servicio (Gas/Luz)</option>
                                    <option value="Mano de Obra" <?= ($gasto['categoria'] == 'Mano de Obra') ? 'selected' : '' ?>>Mano de Obra</option>
                                    <option value="Otro" <?= ($gasto['categoria'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="form-check form-switch mb-4 p-3 rounded bg-light border-start border-4 border-info">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" 
                                   id="switchPaquete" name="es_paquete" value="1"
                                   <?= ($gasto['es_paquete'] == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="switchPaquete">
                                ¿Es un Paquete / Caja?
                                <div class="text-muted small fw-normal mt-1">Si cambias el modo, recuerda verificar los precios.</div>
                            </label>
                        </div>

                        <div id="modoUnidad" style="display: none;" class="animate__animated animate__fadeIn">
                            <label class="form-label fw-bold small">Costo Unitario ($)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0 text-success fw-bold">$</span>
                                <input type="number" step="0.0001" class="form-control border-start-0" 
                                       name="precio_unitario" id="inputUnitario" 
                                       value="<?= esc($gasto['precio_unitario']) ?>">
                            </div>
                        </div>

                        <div id="modoPaquete" style="display: none;" class="animate__animated animate__fadeIn">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label fw-bold small text-primary">Costo TOTAL del Paquete</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white border-0">$</span>
                                        <input type="number" step="0.01" class="form-control form-control-lg" 
                                               name="costo_paquete" id="inputCostoPaquete" 
                                               value="<?= esc($gasto['costo_paquete']) ?>">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label fw-bold small text-primary">Cantidad de Unidades</label>
                                    <input type="number" class="form-control form-control-lg" 
                                           name="cantidad_paquete" id="inputCantidadPaquete" 
                                           value="<?= esc($gasto['cantidad_paquete']) ?>">
                                </div>
                            </div>
                            
                            <div class="alert alert-primary d-flex align-items-center mt-3 border-0 shadow-sm">
                                <i class="fa-solid fa-calculator me-3 fs-3"></i>
                                <div>
                                    <small class="text-uppercase fw-bold opacity-75 d-block" style="font-size: 0.7rem;">Costo por unidad actual:</small>
                                    <h3 class="mb-0 fw-bold" id="resultadoCalculo">$ <?= number_format($gasto['precio_unitario'], 4) ?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold p-3 shadow" style="background-color: var(--azul-logo); border:none; border-radius: 12px;">
                                <i class="fa-solid fa-arrows-rotate me-2"></i>ACTUALIZAR GASTO
                            </button>
                            <a href="<?= base_url('gastos') ?>" class="btn btn-link text-muted text-decoration-none text-center">
                                Cancelar y volver
                            </a>
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
        background-size: cover; 
        background-attachment: fixed;
    }

    /* Animación para suavizar el cambio entre modos */
    .animate__fadeIn {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const switchPaquete = document.getElementById('switchPaquete');
        const modoUnidad = document.getElementById('modoUnidad');
        const modoPaquete = document.getElementById('modoPaquete');
        const inputCostoPaquete = document.getElementById('inputCostoPaquete');
        const inputCantidadPaquete = document.getElementById('inputCantidadPaquete');
        const resultadoCalculo = document.getElementById('resultadoCalculo');

        // Función para mostrar/ocultar campos
        function toggleModo() {
            if (switchPaquete.checked) {
                modoUnidad.style.display = 'none';
                modoPaquete.style.display = 'block';
                calcularUnitario(); 
            } else {
                modoUnidad.style.display = 'block';
                modoPaquete.style.display = 'none';
            }
        }

        // Calculadora
        function calcularUnitario() {
            const costo = parseFloat(inputCostoPaquete.value) || 0;
            const cantidad = parseFloat(inputCantidadPaquete.value) || 1;
            if(cantidad > 0) {
                const unitario = costo / cantidad;
                resultadoCalculo.innerText = '$ ' + unitario.toFixed(4);
            }
        }

        // Eventos
        switchPaquete.addEventListener('change', toggleModo);
        inputCostoPaquete.addEventListener('input', calcularUnitario);
        inputCantidadPaquete.addEventListener('input', calcularUnitario);

        // EJjecutar al cargar para ver el estado inicial
        toggleModo();
    });
</script>
<?= $this->endSection() ?>