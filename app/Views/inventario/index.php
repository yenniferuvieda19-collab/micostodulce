<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: var(--azul-logo);">Producción Activa</h2>
                <p class="text-muted small">Recetas listas para la venta en inventario</p>
            </div>
            <a href="<?= base_url('inventario/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: var(--rosa-logo); border:none;">
                <i class="fa-solid fa-plus me-2"></i>Nueva Producción
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase text-muted">
                                <th class="ps-4">Producto / Receta</th>
                                <th>Fecha Producción</th>
                                <th>Stock Disponible</th>
                                <th>Costo Inversión</th>
                                <th>PVP Sugerido</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

   <?php if (!empty($producciones)): ?>
        <?php foreach ($producciones as $p): ?>
            <tr>
                <td><?= esc($p['nombre_receta']) ?></td>

                <td><?= date('d/m/Y', strtotime($p['fecha_produccion'])) ?></td>

                <td><?= $p['cantidad_producida'] ?></td>

                <td>$<?= number_format($p['costo_total_lote'], 2) ?></td>

                <td class="fw-bold text-success">
                    $<?= number_format($p['costo_adicional_total'], 2) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">No hay registros de producción.</td>
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
    /* Mantenemos tu estética de fondo */
    body {
        background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)),
            url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important;
        background-size: cover !important;
        background-attachment: fixed !important;
    }
    main, .wrapper, #content { background: transparent !important; }
    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 15px;
    }
    .table thead th { border: none; padding: 15px 10px; }
</style>

<?= $this->endSection() ?>