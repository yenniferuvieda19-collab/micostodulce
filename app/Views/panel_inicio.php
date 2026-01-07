<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold" style="color: var(--azul-logo);">
            Hola<?= session()->get('nombre') ? ', ' . session()->get('nombre') : '' ?> 👋
        </h2>
        <p class="text-muted">Aquí tienes un resumen de tu negocio hoy.</p>
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-light text-primary rounded-circle p-3 me-3">
                        <i class="fa-solid fa-book-open fa-2x" style="color: var(--azul-logo);"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Ver Mis Recetas</h5>
                        <p class="text-muted small mb-0">Tienes <b><?= $totalRecetas ?? 0 ?></b> recetas registradas.</p>
                    </div>
                    <a href="<?= base_url('recetas') ?>" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 p-3 hover-scale">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-light text-success rounded-circle p-3 me-3">
                        <i class="fa-solid fa-basket-shopping fa-2x" style="color: var(--marron-logo);"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Mis Insumos</h5>
                        <p class="text-muted small mb-0">Tienes <b><?= $totalIngredientes ?? 0 ?></b> insumos registrados.</p>
                    </div>
                    <a href="<?= base_url('ingredientes') ?>" class="stretched-link"></a>
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
                            <th class="ps-4">Postre</th>
                            <th>Porciones</th>
                            <th>Precio Venta</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ultimasRecetas)): ?>
                            <?php foreach ($ultimasRecetas as $receta): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?= esc($receta['nombre_postre']) ?></td>
                                    <td><?= esc($receta['porciones']) ?></td>
                                    <td class="text-success fw-bold">$ <?= number_format($receta['precio_venta_sug'], 2) ?></td>
                                    <td class="text-end pe-4">

                                        <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>"
                                            class="btn btn-sm btn-light text-primary me-1"
                                            title="Editar Receta">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <a href="<?= base_url('recetas/borrar/' . $receta['Id_receta']) ?>"
                                            class="btn btn-sm btn-light text-danger"
                                            onclick="return confirm('¿Estás seguro de borrar esta receta?')"
                                            title="Borrar Receta">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-cookie-bite fa-2x mb-2 opacity-50"></i>
                                    <p class="mb-0">Aún no has creado recetas.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    /* Efecto para que las tarjetas se levanten al pasar el mouse */
    .hover-scale:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .10) !important;
        transition: transform 0.2s ease;
        cursor: pointer;
    }
</style>

<?= $this->endSection() ?>