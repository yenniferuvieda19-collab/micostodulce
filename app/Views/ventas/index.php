<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: var(--azul-logo);">📊 Resumen de Ventas y Rendimiento</h2>
            <p class="text-muted">Control de porciones, ganancias y reinversión.</p>
        </div>
        <a href="<?= base_url('ventas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: var(--azul-logo); border: none;">
            <i class="fa-solid fa-plus me-2"></i>Registrar Venta
        </a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr class="small text-uppercase text-muted">
                            <th class="ps-4 text-start">Postre / Elaboración</th>
                            <th>Preparado</th>
                            <th>Total Porciones</th>
                            <th>Vendidas</th>
                            <th>Perdidas</th>
                            <th>Ganancia Total</th>
                            <th>Pérdida ($)</th>
                            <th>Reinversión</th>
                            <th class="pe-4 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($resumen)): ?>
                            <?php foreach($resumen as $item): ?>
                                <tr>
                                    <td class="ps-4 text-start">
                                        <span class="fw-bold d-block"><?= esc($item['nombre_postre']) ?></span>
                                        <small class="text-muted">
                                            <i class="fa-regular fa-calendar me-1"></i><?= date('d M Y', strtotime($item['fecha_elaboracion'])) ?>
                                        </small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?= esc($item['cantidad_preparada']) ?> moldes</span></td>
                                    <td><span class="fw-bold"><?= esc($item['porciones_totales']) ?></span> <small>und</small></td>
                                    <td class="text-success fw-bold"><?= esc($item['vendidas']) ?></td>
                                    <td class="text-danger fw-bold"><?= esc($item['perdidas']) ?></td>
                                    <td class="fw-bold text-success">$ <?= number_format($item['ganancia_total'], 2) ?></td>
                                    <td class="text-danger">$ <?= number_format($item['dinero_perdido'], 2) ?></td>
                                    <td class="text-primary fw-bold">$ <?= number_format($item['costo_reinversion'], 2) ?></td>
                                    <td class="pe-4 text-end">
                                        <a href="<?= base_url('ventas/detalle/' . $item['id_inventario']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm border-2">
                                            <i class="fa-solid fa-eye me-1"></i> Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="py-5 text-muted">
                                    <div class="text-center">
                                        <i class="fa-solid fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">Aún no hay datos de producción vs ventas para mostrar.</p>
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

<style>
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px 10px;
    }
    .table tbody td {
        padding: 18px 10px;
        font-size: 0.95rem;
    }
    .text-success { color: #28a745 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-primary { color: var(--azul-logo) !important; }

    /* Estilo para el botón de detalles */
    .btn-outline-primary {
        border-color: var(--azul-logo);
        color: var(--azul-logo);
    }
    .btn-outline-primary:hover {
        background-color: var(--azul-logo);
        border-color: var(--azul-logo);
        color: white;
    }
</style>
<?= $this->endSection() ?>