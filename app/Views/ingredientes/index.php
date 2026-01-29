<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container">

        <?php if (session()->getFlashdata('mensaje_exito')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>
            <?= session()->getFlashdata('mensaje_exito') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold" style="color: var(--marron-logo);">Mis Insumos</h2>
                <p class="text-muted mb-0">Administra los precios y presentaciones de tus ingredientes.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="<?= base_url('recetas') ?>" class="btn rounded-pill px-5 shadow-sm fw-bold text-white" style="background-color: #ee1d6dff; border:none;">
                    <i class="fa-solid fa-arrow-right-arrow-left me-2"></i>Ir a Recetas
                </a>

                <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-plus me-2"></i>Nuevo Insumo
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
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
                                    case 1:
                                        $lbl = 'gr';
                                        break;
                                    case 2:
                                        $lbl = 'Kg';
                                        break;
                                    case 3:
                                        $lbl = 'ml';
                                        break;
                                    case 4:
                                        $lbl = 'Lt';
                                        break;
                                    case 5:
                                        $lbl = 'Und';
                                        break;
                                }
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        <?= esc($ing['nombre_ingrediente']) ?>
                                    </td>

                                    <td class="text-secondary text-center">
                                        <span class="badge bg-light text-dark border">
                                            <?= floatval($ing['cantidad_paquete']) ?> <?= $lbl ?>
                                        </span>
                                    </td>

                                    <td class="fw-bold text-success text-center">
                                        $ <?= number_format($ing['costo_unidad'], 2, '.', ',') ?>
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= base_url('ingredientes/editar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-primary border-0" title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <a href="<?= base_url('ingredientes/borrar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-danger border-0 btn-eliminar" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-basket-shopping fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">No tienes insumos registrados.</p>
                                    <small>Agrega tus ingredientes para empezar a costear.</small>
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
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75),
                rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        background-repeat: no-repeat !important;
    }

    main,
    .wrapper,
    #content {
        background: transparent !important;
    }

    .dashboard-container {
        background: transparent !important;
        width: 100% !important;
        min-height: 100vh;
        padding-top: 1rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 15px;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
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

                // Confirmación para eliminar
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción y el insumo se borrará permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
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