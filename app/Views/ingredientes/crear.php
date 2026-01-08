<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-6">

        <div class="card shadow border-0">
            <div class="card-header py-3 bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold" style="color: var(--marron-logo);">
                        <i class="fa-solid fa-basket-shopping me-2"></i>Registrar Insumo
                    </h4>
                    <a href="<?= base_url('ingredientes') ?>" class="btn btn-sm text-secondary">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-4">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger shadow-sm border-0 mb-4">
                        <i class="fa-solid fa-circle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('ingredientes/guardar') ?>" method="POST">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Nombre del Ingrediente</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-tag text-muted"></i></span>
                            <input type="text" name="nombre" class="form-control border-start-0 ps-0" placeholder="Ej: Harina, Huevos, Leche..." required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Cantidad del Paquete</label>
                            <input type="number" step="0.01" name="cantidad" class="form-control" placeholder="Ej: 1000" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Medida</label>

                            <select name="unidad_id" class="form-select" required>
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
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-success text-white border-0">$</span>
                                <input type="number" step="0.01" name="precio" class="form-control border-success" placeholder="0.00" required>
                            </div>
                            <div class="form-text text-muted">Ingresa el valor total que pagaste por el paquete.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm" style="background-color: var(--marron-logo); border-color: var(--marron-logo);">
                            Guardar Insumo
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>