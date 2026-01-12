<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container"> 
    <div class="container">

    <?php if (session()->getFlashdata('mensaje_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <?= session()->getFlashdata('mensaje_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('mensaje_exito')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>
            <?= session()->getFlashdata('mensaje_exito') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: var(--azul-logo);">Mis Insumos</h2>
            <p class="fs-5 fw-medium text-dark">Gestiona los precios de tus compras.</p>
        </div>
        <div class="d-flex gap-2"> 
            <!-- Utilicé la clase d-flex para unir ambos botones y que queden más juntos -->
            <a href="<?= base_url('recetas') ?>" class="btn rounded-pill px-5 shadow-sm fw-bold text-white" style="background-color: #ee1d6dff;border:none;">
                 <i class="fa-solid me-2"></i>Ver Mis Recetas</a> 
                 <!-- Acá agregué el botón que direcciona a las recetas. -->
            <a href="<?= base_url('ingredientes/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
                <i class="fa-solid fa-plus me-2"></i>Nuevo Insumo</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-secondary">
                            <th class="ps-4">Ingrediente</th>

                            <th class="text-center">Precio Compra</th>
                            <th class="text-center">Cantidad Compra</th>
                            <th class="text-center">Unidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ingredientes)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-basket-shopping fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p>Aún no tienes ingredientes registrados.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ingredientes as $ing): ?>

                                <?php
                                // lógica de abreviación
                                $txtUnidad = 'Und';
                                switch ($ing['Id_unidad_base']) {
                                    case 1:
                                        $txtUnidad = 'gr';
                                        break;
                                    case 2:
                                        $txtUnidad = 'kg';
                                        break;
                                    case 3:
                                        $txtUnidad = 'ml';
                                        break;
                                    case 4:
                                        $txtUnidad = 'Lt';
                                        break;
                                    case 5:
                                        $txtUnidad = 'Und';
                                        break;
                                    default:
                                        $txtUnidad = $ing['nombre_unidad'];
                                }
                                ?>

                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?= esc($ing['nombre_ingrediente']) ?></td>

                                    <td class="text-center text-success fw-bold">
                                        $ <?= number_format($ing['costo_unidad'], 2) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= (float)$ing['cantidad_paquete'] ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border text-uppercase" style="min-width: 45px;">
                                            <?= $txtUnidad ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1"> <a href="<?= base_url('ingredientes/editar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-primary border-0" title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('ingredientes/borrar/' . $ing['Id_ingrediente']) ?>"
                                                class="btn btn-sm btn-outline-danger border-0"
                                                onclick="return confirm('¿Seguro que quieres eliminar este insumo?');" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<style> /*Agregué el estilo del fondo*/
    body {background-image: linear-gradient(rgba(255, 255, 255, 0.75), 
         rgba(255, 255, 255, 0.75)), 
        url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>') !important; /*Agregué la ruta de la imagen*/
         background-size: cover !important; 
         background-position: center !important; 
         background-attachment: fixed !important; 
         background-repeat: no-repeat !important; 
        }

    main, .wrapper, #content {background: transparent !important;}

    .dashboard-container { background: transparent !important; 
        width: 100% !important; 
        min-height: 100vh; 
        padding-top: 1rem; 
        padding-bottom: 3rem; 
    }

    .card {background-color: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(8px); 
        border-radius: 15px; 
        border: none !important; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

<?= $this->endSection() ?>