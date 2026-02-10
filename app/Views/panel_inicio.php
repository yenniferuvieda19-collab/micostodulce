<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container px-3 px-md-4">

        <div class="mb-4 pt-2">
            <h2 class="fw-bold d-block d-md-inline" style="color: var(--azul-logo);">
                Hola nuevamente<?= session()->get('Nombre') ? ', ' . session()->get('Nombre') : '' ?> 👋
            </h2>
            <p class="fs-5 fw-medium text-dark mt-1">Aquí tienes un resumen de tu negocio hoy.</p>
        </div>

        <?php if (isset($mostrarGuia) && $mostrarGuia): ?>
            <div class="card border-0 shadow-sm mb-5 overflow-hidden" style="border-radius: 20px; border-left: 6px solid var(--rosa-logo) !important;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4 class="fw-bold text-dark mb-1">¡Bienvenido a Mi Costo Dulce! 🧁</h4>
                            <p class="text-muted mb-4">Sigue estos pasos para comenzar a profesionalizar tus costos:</p>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 <?= (isset($pasoActual) && $pasoActual == 1) ? 'bg-white shadow-sm border' : 'bg-light opacity-75' ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-circle me-3 <?= (isset($pasoActual) && $pasoActual > 1) ? 'bg-success' : 'bg-danger' ?>" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <?= (isset($pasoActual) && $pasoActual > 1) ? '<i class="fa-solid fa-check"></i>' : '1' ?>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Registra tus Insumos</h6>
                                                <p class="small mb-0 text-muted">Harina, huevos, azúcar...</p>
                                            </div>
                                        </div>
                                        <?php if (isset($pasoActual) && $pasoActual == 1): ?>
                                            <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-sm btn-danger mt-2 w-100 rounded-pill shadow-sm">Empezar aquí</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 <?= (isset($pasoActual) && $pasoActual == 2) ? 'bg-white shadow-sm border' : 'bg-light opacity-75' ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-circle me-3 <?= (isset($pasoActual) && $pasoActual == 2) ? 'bg-primary' : 'bg-secondary' ?>" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">2</div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Crea tu Receta</h6>
                                                <p class="small mb-0 text-muted">Calcula costos y ventas.</p>
                                            </div>
                                        </div>
                                        <?php if (isset($pasoActual) && $pasoActual == 2): ?>
                                            <a href="<?= base_url('recetas/crear') ?>" class="btn btn-sm btn-primary mt-2 w-100 rounded-pill shadow-sm">Crear mi primera receta</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-center">
                            <i class="fa-solid fa-wand-magic-sparkles fa-5x opacity-25" style="color: var(--rosa-logo);"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light rounded-circle p-3 me-3">
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

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light rounded-circle p-3 me-3">
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

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light text-warning rounded-circle p-3 me-3">
                            <i class="fa-solid fa-hand-holding-dollar fa-2x"></i>
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

        <div class="row g-3 g-md-4 mb-5">
            <div class="col-12 col-md-6 col-lg-4 offset-lg-2">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light rounded-circle p-3 me-3">
                            <i class="fa-solid fa-kitchen-set fa-2x" style="color: var(--rosa-logo);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Producción</h5>
                            <p class="text-muted small mb-0">Gestiona tu inventario disponible</p>
                        </div>
                        <a href="<?= base_url('inventario') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light rounded-circle p-3 me-3">
                            <i class="fa-solid fa-cash-register fa-2x" style="color: #28a745;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Ventas</h5>
                            <p class="text-muted small mb-0">Registra tus ventas y ganancias.</p>
                        </div>
                        <a href="<?= base_url('ventas') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Últimas Recetas</h5>
                <?php if (!empty($ultimasRecetas)): ?>
                    <a href="<?= base_url('recetas') ?>" class="btn btn-sm fw-bold text-decoration-none" style="color: var(--rosa-logo);">Ver todas</a>
                <?php endif; ?>
            </div>

            <div class="card-body p-0">
                <?php if (empty($ultimasRecetas)): ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-bowl-food fa-3x text-muted opacity-25 mb-3"></i>
                        <h6 class="text-muted">Aún no has creado recetas.</h6>
                        <a href="<?= base_url('recetas/crear') ?>" class="btn btn-primary btn-sm rounded-pill mt-2">Crear mi primera receta</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
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
                                        <td class="ps-4 fw-bold"><?= esc($receta['nombre_postre']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark rounded-pill border px-3"><?= esc($receta['porciones']) ?></span>
                                        </td>
                                        <td class="text-center fw-bold text-success">
                                            $ <?= number_format($receta['precio_venta_sug'], 2) ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded border">
                                                <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>" class="btn btn-sm btn-white">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>
                                                <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta']) ?>" class="btn btn-sm btn-white">
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
    .dashboard-container {
        min-height: 80vh;
        padding-top: 1rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(5px);
        border-radius: 15px;
    }

    .hover-scale {
        transition: transform 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table thead th {
        letter-spacing: 1px;
        font-size: 0.75rem;
    }
</style>

<?= $this->endSection() ?>