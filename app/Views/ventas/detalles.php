<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container py-4">
    <div class="mb-4 text-center">
        <h2 class="fw-bold" style="color: var(--azul-logo);">Análisis de Rendimiento</h2>
        <p class="text-muted">Balance detallado entre costos e ingresos</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                <i class="fa-solid fa-money-bill-trend-up text-success fs-1 mb-2"></i>
                <h5 class="text-muted small">GANANCIA NETA</h5>
                <h2 class="fw-bold text-success">$<?= number_format($v['ganancia_total'], 2) ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                <i class="fa-solid fa-hand-holding-dollar text-primary fs-1 mb-2"></i>
                <h5 class="text-muted small">REINVERSIÓN</h5>
                <h2 class="fw-bold text-primary">$<?= number_format($v['costo_reinversion'], 2) ?></h2>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="<?= base_url('ventas') ?>" class="btn btn-outline-secondary rounded-pill px-5">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver al Resumen
        </a>
    </div>
</div>
<?= $this->endSection() ?>