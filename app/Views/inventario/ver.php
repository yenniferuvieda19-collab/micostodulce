<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?= base_url('inventario') ?>" class="btn btn-outline-secondary rounded-pill">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver al Inventario
        </a>
        <button onclick="window.print()" class="btn btn-light rounded-pill shadow-sm">
            <i class="fa-solid fa-print me-2"></i>Imprimir Ficha
        </button>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="p-4 text-white text-center" style="background-color: var(--rosa-logo);">
                    <i class="fa-solid fa-cake-candles fs-1 mb-2"></i>
                    <h2 class="fw-bold mb-0">Detalle de Producción</h2>
                    <p class="mb-0 opacity-75">Control de Inventario - Mi Costo Dulce</p>
                </div>

                <div class="card-body p-5 bg-white">
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
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light">
                                <label class="d-block small text-muted">Stock</label>
                                <span class="h4 fw-bold"><?= $p['cantidad_producida'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light text-danger">
                                <label class="d-block small opacity-75">Inversión</label>
                                <span class="h4 fw-bold">$<?= number_format($p['costo_total_lote'], 2) ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 text-white" style="background-color: #003366;">
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

<?= $this->endSection() ?>