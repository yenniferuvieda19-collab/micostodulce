<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row">
    <div class="col-12 mb-4">
        <a href="<?= base_url('recetas') ?>" class="text-decoration-none text-muted small">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver a mis recetas
        </a>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <h2 class="fw-bold mb-0" style="color: var(--negro-logo);"><?= esc($receta['nombre_postre']) ?></h2>
                    <span class="badge rounded-pill p-2 px-3" style="background-color: var(--azul-logo); color: white;">
                        Rinde: <?= esc($receta['porciones']) ?> unidades
                    </span>
                </div>

                <h6 class="fw-bold text-uppercase small text-muted mb-3">Desglose de insumos</h6>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr class="small text-muted border-bottom">
                                <th>Ingrediente</th>
                                <th>Cantidad usada</th>
                                <th class="text-end">Costo proporcional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ingredientes_receta)): ?>
                                <?php foreach ($ingredientes_receta as $ing): ?>
                                    <tr>
                                        <td><?= esc($ing['nombre']) ?></td>
                                        <td><?= esc($ing['cantidad_usada']) ?> <?= esc($ing['unidad_medida']) ?></td>
                                        <td class="text-end fw-bold">$ <?= number_format($ing['costo_proporcional'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted small py-3">No hay ingredientes registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-top">
                                <td colspan="2" class="fw-bold text-end">Subtotal Ingredientes:</td>
                                <td class="text-end fw-bold text-primary">$ <?= number_format($receta['costo_ingredientes'], 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center p-4" style="border-top: 5px solid var(--rosa-logo) !important;">
            <p class="text-muted small text-uppercase mb-1">Costo total de producción</p>
            <h2 class="fw-bold mb-4" style="color: var(--azul-logo);">$ <?= number_format($receta['costo_ingredientes'], 2) ?></h2>

            <div class="p-3 rounded mb-4" style="background-color: #f4f9fa;">
                <p class="text-muted small mb-1">Costo por unidad</p>
                <?php 
                    $porciones = ($receta['porciones'] > 0) ? $receta['porciones'] : 1;
                    $costoPorUnidad = $receta['costo_ingredientes'] / $porciones;
                ?>
                <h4 class="fw-bold mb-0" style="color: #ee1d6dff;">$ <?= number_format($costoPorUnidad, 2) ?></h4>
            </div>

            <button class="btn btn-outline-dark w-100 mb-2 rounded-pill" onclick="window.print()">
                <i class="fa-solid fa-print me-2"></i>Imprimir Receta
            </button>
            
            <a href="<?= base_url('recetas/editar/' . $receta['Id_receta']) ?>" class="btn btn-primary w-100 rounded-pill" style="background-color: var(--azul-logo); border: none;">
                <i class="fa-solid fa-pen-to-square me-2"></i>Editar Datos
            </a>
        </div>
    </div>
</div>

<style>
    .text-rosa { color: #ee1d6dff; }
    
    @media print {
        .btn, .text-muted.small, i { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<?= $this->endSection() ?>