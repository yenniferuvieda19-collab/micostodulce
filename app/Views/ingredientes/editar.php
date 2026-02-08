<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container"> 
    <div class="container py-2 py-md-4 px-3">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                
                <h3 class="fw-bold mb-4 text-center text-md-start" style="color: var(--marron-logo);">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Editar Insumo
                </h3>

                <div class="card shadow-sm p-3 p-md-4 border-0 rounded-4">
                    <form action="<?= base_url('ingredientes/actualizar/' . $ingrediente['Id_ingrediente']) ?>" method="post">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Nombre del Ingrediente</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 fs-6" name="nombre"
                                    value="<?= esc($ingrediente['nombre_ingrediente']) ?>" placeholder="Ej: Harina" required>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6 mb-3">
                                <label for="precio" class="form-label fw-bold text-secondary small text-uppercase">Costo de Compra ($)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-success text-white border-0">$</span>
                                    <input type="number" step="0.01" class="form-control border-success fs-5 fw-bold text-success" name="precio" id="precio"
                                        value="<?= (float)$ingrediente['costo_unidad'] ?>" required>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 mb-3">
                                <label for="cantidad" class="form-label fw-bold text-secondary small text-uppercase">Cantidad del Paquete</label>
                                <input type="number" step="0.01" class="form-control form-control-lg fs-6" name="cantidad" id="cantidad"
                                    value="<?= (float)$ingrediente['cantidad_paquete'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Unidad de Medida</label>
                            <select class="form-select form-select-lg fs-6" name="unidad_id">
                                <?php foreach ($unidades as $u): ?>
                                    <option value="<?= $u['Id_unidad'] ?>"
                                        <?= ($u['Id_unidad'] == $ingrediente['Id_unidad_base']) ? 'selected' : '' ?>>
                                        <?= esc($u['nombre_unidad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text mt-2 small">Asegúrate de que la unidad coincida con la cantidad ingresada.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= base_url('ingredientes') ?>" class="btn btn-light btn-lg px-4 fw-bold text-muted border-0">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold shadow-sm" style="background-color: var(--azul-logo); border:none;">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    .card {background-color: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(10px); 
        border-radius: 20px; 
        border: none !important; 
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    /* Mejora táctil para móviles */
    @media (max-width: 576px) {
        .btn-lg { padding: 1rem; }
    }
</style>
<?= $this->endSection() ?>