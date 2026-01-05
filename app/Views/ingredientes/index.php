<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color: var(--marron-logo);">Mis Insumos</h2>
    <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill">
        <i class="fa-solid fa-plus me-2"></i>Nuevo Ingrediente
    </a>
</div>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success border-0 shadow-sm">
        <?= session()->getFlashdata('mensaje') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: var(--azul-logo); color: var(--marron-logo);">
                <tr>
                    <th class="ps-4">Ingrediente</th>
                    <th>Cantidad Pack</th>
                    <th>Precio Compra</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ingredientes) && is_array($ingredientes)): ?>
                    <?php foreach ($ingredientes as $insumo): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">
                                <?= esc($insumo['nombre_ingrediente']) ?>
                            </td>
                            
                            <td>
                                <?php 
                                    $cant = $insumo['cantidad_paquete'];
                                    $tipo = $insumo['Id_unidad_base'];
                                    
                                    switch ($tipo) {
                                        case 2: // Kg
                                            echo ($cant / 1000) . ' Kg';
                                            break;
                                        case 4: // Litros
                                            echo ($cant / 1000) . ' L';
                                            break;
                                        case 3: // ml
                                            echo $cant . ' ml';
                                            break;
                                        case 5: // Unidades
                                            echo $cant . ' Und';
                                            break;
                                        default: // Gramos (1)
                                            echo $cant . ' gr';
                                            break;
                                    }
                                ?>
                            </td>
                            
                            <td>$ <?= number_format($insumo['precio_compra'], 2) ?></td>
                            
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-outline-secondary border-0"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No hay insumos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>