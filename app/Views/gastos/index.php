<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container px-3 px-md-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--marron-logo);">Mis Costos Indirectos</h2>
                <p class="text-muted mb-0">Gestiona empaques, servicios y mano de obra.</p>
            </div>
            
            <div class="d-flex flex-wrap gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end">
                <a href="<?= base_url('recetas') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold text-white flex-fill flex-md-grow-0" style="background-color: #ee1d6dff; border:none;">
                    <i class="fa-solid fa-book-open me-1 me-md-2"></i>Recetas
                </a>

                <a href="<?= base_url('ingredientes') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border flex-fill flex-md-grow-0">
                    <i class="fa-solid fa-basket-shopping me-1 me-md-2 text-success"></i>Insumos
                </a>

                <a href="<?= base_url('gastos/crear') ?>" class="btn btn-primary rounded-pill px-3 px-md-4 shadow-sm fw-bold flex-fill flex-md-grow-0" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-plus me-1 me-md-2"></i>Nuevo Gasto
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
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
                                            <span class="badge <?= $badgeClass ?> border bg-opacity-75 px-3 rounded-pill">
                                                <i class="fa-solid <?= $icono ?> me-1"></i> <?= esc($gasto['categoria']) ?>
                                            </span>
                                        </td>

                                        <td class="fw-bold text-success text-center">
                                            $ <?= number_format($gasto['precio_unitario'], 2, '.', ',') ?>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm">
                                                <a href="<?= base_url('gastos/editar/' . $gasto['Id_gasto']) ?>"
                                                    class="btn btn-sm btn-white border"
                                                    title="Editar">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>

                                                <a href="<?= base_url('gastos/borrar/' . $gasto['Id_gasto']) ?>"
                                                    class="btn btn-sm btn-white border btn-eliminar"
                                                    title="Eliminar">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">No tienes gastos registrados.</p>
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
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover;
        background-attachment: fixed;
    }

    .dashboard-container {
        min-height: 100vh;
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 15px;
    }

    .btn-white { background-color: #fff; }
    .btn-white:hover { background-color: #f8f9fa; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Tu script de eliminar se mantiene igual
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