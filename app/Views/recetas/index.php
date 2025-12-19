<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color: var(--marron-logo);">Mis Recetas</h2>
        <p class="text-muted">Tus creaciones y sus costos de producción</p>
    </div>
    <a href="<?= base_url('recetas/crear') ?>" class="btn btn-primary rounded-pill px-4">
        <i class="fa-solid fa-plus me-2"></i>Nueva Receta
    </a>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold mb-0">Cupcakes de Red Velvet</h5>
                    <span class="badge bg-light text-dark border">$ 4.20</span>
                </div>
                <p class="text-muted small">Rinde: 12 unidades</p>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('recetas/ver/1') ?>" class="btn btn-sm btn-outline-custom w-100">Ver detalles</a>
                    <a href="<?= base_url('recetas/editar/1') ?>" class="btn btn-sm btn-light"><i class="fa-solid fa-pen"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 text-center py-5">
        <p class="text-muted italic">¿Aún no has costeado nada? ¡Empieza hoy!</p>
    </div>
</div>

<?= $this->endSection() ?>