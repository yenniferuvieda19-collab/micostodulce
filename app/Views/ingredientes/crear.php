<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color: var(--marron-logo);">Registrar Insumo</h2>
    <a href="<?= base_url('ingredientes') ?>" class="btn btn-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-2"></i>Volver
    </a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger shadow-sm border-0">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('ingredientes/guardar') ?>" method="POST">
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nombre del Ingrediente</label>
                <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Ej: Harina, Huevos, Leche..." required>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Cantidad</label>
                    <input type="number" step="0.01" name="cantidad" class="form-control" placeholder="Ej: 1" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Medida</label>
                    <select name="unidad_medida" class="form-select">
                        <option value="gr">Gramos (gr)</option>
                        <option value="ml">Mililitros (ml)</option>
                        <option value="kg">Kilogramos (kg)</option>
                        <option value="lt">Litros (L)</option>
                        <option value="unidad">Unidad (Pieza)</option> </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Precio Total ($)</label>
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                    Guardar
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>