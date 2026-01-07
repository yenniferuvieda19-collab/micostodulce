<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container mt-4">

    <?php if (session()->getFlashdata('mensaje_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <?= session()->getFlashdata('mensaje_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('mensaje_exito')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>
            <?= session()->getFlashdata('mensaje_exito') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: var(--azul-logo);">Mis Insumos</h2>
            <p class="text-muted">Gestiona los precios de tus compras.</p>
        </div>
        <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
            <i class="fa-solid fa-plus me-2"></i>Nuevo Insumo
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-secondary">
                            <th class="ps-4">Ingrediente</th>

                            <th class="text-center">Precio Compra</th>
                            <th class="text-center">Cantidad Compra</th>
                            <th class="text-center">Unidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ingredientes)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-basket-shopping fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p>Aún no tienes ingredientes registrados.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ingredientes as $ing): ?>

                                <?php
                                // lógica de abreviación
                                $txtUnidad = 'Und';
                                switch ($ing['Id_unidad_base']) {
                                    case 1:
                                        $txtUnidad = 'gr';
                                        break;
                                    case 2:
                                        $txtUnidad = 'kg';
                                        break;
                                    case 3:
                                        $txtUnidad = 'ml';
                                        break;
                                    case 4:
                                        $txtUnidad = 'Lt';
                                        break;
                                    case 5:
                                        $txtUnidad = 'Und';
                                        break;
                                    default:
                                        $txtUnidad = $ing['nombre_unidad'];
                                }
                                ?>

                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?= esc($ing['nombre_ingrediente']) ?></td>

                                    <td class="text-center text-success fw-bold">
                                        $ <?= number_format($ing['costo_unidad'], 2) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= (float)$ing['cantidad_paquete'] ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border text-uppercase" style="min-width: 45px;">
                                            <?= $txtUnidad ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1"> <a href="<?= base_url('ingredientes/editar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-primary border-0" title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('ingredientes/borrar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-danger border-0"
                                                onclick="return confirm('¿Seguro que quieres eliminar este insumo?');" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
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

<?= $this->endSection() ?>