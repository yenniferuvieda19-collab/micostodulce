<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

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
        padding-top: 1rem;
        padding-bottom: 3rem;
    }

    .glass-card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(8px);
        border-radius: 20px;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<div class="dashboard-container">
    <div class="container">

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 15px; background-color: #d1f7ec; color: #0f5132;">
                <i class="fa-solid fa-circle-check me-2"></i>
                <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 15px; background-color: #f8d7da; color: #842029;">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="flex-shrink-0">
                <h2 class="fw-bold mb-0 text-nowrap" style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #825a42;">
                    <i class="fa-solid fa-dolly me-2"></i>Producción Activa
                </h2>
            </div>

            <div class="d-flex flex-wrap gap-2 w-100 w-md-auto ms-md-auto justify-content-md-end">
                <a href="<?= base_url('panel') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border flex-fill flex-md-grow-0">
                    <i class="fa-solid fa-arrow-left me-1 me-md-2"></i>Regresar
                </a>
                
                <a href="<?= base_url('inventario/crear') ?>" class="btn rounded-pill px-4 shadow-sm fw-bold text-white flex-fill flex-md-grow-0" 
                   style="background-color: #825a42; border: none;">
                    <i class="fa-solid fa-plus me-1 me-md-2"></i>Nueva Producción
                </a>
            </div>
        </div>

        <div class="glass-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr style="font-size: 0.85rem; color: #666; text-transform: uppercase;">
                            <th class="px-4 py-3">PRODUCTO / RECETA</th>
                            <th class="py-3">FECHA PRODUCCIÓN</th>
                            <th class="py-3">STOCK DISPONIBLE</th>
                            <th class="py-3">GANANCIA TOTAL</th>
                            <th class="py-3">COSTO UNITARIO</th>
                            <th class="py-3 text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9rem;">
                        <?php if(!empty($producciones) && is_array($producciones)): ?>
                            <?php foreach ($producciones as $p): ?>
                            <tr>
                                <td class="px-4 py-3">
                                    <i class="fa-solid fa-cake-candles me-2" style="color: #f26185;"></i> 
                                    <span class="fw-bold"><?= esc($p['nombre_postre'] ?? $p['nombre_receta'] ?? 'Producto') ?></span>
                                </td>
                                <td class="py-3"><?= date('d/m/Y', strtotime($p['fecha_produccion'])) ?></td>
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3" style="background-color: rgba(22, 194, 232, 0.1); color: #16c2e8; border: 1px solid #16c2e8;">
                                        <?= $p['cantidad_producida'] ?? $p['stock_disponible'] ?? '0' ?> uds
                                    </span>
                                </td>
                                <td class="py-3 text-success fw-bold">$ <?= number_format($p['costo_adicional_total'] ?? $p['pvp_sugerido'] ?? 0, 2) ?></td>
                                <td class="py-3 fw-bold text-muted">$ <?= number_format($p['costo_unitario'] ?? 0, 2) ?></td>
                                
                                <td class="py-3">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <?php $id_limpio = $p['Id_produccion'] ?? $p['id'] ?? null; ?>

                                        <?php if ($id_limpio): ?>
                                            <a href="<?= base_url('inventario/ver/' . $id_limpio) ?>" 
                                               class="btn btn-sm rounded-pill px-3 fw-bold" 
                                               style="background-color: rgba(22, 194, 232, 0.1); color: #16c2e8; border: 1px solid #16c2e8; transition: all 0.2s;" 
                                               title="Ver detalle">
                                                <i class="fa-solid fa-eye me-1"></i> Ver
                                            </a>

                                            <a href="<?= base_url('inventario/eliminar/' . $id_limpio) ?>" 
                                               class="btn btn-sm rounded-pill px-3 fw-bold" 
                                               style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; transition: all 0.2s;" 
                                               onclick="return confirm('¿Estás seguro de que deseas eliminar este registro de producción?')"
                                               title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Sin ID</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open d-block fs-1 mb-2 opacity-25"></i>
                                    No hay producciones activas registradas.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3 px-2 text-muted">
            <small style="font-family: 'Quicksand', sans-serif;">Recetas listas para la venta en inventario</small>
        </div>
    </div>
</div>

<?= $this->endSection() ?>