<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
    /* puse Estética general y fondo transparente */
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75),
                rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        background-repeat: no-repeat !important;
    }

    main, .wrapper, #content {
        background: transparent !important;
    }

    .dashboard-container {
        min-height: 100vh;
        padding-top: 2rem;
        padding-bottom: 3rem;
        background: transparent !important;
    }

    /* Yennifer, agregué la tarjeta transparente con desenfoque (Glassmorphism) */
    .card-transparente {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border-radius: 20px !important;
        border: none !important;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #eee;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--rosa-logo);
        box-shadow: none;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<div class="dashboard-container">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card card-transparente shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4 text-center" style="color: var(--azul-logo);">
                            <i class="fa-solid fa-pen-to-square me-2" style="color: var(--rosa-logo);"></i>Editar Gasto Indirecto
                        </h3>
                        
                        <form action="<?= base_url('gastos/actualizar/'.$gasto['Id_gasto']) ?>" method="post">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Nombre del gasto</label>
                                <input type="text" class="form-control form-control-lg" name="nombre_gasto" 
                                       value="<?= esc($gasto['nombre_gasto']) ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase">Categoría</label>
                                <select class="form-select form-select-lg" name="categoria" required>
                                    <option value="Delivery" <?= ($gasto['categoria'] == 'Delivery') ? 'selected' : '' ?>>Delivery</option>
                                    <option value="Servicios Basicos" <?= ($gasto['categoria'] == 'Servicios Basicos') ? 'selected' : '' ?>>Mano de Obra</option>
                                    <option value="Otro" <?= ($gasto['categoria'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>

                            <hr class="my-4 opacity-25">

                            <div class="form-check form-switch mb-4 p-3 rounded bg-white border d-flex align-items-center shadow-sm" style="border-radius: 15px !important;">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" 
                                       id="switchTipoGasto" name="es_fijo" value="1" 
                                       <?= ($gasto['es_fijo'] == 1) ? 'checked' : '' ?> 
                                       style="transform: scale(1.3); cursor: pointer;">
                                
                                <label class="form-check-label fw-bold cursor-pointer small" for="switchTipoGasto">
                                    Actívalo si el gasto indirecto tiene costo fijo
                                    <small class="d-block text-muted fw-normal mt-1">
                                        Ejemplo: Delivery = $3.00
                                    </small>
                                </label>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase" id="labelValor">Valor</label>
                                <div class="input-group input-group-lg overflow-hidden" style="border-radius: 12px;">
                                    <span class="input-group-text fw-bold border-0" id="simboloValor" style="width: 50px; justify-content: center;">
                                        <?= ($gasto['es_fijo'] == 1) ? '$' : '%' ?>
                                    </span>
                                    
                                    <input type="number" step="0.01" class="form-control border-2" 
                                           name="valor_gasto" id="inputValor" 
                                           value="<?= esc($gasto['precio_unitario']) ?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm" style="background-color: var(--azul-logo); border:none;">
                                    <i class="fa-solid fa-rotate me-2"></i>ACTUALIZAR GASTO
                                </button>
                                <div class="text-center mt-2">
                                    <a href="<?= base_url('gastos') ?>" class="btn btn-link text-muted text-decoration-none small">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Cancelar y regresar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Andrés, aquí hice esto para actualizar dinámicamente el símbolo y el label
     * Mantenido exactamente igual para asegurar funcionalidad.
     */
    document.addEventListener('DOMContentLoaded', function() {
        const switchGasto = document.getElementById('switchTipoGasto');
        const labelValor = document.getElementById('labelValor');
        const simboloValor = document.getElementById('simboloValor');

        function actualizarFormulario() {
            if (switchGasto.checked) {
                
                labelValor.textContent = "Costo Fijo ($)";
                simboloValor.textContent = "$";
                simboloValor.className = "input-group-text bg-success text-white fw-bold border-0";
            } else {
               
                labelValor.textContent = "Porcentaje (%)";
                simboloValor.textContent = "%";
                simboloValor.className = "input-group-text bg-primary text-white fw-bold border-0";
            }
        }
        
        switchGasto.addEventListener('change', actualizarFormulario);
        actualizarFormulario();
    });
</script>
<?= $this->endSection() ?>