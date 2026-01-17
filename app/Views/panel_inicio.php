<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container"> 
    <div class="container mt-0"> 
        
        <div class="mb-4">
            <h2 class="fw-bold" style="color: var(--azul-logo);">
                Hola nuevamente<?= session()->get('nombre') ? ', ' . session()->get('nombre') : '' ?> 👋
            </h2>
            <p class="fs-5 fw-medium text-dark">Aquí tienes un resumen de tu negocio hoy.</p>
        </div>

        <div class="row g-4 mb-5">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
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

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
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

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
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

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Últimas Recetas Agregadas</h5>
                <a href="<?= base_url('recetas') ?>" class="btn btn-sm btn-link text-decoration-none">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Recetas</th>
                                <th class="text-center">Porciones</th>
                                <th class="text-center">Precio Venta</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ultimasRecetas)): ?>
                                <?php foreach ($ultimasRecetas as $receta): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?= esc($receta['nombre_postre']) ?></td>
                                        <td class="text-center"><?= esc($receta['porciones']) ?></td>
                                        <td class="text-center text-success fw-bold">$ <?= number_format($receta['precio_venta_sug'], 2, '.', ',') ?></td>
                                        <td class="text-end pe-4">
                                            <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>" class="btn btn-sm btn-light text-primary me-1" title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta']) ?>" class="btn btn-sm btn-light text-danger btn-eliminar-panel" title="Borrar">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<style> 
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), 
        url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important; 
        background-size: cover !important; 
        background-position: center !important; 
        background-attachment: fixed !important; 
        background-repeat: no-repeat !important; 
        margin: 0 !important; padding: 0 !important;
    }
    main, .container-fluid, .wrapper, #content {background: transparent !important;}
    .dashboard-container { background: transparent !important; width: 100% !important; min-height: 100vh; padding-top: 2rem; padding-bottom: 3rem; }
    .card {background-color: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(8px); border-radius: 15px; border: none !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;}
    .hover-scale:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .10) !important; transition: transform 0.3s ease; cursor: pointer; } 
</style>

<?= $this->endSection() ?>