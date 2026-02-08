<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container px-3 px-md-4">

        <?php if (session()->getFlashdata('mensaje_exito')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__fadeIn" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>
            <?= session()->getFlashdata('mensaje_exito') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--marron-logo);">Mis Insumos</h2>
                <p class="text-muted mb-0">Administra los precios y presentaciones de tus ingredientes.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end">
                <a href="<?= base_url('recetas') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold text-white flex-fill flex-md-grow-0" style="background-color: #ee1d6dff; border:none;">
                    <i class="fa-solid fa-arrow-right-arrow-left me-1 me-md-2"></i>Recetas
                </a>

                <a href="<?= base_url("gastos") ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border flex-fill flex-md-grow-0">
                    <i class="fa-solid fa-hand-holding-dollar me-1 me-md-2 text-warning"></i>Indirectos
                </a>

                <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill px-3 px-md-4 shadow-sm fw-bold flex-fill flex-md-grow-0" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-plus me-1 me-md-2"></i>Nuevo Insumo
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
                        <thead class="bg-light">
                            <tr class="text-secondary small text-uppercase">
                                <th class="ps-4 py-3">Ingrediente</th>
                                <th class="py-3 text-center">Presentación</th>
                                <th class="py-3 text-center">Precio Compra</th>
                                <th class="text-end pe-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ingredientes)): ?>
                                <?php foreach ($ingredientes as $ing): ?>
                                    <?php
                                    $lbl = 'Und';
                                    switch ($ing['Id_unidad_base']) {
                                        case 1: $lbl = 'gr'; break;
                                        case 2: $lbl = 'Kg'; break;
                                        case 3: $lbl = 'ml'; break;
                                        case 4: $lbl = 'Lt'; break;
                                        case 5: $lbl = 'Und'; break;
                                    }
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">
                                            <?= esc($ing['nombre_ingrediente']) ?>
                                        </td>

                                        <td class="text-secondary text-center">
                                            <span class="badge bg-white text-dark border px-3 rounded-pill shadow-sm">
                                                <i class="fa-solid fa-box text-muted me-1"></i>
                                                <?= floatval($ing['cantidad_paquete']) ?> <?= $lbl ?>
                                            </span>
                                        </td>

                                        <td class="fw-bold text-success text-center">
                                            $ <?= number_format($ing['costo_unidad'], 2, '.', ',') ?>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm">
                                                <a href="<?= base_url('ingredientes/editar/' . $ing['Id_ingrediente']) ?>"
                                                    class="btn btn-sm btn-white border px-3" title="Editar">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>

                                                <a href="<?= base_url('ingredientes/borrar/' . $ing['Id_ingrediente']) ?>"
                                                    class="btn btn-sm btn-white border px-3 btn-eliminar" title="Eliminar">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="fa-solid fa-basket-shopping fa-3x mb-3 opacity-25 text-brown"></i>
                                            <p class="mb-0 fw-bold">No tienes insumos registrados.</p>
                                            <small>Agrega tus ingredientes para empezar a costear.</small>
                                        </div>
                                    </td>
                                </tr>
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
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 15px;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-white { background-color: #fff; }
    .btn-white:hover { background-color: #f8f9fa; }

    .text-brown { color: var(--marron-logo); }

    /* Ajustes para los botones de acción en tabla */
    .btn-group .btn {
        border-radius: 8px !important;
        margin: 0 2px;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .8rem 2rem rgba(0, 0, 0, .15) !important;
    }

    .transition-all {
        transition: all 0.3s ease;
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
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción y el insumo se borrará permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
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