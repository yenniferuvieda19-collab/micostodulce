<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color: var(--marron-logo);">Mis Insumos</h2>
    <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill">
        <i class="fa-solid fa-plus me-2"></i>Nuevo Ingrediente
    </a>
</div>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('mensaje') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: var(--azul-logo); color: var(--marron-logo);">
                <tr>
                    <th class="ps-4">Ingrediente</th>
                    <th>Cantidad Pack</th>
                    <th>Precio Compra</th>
                    <th>Costo Unitario</th> <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ingredientes) && is_array($ingredientes)): ?>
                    <?php foreach ($ingredientes as $insumo): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">
                                <?= esc($insumo['nombre_ingrediente']) ?>
                            </td>
                            <td><?= esc($insumo['cantidad_paquete']) ?></td>
                            <td>$ <?= number_format($insumo['precio_compra'], 2) ?></td>
                            <td class="fw-bold text-success">
                                $ <?= number_format($insumo['costo_unidad'], 4) ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= base_url('ingredientes/editar/'.$insumo['Id_ingrediente']) ?>" class="btn btn-sm btn-outline-secondary border-0">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="<?= base_url('ingredientes/borrar/'.$insumo['Id_ingrediente']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('¿Seguro que deseas borrar este ingrediente?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-basket-shopping fa-2x mb-2"></i><br>
                            No tienes ingredientes registrados aún.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>