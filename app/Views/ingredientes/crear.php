<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center py-2 py-md-4 px-2">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

        <div class="card shadow border-0 rounded-4">
            <div class="card-header py-3 bg-white border-bottom-0 rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-basket-shopping me-2 fa-lg" style="color: var(--marron-logo);"></i>
                        <h4 class="mb-0 fw-bold" style="color: var(--marron-logo); line-height: 1.2;">
                            Registrar Ingrediente o Insumo
                        </h4>
                    </div>

                    <a href="<?= base_url('ingredientes') ?>" class="btn btn-sm text-secondary hover-zoom">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-sm-4 p-md-5 pt-2">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger shadow-sm border-0 mb-4 animate__animated animate__headShake">
                        <i class="fa-solid fa-circle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('ingredientes/guardar') ?>" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Nombre del Ingrediente o Insumo</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-tag text-muted"></i></span>
                            <input type="text" name="nombre" class="form-control border-start-0 ps-0 fs-6" placeholder="Ej: Harina, Huevos, Envase, Caja..." required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Cantidad del Paquete</label>
                            <input type="number" step="0.01" name="cantidad" class="form-control form-control-lg fs-6" placeholder="Ej: 1000 o 50" required>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Medida</label>
                            <select name="unidad_id" class="form-select form-select-lg fs-6" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <?php foreach ($unidades as $unidad): ?>
                                    <option value="<?= $unidad['Id_unidad'] ?>">
                                        <?= esc($unidad['nombre_unidad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary small text-uppercase mt-2">Precio Total Pagado</label>
                            <div class="input-group input-group-lg shadow-sm rounded">
                                <span class="input-group-text bg-success text-white border-0 px-4">$</span>
                                <input type="number" step="0.01" name="precio" class="form-control border-success fs-4 fw-bold text-success" placeholder="0.00" required>
                            </div>
                            <div class="form-text text-muted small">
                                <i class="fa-solid fa-circle-info me-1"></i>Ingresa el valor total que pagaste por el paquete completo.
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow fw-bold p-3" style="background-color: var(--marron-logo); border-color: var(--marron-logo);">
                            <i class="fa-solid fa-floppy-disk me-2"></i>GUARDAR REGISTRO
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), 
            rgba(255, 255, 255, 0.75)), 
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important; 
        background-position: center !important; 
        background-attachment: fixed !important; 
        background-repeat: no-repeat !important; 
    }

    main, .wrapper, #content { background: transparent !important; }

    .card {
        background-color: rgba(255, 255, 255, 0.95) !important; 
        backdrop-filter: blur(10px); 
        border-radius: 20px; 
        border: none !important; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }

    .hover-zoom:hover {
        transform: scale(1.1);
        color: #dc3545 !important;
        transition: all 0.2s ease;
    }
</style>

<?= $this->endSection() ?>