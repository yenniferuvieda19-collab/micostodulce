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
                    <h2 class="fw-bold mb-0" style="color: var(--negro-logo);"><?= $receta['nombre'] ?></h2>
                    <span class="badge rounded-pill p-2 px-3" style="background-color: var(--azul-logo); color: var(--marron-logo);">
                        Rinde: <?= $receta['porciones'] ?> unidades
                    </span>
                </div>

                <h6 class="fw-bold text-uppercase small text-muted mb-3">Desglose de insumos</h6>
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr class="small text-muted border-bottom">
                            <th>Ingrediente</th>
                            <th>Cantidad usada</th>
                            <th class="text-end">Costo proporcional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Harina de Trigo</td>
                            <td>500 gr</td>
                            <td class="text-end fw-bold">$ 0.75</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center p-4" style="border-top: 5px solid var(--rosa-logo) !important;">
            <p class="text-muted small text-uppercase mb-1">Costo total de producción</p>
            <h2 class="fw-bold mb-4" style="color: var(--marron-logo);">$ <?= $receta['costo_total'] ?></h2>
            
            <div class="p-3 rounded mb-4" style="background-color: #f4f9fa;">
                <p class="text-muted small mb-1">Costo por unidad</p>
                <h4 class="fw-bold text-rosa mb-0">$ <?= number_format($receta['costo_total'] / $receta['porciones'], 2) ?></h4>
            </div>

            <button class="btn btn-outline-custom w-100 mb-2">
                <i class="fa-solid fa-print me-2"></i>Imprimir Receta
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>