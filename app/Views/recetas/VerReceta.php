<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('recetas') ?>" class="btn btn-outline-secondary rounded-pill">
                <i class="fa-solid fa-arrow-left me-2"></i>Volver
            </a>

            <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>" class="btn btn-primary rounded-pill px-4" style="background-color: var(--azul-logo); border:none;">
                <i class="fa-solid fa-pen me-2"></i>Editar
            </a>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">

            <div class="card-header bg-white p-4 text-center border-bottom-0 pb-0">
                <h2 class="fw-bold mb-3" style="color: var(--azul-logo);"><?= esc($receta['nombre_postre']) ?></h2>
            </div>

            <div class="card-body p-4 pt-0">

                <div class="d-flex justify-content-center mb-4">
                    <span class="badge bg-light text-secondary fs-6 px-4 py-2 border rounded-pill">
                        <i class="fa-solid fa-chart-pie me-2"></i><?= esc($receta['porciones']) ?> Porciones
                    </span>
                </div>

                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8">
                        <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                            <i class="fa-solid fa-basket-shopping me-2"></i>Ingredientes
                        </h5>

                        <ul class="list-group list-group-flush mb-4">
                            <?php if (!empty($detalles)): ?>
                                <?php foreach ($detalles as $det): ?>
                                    <?php
                                    $lbl = 'Und';
                                    $cant = (float)$det['cantidad_requerida'];
                                    switch ($det['Id_unidad_base']) {
                                        case 1:
                                            $lbl = 'gr';
                                            break;
                                        case 2:
                                            $lbl = 'Kg';
                                            break;
                                        case 3:
                                            $lbl = 'ml';
                                            break;
                                        case 4:
                                            $lbl = 'Lt';
                                            break;
                                    }
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0 border-bottom-0">
                                        <span class="text-dark"><?= esc($det['nombre_ingrediente']) ?></span>
                                        <span class="fw-bold text-secondary">
                                            <?= $cant ?> <?= $lbl ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted">No hay ingredientes.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="p-3 rounded-3 text-center h-100" style="background-color: #fff5f5; border: 1px solid #ffcccc;">
                                    <div class="mb-2">
                                        <span class="badge bg-danger">COSTO DE INVERSIÓN</span>
                                    </div>
                                    <h4 class="fw-bold text-danger mb-0">
                                        $ <?= number_format($receta['costo_ingredientes'], 2, '.', ',') ?>
                                    </h4>
                                    <small class="text-muted">Total Receta</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 rounded-3 text-center h-100" style="background-color: #f0fff4; border: 1px solid #c3e6cb;">
                                    <div class="mb-2">
                                        <span class="badge bg-success">PRECIO VENTA</span>
                                    </div>
                                    <h4 class="fw-bold text-success mb-0">
                                        $ <?= number_format($receta['precio_venta_sug'], 2, '.', ',') ?>
                                    </h4>
                                    <small class="text-muted">Sugerido</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <?php if (!empty($receta['notas'])): ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="alert alert-warning border-0 shadow-sm d-flex">
                                <i class="fa-solid fa-sticky-note me-3 mt-1 fs-5"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Nota:</h6>
                                    <p class="mb-0 small text-dark"><?= esc($receta['notas']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

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

    main,
    .wrapper,
    #content {
        background: transparent !important;
    }

    .dashboard-container {
        background: transparent !important;
        width: 100% !important;
        min-height: 100vh;
        padding-top: 1rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 15px;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<?= $this->endSection() ?>