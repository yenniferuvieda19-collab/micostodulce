<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--azul-logo);">
                <i class="fa-solid fa-chart-pie me-2" style="color: var(--rosa-logo);"></i>Detalle de Venta
            </h2>
            <p class="text-muted small">Análisis detallado del ingreso registrado</p>
        </div>
        <div class="text-end">
            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                <i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y', strtotime($venta['fecha_venta'])) ?>
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background: linear-gradient(to right, #ffffff, #fdfbff);">
        <div class="card-body p-4 d-flex align-items-center">
            <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-cake-candles fs-3" style="color: var(--rosa-logo);"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0" style="color: var(--azul-logo);"><?= esc($venta['nombre_receta']) ?></h3>
                <span class="text-muted small">ID de Producción: #<?= $venta['Id_produccion'] ?></span>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 h-100" style="border-radius: 15px;">
                <div class="mb-2">
                    <i class="fa-solid fa-boxes-stacked text-warning fs-1"></i>
                </div>
                <h5 class="text-muted small fw-bold text-uppercase">Cantidad Vendida</h5>
                <h2 class="fw-bold"><?= esc($venta['cantidad_vendida']) ?> <small class="fs-6 text-muted">und</small></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 h-100" style="border-radius: 15px;">
                <div class="mb-2">
                    <i class="fa-solid fa-tag text-info fs-1"></i>
                </div>
                <h5 class="text-muted small fw-bold text-uppercase">Precio Unitario</h5>
                <h2 class="fw-bold">$<?= number_format($venta['precio_unitario'], 2) ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 h-100" style="border-radius: 15px; border-bottom: 5px solid #198754 !important;">
                <div class="mb-2">
                    <i class="fa-solid fa-money-bill-trend-up text-success fs-1"></i>
                </div>
                <h5 class="text-muted small fw-bold text-uppercase">Total Recibido</h5>
                <h2 class="fw-bold text-success">$<?= number_format($venta['precio_venta_total'], 2) ?></h2>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="<?= base_url('ventas') ?>" class="btn btn-light rounded-pill px-5 py-2 shadow-sm border">
            <i class="fa-solid fa-arrow-left me-2"></i> Volver al listado
        </a>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
</style>
<?= $this->endSection() ?>