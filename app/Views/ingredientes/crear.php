<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center py-3" style="background-color: var(--azul-logo);">
                <h4 class="mb-0" style="color: var(--marron-logo);">
                    <i class="fa-solid fa-plus-circle me-2"></i>Nuevo Insumo
                </h4>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('ingredientes/guardar') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Ingrediente</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Harina de Trigo" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Cantidad Total</label>
                            <input type="number" step="0.01" name="cantidad" class="form-control" placeholder="1000" required>
                            <small class="text-muted">Gramos, mililitros o unidades</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Precio Compra ($)</label>
                            <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar Insumo</button>
                        <a href="<?= base_url('ingredientes') ?>" class="btn btn-link text-muted">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>