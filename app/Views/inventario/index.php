<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" style="border-radius: 15px; background-color: #d1f7ec; color: #0f5132;">
        <i class="fa-solid fa-circle-check me-2"></i>
        <?= session()->getFlashdata('mensaje') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert" style="border-radius: 15px; background-color: #f8d7da; color: #842029;">
        <i class="fa-solid fa-circle-exclamation me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #825a42;">
        Producción Activa
    </h2>
    <a href="<?= base_url('inventario/crear') ?>" class="btn rounded-pill px-4 shadow-sm" 
       style="background-color: #825a42; color: white;">
        + Nueva Producción
    </a>
</div>

<div class="glass-card p-0 overflow-hidden" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr style="font-size: 0.85rem; color: #666; text-transform: uppercase;">
                    <th class="px-4 py-3">PRODUCTO / RECETA</th>
                    <th class="py-3">FECHA PRODUCCIÓN</th>
                    <th class="py-3">STOCK DISPONIBLE</th>
                    <th class="py-3">COSTO INVERSIÓN</th>
                    <th class="py-3">PVP SUGERIDO</th>
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
                        <td class="py-3">$ <?= number_format($p['costo_total_lote'] ?? $p['costo_inversion'] ?? 0, 2) ?></td>
                        <td class="py-3 text-success fw-bold">$ <?= number_format($p['costo_adicional_total'] ?? $p['pvp_sugerido'] ?? 0, 2) ?></td>
                        
                        <td class="py-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <?php 
                                    // Usamos el ID exacto de tu tabla SQL: Id_produccion
                                    $id_limpio = $p['Id_produccion'] ?? $p['id'] ?? null; 
                                ?>

                                <?php if ($id_limpio): ?>
                                    <a href="<?= base_url('inventario/ver/' . $id_limpio) ?>" class="mx-2" style="color: #16c2e8; font-size: 1.1rem; transition: transform 0.2s;" title="Ver detalle" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <button onclick="confirmarEliminacion(<?= $id_limpio ?>, '<?= base_url('inventario/eliminar') ?>')" 
                                            class="mx-2" style="color: #dc3545; border: none; background: none; cursor: pointer; padding: 0; font-size: 1.1rem; transition: transform 0.2s;" title="Eliminar" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
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

<div class="mt-2 px-2 text-muted">
    <small style="font-family: 'Quicksand', sans-serif;">Recetas listas para la venta en inventario</small>
</div>

<?= $this->endSection() ?>