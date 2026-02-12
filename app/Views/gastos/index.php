<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container px-3 px-md-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div class="flex-shrink-0">
        <h2 class="fw-bold mb-1 text-nowrap" style="color: var(--marron-logo);">
            <i class="fa-solid fa-file-invoice-dollar me-2" style="color: var(--rosa-logo);"></i>Mis Costos Indirectos
        </h2>
        <p class="text-muted mb-0">Gestiona traslado, servicios y mano de obra.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end align-items-center">
        <a href="<?= base_url('panel') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border flex-fill flex-md-grow-0">
            <i class="fa-solid fa-arrow-left me-1 me-md-2"></i>Regresar
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
                                        <td class="ps-4 fw-bold text-dark align-middle">
                                            <?= esc($gasto['nombre_gasto']) ?>
                                        </td>

                                        <td class="text-center align-middle">
                                            <?php
                                            $nombre = mb_strtolower($gasto['nombre_gasto']);
                                            
                                            // Valor por defecto
                                            $textoBadge = !empty($gasto['categoria']) ? $gasto['categoria'] : 'General';
                                            $badgeClass = 'bg-secondary'; 
                                            $icono = 'fa-tag';

                                            // LÓGICA DE COLORES E ICONOS
                                            if (strpos($nombre, 'delivery') !== false || strpos($nombre, 'envio') !== false || strpos($nombre, 'transporte') !== false) {
                                                $textoBadge = 'Delivery';
                                                $badgeClass = 'bg-primary'; // Azul
                                                $icono = 'fa-motorcycle';
                                            }
                                            elseif (strpos($nombre, 'mano') !== false || strpos($nombre, 'obra') !== false || strpos($nombre, 'luz') !== false || strpos($nombre, 'gas') !== false || strpos($nombre, 'servicio') !== false) {
                                                $textoBadge = 'Servicios Basicos'; // Amarillo
                                                $badgeClass = 'bg-warning text-dark'; 
                                                $icono = 'fa-bolt';
                                            }
                                            elseif (strpos($nombre, 'empaque') !== false || strpos($nombre, 'caja') !== false) {
                                                $textoBadge = 'Empaques'; // Celeste
                                                $badgeClass = 'bg-info text-dark'; 
                                                $icono = 'fa-box-open';
                                            }
                                            ?>
                                            
                                            <span class="badge <?= $badgeClass ?> border px-3 py-2 rounded-pill fw-bold shadow-sm" style="min-width: 140px; font-size: 0.85rem;">
                                                <i class="fa-solid <?= $icono ?> me-1"></i> 
                                                <?= esc($textoBadge) ?>
                                            </span>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="fw-bold text-dark fs-6">
                                                <?php if ($gasto['es_fijo'] == 1): ?>
                                                    $ <?= number_format($gasto['precio_unitario'], 2, '.', ',') ?>
                                                <?php else: ?>
                                                    <?= number_format($gasto['precio_unitario'], 2, '.', ',') ?> %
                                                <?php endif; ?>
                                            </span>
                                        </td>

                                        <td class="text-end pe-4 align-middle">
                                            <div class="btn-group shadow-sm">
                                                <a href="<?= base_url('gastos/editar/' . $gasto['Id_gasto']) ?>"
                                                    class="btn btn-sm btn-white border" title="Editar">
                                                    <i class="fa-solid fa-pen text-primary"></i>
                                                </a>
                                                <a href="<?= base_url('gastos/borrar/' . $gasto['Id_gasto']) ?>"
                                                    class="btn btn-sm btn-white border btn-eliminar" title="Eliminar">
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
                                            <i class="fa-solid fa-hand-holding-dollar fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">No tienes gastos indirectos registrados.</p>
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
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover; background-attachment: fixed;
    }
    .dashboard-container { min-height: 100vh; padding-top: 1.5rem; padding-bottom: 3rem; }
    .card { background-color: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(8px); border-radius: 15px; }
    .btn-white { background-color: #fff; color: #333; }
    .btn-white:hover { background-color: #f8f9fa; color: #000; }
    
    /* Forzamos el grosor extra en los badges */
    .badge {
        font-weight: 700 !important; /* Letra bien gruesa */
        letter-spacing: 0.5px;
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