<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold" style="color: var(--marron-logo);">Mis Costos Indirectos</h2>
                <p class="text-muted mb-0">Gestiona empaques, servicios y mano de obra.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('recetas') ?>" class="btn rounded-pill px-4 shadow-sm fw-bold text-white" style="background-color: #ee1d6dff; border:none;">
                    <i class="fa-solid fa-arrow-right-arrow-left me-2"></i>Volver a Recetas
                </a>
                <a href="<?= base_url('gastos/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-plus me-2"></i>Nuevo Gasto
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Concepto</th>
                            <th class="py-3 text-center">Categoría</th>
                            <th class="py-3 text-center">Costo Unitario</th>
                            <th class="text-end pe-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($gastos)): ?>
                            <?php foreach ($gastos as $gasto): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        <?= esc($gasto['nombre_gasto']) ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        // Asignar colores según categoría
                                        $badgeClass = 'bg-secondary';
                                        $icono = 'fa-tag';

                                        if ($gasto['categoria'] == 'Empaque') {
                                            $badgeClass = 'bg-info text-dark';
                                            $icono = 'fa-box-open';
                                        }
                                        if ($gasto['categoria'] == 'Servicio') {
                                            $badgeClass = 'bg-warning text-dark';
                                            $icono = 'fa-bolt';
                                        }
                                        if ($gasto['categoria'] == 'Mano de Obra') {
                                            $badgeClass = 'bg-success';
                                            $icono = 'fa-hands-holding-circle';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> border bg-opacity-75">
                                            <i class="fa-solid <?= $icono ?> me-1"></i> <?= esc($gasto['categoria']) ?>
                                        </span>
                                    </td>

                                    <td class="fw-bold text-success text-center">
                                        $ <?= number_format($gasto['precio_unitario'], 2, '.', ',') ?>
                                    </td>

                                    <td class="text-end pe-4">
                                        <a href="<?= base_url('gastos/borrar/' . $gasto['Id_gasto']) ?>"
                                            class="btn btn-sm btn-outline-danger border-0 btn-eliminar"
                                            title="Eliminar">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">No tienes gastos registrados.</p>
                                    <small>Agrega tus cajas, bases o costo de servicios.</small>
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
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)),
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
                    title: '¿Eliminar este gasto?',
                    text: "No podrás deshacer esta acción.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
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