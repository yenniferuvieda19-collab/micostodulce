<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--azul-logo);">
                <i class="fa-solid fa-chart-line me-2" style="color: var(--rosa-logo);"></i>Resumen de Ventas y Rendimiento
            </h2>
            <p class="text-muted small">Control de porciones, ganancias y reinversión.</p>
        </div>
        <a href="<?= base_url('ventas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: var(--azul-logo); border:none;">
            <i class="fa-solid fa-cart-plus me-1"></i> Registrar Venta
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="small text-uppercase text-muted fw-bold">
                            <th class="ps-4 py-3">Postre / Elaboración</th>
                            <th class="py-3 text-center">Preparado</th>
                            <th class="py-3 text-center">Total Porciones</th>
                            <th class="py-3 text-center">Vendidas</th>
                            <th class="py-3 text-center">Perdidas</th>
                            <th class="py-3 text-end">Ganancia Total</th>
                            <th class="py-3 text-end">Pérdida ($)</th>
                            <th class="py-3 text-end">Reinversión</th>
                            <th class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($resumen)): ?>
                            <?php foreach ($resumen as $item): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="logo-cupcake-container me-3" style="width: 35px; height: 35px; min-width: 35px; background-color: #f8f9fa; border: 1px solid #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-cake-candles" style="font-size: 0.9rem; color: var(--rosa-logo);"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block"><?= esc($item['nombre_postre']) ?></span>
                                                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i><?= date('d M Y', strtotime($item['fecha_elaboracion'])) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2"><?= esc($item['cantidad_preparada']) ?> moldes</span>
                                    </td>
                                    <td class="text-center fw-bold"><?= esc($item['porciones_totales']) ?> <small class="text-muted">und</small></td>
                                    <td class="text-center"><span class="badge rounded-pill bg-success px-3"><?= esc($item['vendidas']) ?></span></td>
                                    <td class="text-center text-danger fw-bold"><?= esc($item['perdidas']) ?></td>
                                    <td class="text-end fw-bold text-success">$<?= number_format($item['ganancia_total'], 2) ?></td>
                                    <td class="text-end text-danger fw-bold">$<?= number_format($item['dinero_perdido'], 2) ?></td>
                                    <td class="text-end text-primary fw-bold">$<?= number_format($item['costo_reinversion'], 2) ?></td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group btn-group-sm shadow-sm rounded-pill overflow-hidden border">
                                            <a href="<?= base_url('ventas/detalle/' . $item['id_inventario']) ?>" class="btn btn-white px-3" title="Ver Detalles">
                                                <i class="fa-solid fa-eye text-primary"></i>
                                            </a>
                                            <button type="button" 
                                                data-url="<?= base_url('ventas/eliminar/' . $item['id_inventario']) ?>" 
                                                class="btn btn-white px-3 btn-eliminar" title="Eliminar">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-receipt d-block fs-1 mb-2 opacity-25"></i>
                                    Aún no hay datos de producción vs ventas para mostrar.
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
    .btn-white { background-color: #ffffff; border: none; transition: 0.2s; }
    .btn-white:hover { background-color: #f8f9fa; }
    .text-primary { color: var(--azul-logo) !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('.btn-eliminar').forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará el registro de este rendimiento permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>