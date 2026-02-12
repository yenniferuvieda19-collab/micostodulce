<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
    /* Estética general y fondo transparente */
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

    /* Tarjeta transparente con desenfoque (Glassmorphism) */
    .card-transparente {
        background-color: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(10px);
        border-radius: 20px !important;
        border: none !important;
        transition: transform 0.2s;
    }

    .card-transparente:hover { 
        transform: translateY(-5px); 
    }

    /* Estilo específico para el badge de fecha */
    .badge-fecha {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
    }
</style>

<div class="dashboard-container">
    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: var(--azul-logo);">
                    <i class="fa-solid fa-chart-pie me-2" style="color: var(--rosa-logo);"></i>Detalle de Venta
                </h2>
                <p class="text-muted small">Análisis detallado del ingreso registrado</p>
            </div>
            <div class="text-end">
                <span class="badge rounded-pill badge-fecha text-dark border px-3 py-2 shadow-sm">
                    <i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y', strtotime($venta['fecha_venta'])) ?>
                </span>
            </div>
        </div>

        <div class="card card-transparente shadow-sm mb-4">
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
                <div class="card card-transparente shadow-sm text-center p-4 h-100">
                    <div class="mb-2">
                        <i class="fa-solid fa-boxes-stacked text-warning fs-1"></i>
                    </div>
                    <h5 class="text-muted small fw-bold text-uppercase">Cantidad Vendida</h5>
                    <h2 class="fw-bold"><?= esc($venta['cantidad_vendida']) ?> <small class="fs-6 text-muted">und</small></h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-transparente shadow-sm text-center p-4 h-100">
                    <div class="mb-2">
                        <i class="fa-solid fa-tag text-info fs-1"></i>
                    </div>
                    <h5 class="text-muted small fw-bold text-uppercase">Precio Unitario</h5>
                    <h2 class="fw-bold">$<?= number_format($venta['precio_unitario'], 2) ?></h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-transparente shadow-sm text-center p-4 h-100" style="border-bottom: 5px solid #198754 !important;">
                    <div class="mb-2">
                        <i class="fa-solid fa-money-bill-trend-up text-success fs-1"></i>
                    </div>
                    <h5 class="text-muted small fw-bold text-uppercase">Total Recibido</h5>
                    <h2 class="fw-bold text-success">$<?= number_format($venta['precio_venta_total'], 2) ?></h2>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="<?= base_url('ventas') ?>" class="btn btn-white rounded-pill px-5 py-2 shadow-sm border fw-bold text-muted" style="background-color: white;">
                <i class="fa-solid fa-arrow-left me-2"></i> Volver al listado
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>