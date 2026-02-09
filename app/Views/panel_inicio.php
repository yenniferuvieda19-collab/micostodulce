<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container px-3 px-md-4">

        <div class="mb-4 pt-2">
            <h2 class="fw-bold d-block d-md-inline" style="color: var(--azul-logo);">
                Hola nuevamente<?= session()->get('nombre') ? ', ' . session()->get('nombre') : '' ?> 👋
            </h2>
            <p class="fs-5 fw-medium text-dark mt-1">Aquí tienes un resumen de tu negocio hoy.</p>
        </div>

        <div class="row g-3 g-md-4 mb-4 justify-content-center">

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-2 p-md-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light text-primary rounded-circle p-3 me-3">
                            <i class="fa-solid fa-book-open fa-2x" style="color: var(--azul-logo);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Mis Recetas</h5>
                            <p class="text-muted small mb-0">Tienes <b><?= $totalRecetas ?? 0 ?></b> registradas.</p>
                        </div>
                        <a href="<?= base_url('recetas') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-2 p-md-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light text-success rounded-circle p-3 me-3">
                            <i class="fa-solid fa-basket-shopping fa-2x" style="color: var(--marron-logo);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Mis Insumos</h5>
                            <p class="text-muted small mb-0">Tienes <b><?= $totalIngredientes ?? 0 ?></b> registrados.</p>
                        </div>
                        <a href="<?= base_url('ingredientes') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-2 p-md-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light text-warning rounded-circle p-3 me-3">
                            <i class="fa-solid fa-hand-holding-dollar fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Costos Indirectos</h5>
                            <p class="text-muted small mb-0">Empaques, Servicios, Gas...</p>
                        </div>
                        <a href="<?= base_url('gastos') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>

            <?php /* Estoy añadiendo acá el botón para redirigir a ese apartado nuevo de inventario*/ ?>
        <div class="row g-3 g-md-4 mb-5 justify-content-center">

            <div class="col-12 col-sm-6 col-lg-4">
                 <div class="card border-0 shadow-sm h-100 p-2 p-md-3 hover-scale">
                    <div class="d-flex algin-items-center">
                        <div class="icon-box bg-light text-danger rounded-circle p-3 me-3">
                            <i class="fa-solid fa-kitchen-set fa-2x" style="color: var(--rosa-logo);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Producción</h5>
                            <p class="text-muted small">Gestiona tu inventario disponible</p>
                        </div>
                        <a href="<?= base_url('inventario') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <?php /*Estoy añadiendo acá el botón de ventas*/ ?>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-2 p-md-3 hover-scale">
                    <div class="d-flex algin-items-center">
                        <div class="icon-box bg-light rounded-circle p-3 me-3">
                            <i class="fa-solid fa-cash-register fa-2x" style="color: #28a745;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Ventas</h5>
                            <p class="text-muted small mb-0">Registra tus ventas y ganancias.</p>
                        </div>
                        <a href="<?= base_url('ventas') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
        


        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Últimas Recetas</h5>
                <?php if (!empty($ultimasRecetas)): ?>
                    <a href="<?= base_url('recetas') ?>" class="btn btn-sm text-rosa fw-bold text-decoration-none">Ver todas</a>
                <?php endif; ?>
            </div>

            <div class="card-body p-0">
                <?php if (empty($ultimasRecetas)): ?>
                    <div class="text-center py-5 px-3">
                        <div class="mb-3 text-muted opacity-25">
                            <i class="fa-solid fa-bowl-food fa-4x"></i>
                        </div>
                        <h6 class="text-muted fw-bold">Aún no hay actividad reciente</h6>
                        <p class="text-secondary small mb-4">Empieza a calcular tus costos creando tu primera receta ahora.</p>

                        <a href="<?= base_url('recetas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: var(--azul-logo); border:none;">
                            <i class="fa-solid fa-plus me-2"></i>Crear Nueva Receta
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 text-muted small fw-bold">RECETA</th>
                                    <th class="text-center border-0 text-muted small fw-bold">PORCIONES</th>
                                    <th class="text-center border-0 text-muted small fw-bold">PRECIO VENTA</th>
                                    <th class="text-end pe-4 border-0 text-muted small fw-bold">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ultimasRecetas as $receta): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold d-block" style="color: var(--negro-logo);"><?= esc($receta['nombre_postre']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark rounded-pill px-3 border"><?= esc($receta['porciones']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-success fw-bold">$ <?= number_format($receta['precio_venta_sug'], 2, '.', ',') ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded">
                                                <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>" class="btn btn-sm btn-white border" title="Editar">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>
                                                <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta'] . '?ref=panel') ?>"
                                                   class="btn btn-sm btn-white border btn-eliminar-panel"
                                                   title="Borrar">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        background-repeat: no-repeat !important;
    }

    .dashboard-container {
        min-height: 80vh;
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(10px);
        border-radius: 18px;
        transition: all 0.3s ease;
    }

    /* Mejora de la interacción en las tarjetas */
    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Estilo para las líneas de la tabla */
    .table > :not(caption) > * > * {
        padding: 1rem 0.5rem;
        border-bottom-color: rgba(0,0,0,0.05);
    }
</style>

<?= $this->endSection() ?>