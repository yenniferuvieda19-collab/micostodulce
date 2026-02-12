<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 15px; background-color: #f8d7da;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-exclamation fs-4 me-3 text-danger"></i>
                        <div>
                            <strong class="d-block">¡Atención!</strong>
                            <span class="small"><?= session()->getFlashdata('error') ?></span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('mensaje')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 15px; background-color: #d1e7dd;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                        <div>
                            <strong class="d-block">¡Éxito!</strong>
                            <span class="small"><?= session()->getFlashdata('mensaje') ?></span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="p-4 text-white text-center" style="background-color: var(--rosa-logo); border-radius: 20px 20px 0 0;">
                    <div class="bg-white d-inline-flex p-3 rounded-circle mb-3 shadow-sm">
                        <i class="fa-solid fa-cart-shopping fs-2" style="color: var(--rosa-logo);"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Registrar Venta / Salida</h4>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="<?= base_url('ventas/guardar') ?>" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">POSTRE DISPONIBLE</label>
                            <select name="id_inventario" id="id_inventario" class="form-select rounded-pill border-2" required onchange="calcularVenta()">
                                <option value="" disabled selected>Selecciona del inventario...</option>
                                <?php foreach($producciones as $p): ?>
                                    <option value="<?= $p['Id_produccion'] ?>" 
                                            data-precio="<?= $p['costo_unitario'] ?>">
                                        <?= $p['nombre_receta'] ?> (Quedan: <?= $p['cantidad_producida'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">PORCIONES VENDIDAS</label>
                                <input type="number" name="vendidas" id="vendidas" class="form-control rounded-pill border-2" min="1" value="<?= old('vendidas') ?? 0 ?>" required oninput="calcularVenta()">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">PRECIO UNITARIO ($)</label>
                                <input type="number" name="precio_unitario" id="precio_unitario" class="form-control rounded-pill border-2" step="0.01" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small text-muted">TOTAL DE VENTA ($)</label>
                                <input type="text" name="precio_total" id="precio_total" class="form-control rounded-pill border-2 bg-light fw-bold text-primary" readonly value="0.00">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm" style="background-color: var(--rosa-logo); border:none;">
                                <i class="fa-solid fa-check me-1"></i> Guardar Registro
                            </button>
                            <a href="<?= base_url('ventas') ?>" class="btn btn-light rounded-pill py-2">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calcularVenta() {
    const select = document.getElementById('id_inventario');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption || selectedOption.disabled) return;

    const precioUnitario = selectedOption.getAttribute('data-precio') || 0;
    const cantidad = document.getElementById('vendidas').value || 0;

    document.getElementById('precio_unitario').value = parseFloat(precioUnitario).toFixed(2);

    const total = parseFloat(precioUnitario) * parseInt(cantidad);
    document.getElementById('precio_total').value = total.toFixed(2);
}

// Ejecutar cálculo al cargar por si hay datos previos (old input)
document.addEventListener('DOMContentLoaded', calcularVenta);
</script>

<?= $this->endSection() ?>