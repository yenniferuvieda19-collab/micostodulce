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

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="flex-shrink-0">
                <h2 class="fw-bold mb-1 text-nowrap" style="color: var(--marron-logo);">
                    <i class="fa-solid fa-basket-shopping me-2"></i>Mis Insumos
                </h2>
                <p class="text-muted mb-0">Administra los precios y presentaciones de tus ingredientes.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end">
                <a href='<?= base_url('panel') ?>' class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border flex-fill flex-md-grow-0">
                    <i class="fa-solid fa-arrow-left me-1 me-md-2"></i>Regresar
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
                                <th class="ps-4 py-3">Nombre</th> 
                                <th class="py-3 text-center">Presentación</th>
                                <th class="py-3 text-center">Costo Unitario</th>
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

                                        <td class="text-center align-middle">
                                            <span class="fw-bold text-dark fs-6">
                                                $ <?= number_format($ing['costo_unidad'], 2, '.', ',') ?>
                                            </span>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm">
                                                <a href="<?= base_url('ingredientes/editar/' . $ing['Id_ingrediente']) ?>"
                                                    class="btn btn-sm btn-white border px-3" title="Editar">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>

                                                <button type="button" 
                                                    data-url="<?= base_url('ingredientes/borrar/' . $ing['Id_ingrediente']) ?>"
                                                    class="btn btn-sm btn-white border px-3 btn-eliminar" title="Eliminar">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="fa-solid fa-basket-shopping fa-3x mb-3 opacity-25 text-brown"></i>
                                            <p class="mb-0 fw-bold">No tienes ingredientes ni insumos.</p>
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

    .btn-white { background-color: #fff; color: #333; }
    .btn-white:hover { background-color: #f8f9fa; color: #000; }

    .text-brown { color: var(--marron-logo); }

    .btn-group .btn {
        border-radius: 8px !important;
        margin: 0 2px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        //coloco botones de eliminación
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');

        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function(e) {
                // Obtenemos la URL del atributo data-url
                const urlBorrar = this.getAttribute('data-url');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción y el ítem se borrará permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirección manual
                        window.location.href = urlBorrar;
                    }
                });
            });
        });

        // para captura automática de errores del servidor (ej: Insumo en uso)
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#3085d6',
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>