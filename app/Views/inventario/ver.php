<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

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

    main, .wrapper, #content {
        background: transparent !important;
    }

    .dashboard-container {
        min-height: 100vh;
        padding-top: 1rem;
        padding-bottom: 3rem;
        background: transparent !important;
    }

    /* Efecto Glassmorphism para la ficha de detalle */
    .card-detalle {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border-radius: 20px !important;
        overflow: hidden;
    }

    /* Estilo para que no se vea blanco sólido en el print */
    @media print {
        body { background: white !important; }
        .card-detalle { background: white !important; backdrop-filter: none; border: 1px solid #ddd !important; }
        .btn { display: none; } /* Ocultar botones al imprimir */
    }
</style>

<div class="dashboard-container">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('inventario') ?>" class="btn btn-outline-secondary rounded-pill bg-white">
                <i class="fa-solid fa-arrow-left me-2"></i>Volver al Inventario
            </a>
            <button onclick="window.print()" class="btn btn-light rounded-pill shadow-sm">
                <i class="fa-solid fa-print me-2"></i>Imprimir Ficha
            </button>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-detalle border-0 shadow-lg">
                    <div class="p-4 text-white text-center" style="background-color: var(--rosa-logo);">
                        <i class="fa-solid fa-cake-candles fs-1 mb-2"></i>
                        <h2 class="fw-bold mb-0">Detalle de Producción</h2>
                        <p class="mb-0 opacity-75">Control de Inventario - Mi Costo Dulce</p>
                    </div>

                    <div class="card-body p-5 bg-transparent">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold">Producto</label>
                                <h3 class="fw-bold" style="color: #003366;"><?= esc($p['nombre_receta']) ?></h3>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <label class="text-muted small text-uppercase fw-bold">Fecha de Elaboración</label>
                                <p class="h5"><?= date('d/m/Y', strtotime($p['fecha_produccion'])) ?></p>
                            </div>
                        </div>

                        <hr class="my-4" style="border-style: dashed;">

                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light shadow-sm">
                                    <label class="d-block small text-muted">Stock</label>
                                    <span class="h4 fw-bold"><?= $p['cantidad_producida'] ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light text-danger shadow-sm">
                                    <label class="d-block small opacity-75">Inversión</label>
                                    <span class="h4 fw-bold">$<?= number_format($p['costo_total_lote'], 2) ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 text-white shadow-sm" style="background-color: #003366;">
                                    <label class="d-block small opacity-75">PVP Total</label>
                                    <span class="h4 fw-bold">$<?= number_format($p['costo_adicional_total'], 2) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>