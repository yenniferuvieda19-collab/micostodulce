<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color: var(--marron-logo);">Mis Insumos</h2>
    <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill">
        <i class="fa-solid fa-plus me-2"></i>Nuevo Ingrediente
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: var(--azul-logo); color: var(--marron-logo);">
                <tr>
                    <th class="ps-4">Ingrediente</th>
                    <th>Cantidad Pack</th>
                    <th>Costo</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ps-4 fw-bold">Harina de Trigo (Todo uso)</td>
                    <td>1000 gr</td>
                    <td>$ 1.50</td>
                    <td class="text-end pe-4">
                        <a href="#" class="btn btn-sm btn-outline-secondary border-0"><i class="fa-solid fa-pen"></i></a>
                        <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>