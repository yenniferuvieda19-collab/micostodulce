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
        min-height: 100vh;
        padding-top: 2rem;
        padding-bottom: 3rem;
        background: transparent !important;
    }

    .card-transparente {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border-radius: 20px !important;
        border: none !important;
    }

    .table {
        background: transparent !important;
    }

    .table thead th {
        background-color: rgba(0, 0, 0, 0.03) !important;
        border-bottom: 2px solid #eee !important;
    }

    .btn-white { 
        background-color: #ffffff; 
        border: none; 
        transition: 0.2s; 
    }
    
    .btn-white:hover { 
        background-color: #f8f9fa; 
        transform: translateY(-2px);
    }
</style>

<div class="dashboard-container">
    <div class="container py-2">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="flex-shrink-0">
                <h2 class="fw-bold mb-0 text-nowrap" style="color: var(--azul-logo);">
                    <i class="fa-solid fa-chart-line me-2" style="color: var(--rosa-logo);"></i>Registra tus ventas
                </h2>
                <p class="text-muted small mb-0">registro de ventas para tu control</p>
            </div>
            
            <div class="d-flex gap-2 w-100 w-md-auto justify-content-end">
                <a href="<?= base_url('panel') ?>" class="btn rounded-pill px-3 px-md-4 shadow-sm fw-bold bg-white text-dark border">
                    <i class="fa-solid fa-arrow-left me-1 me-md-2"></i>Regresar
                </a>
                <a href="<?= base_url('ventas/crear') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" style="background-color: var(--azul-logo); border:none;">
                    <i class="fa-solid fa-cart-plus me-1"></i> Registrar Venta
                </a>
            </div>
        </div>

        <div class="card card-transparente shadow-lg overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="small text-uppercase text-muted fw-bold">
                                <th class="ps-4 py-3">Postre</th>
                                <th class="py-3 text-center">Cantidad</th>
                                <th class="py-3 text-center">Precio Unitario</th>
                                <th class="py-3 text-center">Total Recibido</th>
                                <th class="py-3 text-center">Fecha</th>
                                <th class="py-3 text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ventas)): ?>
                                <?php foreach ($ventas as $v): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="logo-cupcake-container me-3" style="width: 35px; height: 35px; min-width: 35px; background-color: #fff; border: 1px solid #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                                    <i class="fa-solid fa-cake-candles" style="font-size: 0.9rem; color: var(--rosa-logo);"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block"><?= esc($v['nombre_receta']) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                                <?= esc($v['cantidad_vendida']) ?> unidades
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">
                                            $<?= number_format($v['precio_unitario'], 2) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                                $<?= number_format($v['precio_venta_total'], 2) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted">
                                                <i class="fa-regular fa-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($v['fecha_venta'])) ?>
                                            </small>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group btn-group-sm shadow-sm rounded-pill overflow-hidden border">
                                                <a href="<?= base_url('ventas/detalle/' . $v['Id_venta']) ?>" class="btn btn-white px-3" title="Ver Detalles">
                                                    <i class="fa-solid fa-eye text-primary"></i>
                                                </a>
                                                <button type="button" 
                                                    data-url="<?= base_url('ventas/eliminar/' . $v['Id_venta']) ?>" 
                                                    class="btn btn-white px-3 btn-eliminar" title="Eliminar">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-receipt d-block fs-1 mb-2 opacity-25"></i>
                                        Aún no hay registros de ventas para mostrar.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?= base_url('panel') ?>" class="btn btn-link text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-1"></i> Regresar al Inicio
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /*
     Este cambio de anyel fue mejorado, utiliza SweetAlert para confirmar antes de redirigir a la URL de borrado
     */
    document.querySelectorAll('.btn-eliminar').forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará el registro de esta venta permanentemente.",
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