<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
    /* Mejoré acá el fondo para que se vea mejor y menos ruidoso */
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
    }
    
    .card-header-custom {
        background-color: var(--rosa-logo) !important;
        border-radius: 20px 20px 0 0 !important;
    }

    /* Estilo adicional para centrar texto en inputs */
    .input-centrado {
        text-align: center;
    }
</style>

<div class="dashboard-container">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 15px; background-color: #f8d7da;">
                        <i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card card-transparente border-0 shadow-lg">
                    <div class="p-4 text-white text-center card-header-custom">
                        <div class="bg-white d-inline-flex p-3 rounded-circle mb-3 shadow-sm">
                            <i class="fa-solid fa-cart-shopping fs-2" style="color: var(--rosa-logo);"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Registrar Venta / Salida</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="<?= base_url('ventas/guardar') ?>" method="POST">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted">POSTRE DISPONIBLE</label>
                                <select name="id_inventario" id="id_inventario" class="form-select rounded-pill border-2 text-center" required onchange="calcularVenta()">
                                    <option value="" disabled selected>Selecciona del inventario...</option>
                                    <?php foreach($producciones as $p): ?>
                                        <option value="<?= $p['Id_produccion'] ?>" 
                                                data-precio="<?= $p['costo_unitario'] ?>">
                                            <?= $p['nombre_receta'] ?> (Stock: <?= $p['cantidad_producida'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-8 text-center">
                                    <label class="form-label fw-bold small text-muted">PORCIONES VENDIDAS</label>
                                    <input type="number" name="vendidas" id="vendidas" class="form-control rounded-pill border-2 input-centrado" min="0" value="<?= old('vendidas') ?? 0 ?>" required oninput="calcularVenta()">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-center d-block">PRECIO UNITARIO ($)</label>
                                    <input type="number" name="precio_unitario" id="precio_unitario" class="form-control rounded-pill border-2 bg-light input-centrado" step="0.01" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted text-center d-block">TOTAL VENTA ($)</label>
                                    <input type="text" name="precio_total" id="precio_total" class="form-control rounded-pill border-2 bg-light fw-bold text-primary input-centrado" readonly value="0.00">
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm" style="background-color: var(--rosa-logo); border:none;">
                                    <i class="fa-solid fa-check me-1"></i> Guardar Registro
                                </button>
                                <div class="text-center">
                                    <a href="<?= base_url('ventas') ?>" class="btn btn-link text-muted text-decoration-none small">Cancelar y regresar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/*Script para calcular automáticamente el total de la ventabasándose en el precio unitario del postre seleccionado.*/
function calcularVenta() {
    const select = document.getElementById('id_inventario');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption || selectedOption.disabled) return;

    // obtengo el precio del atributo data-precio que viene del inventario
    const precioUnitario = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
    const cantidad = parseInt(document.getElementById('vendidas').value) || 0;

    // aquí se mnuestra el precio unitario en el campo correspondiente
    document.getElementById('precio_unitario').value = precioUnitario.toFixed(2);

    // muchachos, esto es para el calculo y mostrar el total recibido por las porciones vendidas
    const total = precioUnitario * cantidad;
    document.getElementById('precio_total').value = total.toFixed(2);
}

// Ejecutar cálculo al cargar por si hay datos previos (old input o edición)
document.addEventListener('DOMContentLoaded', calcularVenta);
</script>

<?= $this->endSection() ?>