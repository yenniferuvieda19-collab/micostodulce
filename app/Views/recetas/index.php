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
                <a href="<?= base_url("ingredientes") ?>" class="btn rounded-pill px-4 shadow-sm fw-bold text-white" style="background-color: #ee1d6dff; border:none;">
                    <i class="fa-solid fa-basket-shopping me-2"></i>Insumos
                </a>

                <a href="<?= base_url("gastos") ?>" class="btn rounded-pill px-4 shadow-sm fw-bold bg-white text-dark border">
                    <i class="fa-solid fa-hand-holding-dollar me-2 text-warning"></i>Ir a Costos Indirectos
                </a>

                <a href="<?= base_url('inventario') ?>" class="btn btn-outline-primary rounded-pill px-4 shadow-sm me-2">
                    <i class="fa-solid fa-boxes-stacked me-2"></i>Ver Inventario
                </a>

                <a href="<?= base_url('recetas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-plus me-2"></i>Nueva Receta
                </a>
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

                    $costoPorcion = $costoTotal / $porciones;
                    $precioPorcionBase = $precioVenta / $porciones;
                    
                    // Se mantiene el precio real de la porción sin el 20% extra
                    $precioPorcionVenta = $precioPorcionBase;
                    ?>

                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 hover-shadow transition-all">

                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="<?= base_url('recetas/ver/' . $receta['Id_receta']) ?>" class="text-decoration-none">
                                        <h5 class="fw-bold text-dark mb-1 hover-link"><?= esc($receta['nombre_postre']) ?></h5>
                                    </a>
                                    
                                    <span class="badge bg-light text-secondary border">
                                        <?php if ($porciones == 1): ?>
                                            <i class="fa-solid fa-cake-candles me-1"></i> Venta Unitaria
                                        <?php else: ?>
                                            <i class="fa-solid fa-chart-pie me-1"></i> <?= esc($receta['porciones']) ?> Porciones
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>"
                                        class="btn btn-sm btn-outline-primary border-0" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    
                                    <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta']) ?>"
                                        class="btn btn-sm btn-outline-danger border-0 btn-eliminar"
                                        title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body px-4 pb-4">

                                <div class="mb-3 p-3 rounded-3" style="background-color: #fff5f5; border: 1px solid #ffcccc;">
                                    <div class="mb-2">
                                        <span class="badge bg-danger">COSTO DE INVERSIÓN</span>
                                    </div>

                                    <?php if ($porciones == 1): ?>
                                        <div class="text-center">
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">COSTO TOTAL</small>
                                            <span class="fw-bold text-danger fs-5">$ <?= number_format($costoTotal, 2, '.', ',') ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="row text-center">
                                            <div class="col-6 border-end border-danger-subtle">
                                                <small class="text-muted d-block" style="font-size: 0.7rem;">TOTAL LOTE</small>
                                                <span class="fw-bold text-danger">$ <?= number_format($costoTotal, 2, '.', ',') ?></span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block" style="font-size: 0.7rem;">C/U (COSTO)</small>
                                                <span class="fw-bold text-danger">$ <?= number_format($costoPorcion, 2, '.', ',') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="p-3 rounded-3" style="background-color: #f0fff4; border: 1px solid #c3e6cb;">
                                    <div class="mb-2">
                                        <span class="badge bg-success">PRECIO VENTA SUGERIDO</span>
                                    </div>
                                    
                                    <?php if ($porciones == 1): ?>
                                        <div class="text-center">
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">PRECIO UNITARIO</small>
                                            <h3 class="fw-bold text-success mb-0">$ <?= number_format($precioVenta, 2, '.', ',') ?></h3>
                                        </div>
                                    <?php else: ?>
                                        <div class="row text-center align-items-center">
                                            <div class="col-5 border-end border-success-subtle">
                                                <small class="text-muted d-block" style="font-size: 0.65rem;">LOTE COMPLETO</small>
                                                <h6 class="fw-bold text-success mb-0 opacity-75">$ <?= number_format($precioVenta, 2, '.', ',') ?></h6>
                                            </div>
                                            <div class="col-7">
                                                <small class="text-success fw-bold d-block" style="font-size: 0.7rem;">PRECIO INDIVIDUAL</small>
                                                <h4 class="fw-bold text-success mb-0">$ <?= number_format($precioPorcionVenta, 2, '.', ',') ?></h4>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
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

    main, .wrapper, #content {
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

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .8rem 2rem rgba(0, 0, 0, .15) !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .hover-link:hover {
        color: var(--azul-logo) !important;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');

        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function(e) {
                e.preventDefault();
                const urlBorrar = this.getAttribute('href');

                Swal.fire({
                    title: '¿Eliminar esta receta?',
                    text: "Se borrarán todos los cálculos asociados.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = urlBorrar;
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>