<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container"> 
    <div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: var(--azul-logo);">Mis Recetas</h2>
            <p class="fs-5 fw-medium text-dark">Calcula costos y define tus precios de venta.</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Acá agregué el botón de "Ver mis insumos" y lo unifiqué en un mismo bloque div que el de nueva receta para que estén más juntos -->
            <a href="<?= base_url("ingredientes") ?>" class="btn rounded-pill px-5 shadow-sm fw-bold text-white" style="background-color: #ee1d6dff;border:none;">
                <i class="fa-soild me-2"></i>Ver Mis Insumos</a>
        <a href="<?= base_url('recetas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
            <i class="fa-solid fa-plus me-2"></i>Nueva Receta</a>
        </div>
    </div>

    <?php if (empty($recetas)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-book-open fa-3x text-muted mb-3 opacity-50"></i>
            <h5 class="text-muted">No tienes recetas creadas aún.</h5>
            <p class="text-secondary small">¡Crea la primera para empezar a calcular tus ganancias!</p>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($recetas as $receta): ?>

                <?php
                $costoTotal  = $receta['costo_ingredientes'];
                $precioVenta = $receta['precio_venta_sug'];
                $porciones   = ($receta['porciones'] > 0) ? $receta['porciones'] : 1;

                // Costos unitarios
                $costoPorcion = $costoTotal / $porciones;

                // Ventas unitarias +20% por rebanada
                $precioPorcionBase = $precioVenta / $porciones;
                $precioPorcionVenta = $precioPorcionBase * 1.20;
                ?>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-shadow transition-all">

                        <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($receta['nombre_postre']) ?></h5>
                                <span class="badge bg-light text-secondary border">
                                    <i class="fa-solid fa-chart-pie me-1"></i> <?= esc($receta['porciones']) ?> Porciones
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>"
                                    class="btn btn-sm btn-outline-primary border-0"
                                    title="Editar Receta">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta']) ?>"
                                    class="btn btn-sm btn-outline-danger border-0"
                                    onclick="return confirm('¿Eliminar esta receta permanentemente?')"
                                    title="Eliminar Receta">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body px-4 pb-4">

                            <div class="mb-3 p-3 rounded-3" style="background-color: #fff5f5; border: 1px solid #ffcccc;">
                                <div class="mb-2">
                                    <span class="badge bg-danger">COSTO DE INVERSIÓN</span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-6 border-end border-danger-subtle">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">TOTAL</small>
                                        <span class="fw-bold text-danger">$ <?= number_format($costoTotal, 2) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">X PORCIÓN</small>
                                        <span class="fw-bold text-danger">$ <?= number_format($costoPorcion, 2) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 rounded-3" style="background-color: #f0fff4; border: 1px solid #c3e6cb;">
                                <div class="mb-2">
                                    <span class="badge bg-success">PRECIO VENTA SUGERIDO</span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-6 border-end border-success-subtle">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">TORTA ENTERA</small>
                                        <h5 class="fw-bold text-success mb-0">$ <?= number_format($precioVenta, 2) ?></h5>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">X REBANADA (+20%)</small>
                                        <h5 class="fw-bold text-success mb-0">$ <?= number_format($precioPorcionVenta, 2) ?></h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
    </div>
</div>

<style>/*Unifiqué el estilo con del de las tarjetas para agregar el fondo*/
    body {background-image: linear-gradient(rgba(255, 255, 255, 0.75), 
         rgba(255, 255, 255, 0.75)), 
        url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important; /*Agregué la ruta de la imagen*/
         background-size: cover !important; 
         background-position: center !important; 
         background-attachment: fixed !important; 
         background-repeat: no-repeat !important; 
        }

    main, .wrapper, #content {background: transparent !important;}

    .dashboard-container { background: transparent !important; 
        width: 100% !important; 
        min-height: 100vh; 
        padding-top: 1rem; 
        padding-bottom: 3rem; 
    }

    .card {background-color: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(8px); 
        border-radius: 15px; 
        border: none !important; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .8rem 2rem rgba(0, 0, 0, .15) !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>

<?= $this->endSection() ?>