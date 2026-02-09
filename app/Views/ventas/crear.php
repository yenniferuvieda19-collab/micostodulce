<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?= base_url('ventas') ?>" class="btn btn-sm btn-light border rounded-circle me-3">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0" style="color: var(--azul-logo);">Registrar Nueva Venta</h2>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <form action="<?= base_url('ventas/guardar') ?>" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Selecciona el Postre Preparado</label>
                        <select name="id_inventario" id="id_inventario" class="form-select form-select-lg border-2" required>
                            <option value="" selected disabled>Escoge una producción disponible...</option>
                            <?php foreach($producciones as $prod): ?>
                                <option value="<?= $prod['id_inventario'] ?>" 
                                        data-precio="<?= $prod['precio_venta_sug'] ?>"
                                        data-disponible="<?= $prod['porciones_disponibles'] ?>">
                                    <?= $prod['nombre_postre'] ?> - Elaborado el <?= date('d/m/Y', strtotime($prod['fecha_elaboracion'])) ?> 
                                    (Disp: <?= $prod['porciones_disponibles'] ?> und)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Solo aparecen postres que tienen stock en inventario.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Fecha de la Venta</label>
                            <input type="date" name="fecha_venta" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Unidades Vendidas</label>
                            <div class="input-group">
                                <input type="number" name="cantidad_vendida" id="cantidad_vendida" class="form-control" placeholder="0" min="1" required>
                                <span class="input-group-text bg-light">unidades</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4 border-start border-4 border-primary">
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <small class="text-muted d-block">Precio por Unidad</small>
                                <span class="fw-bold text-dark" id="display-precio">$ 0.00</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Total a Cobrar</small>
                                <span class="fw-bold text-success fs-5" id="display-total">$ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('ventas') ?>" class="btn btn-light px-4 rounded-pill">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow" style="background-color: var(--azul-logo); border:none;">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('id_inventario').addEventListener('change', calcularVenta);
document.getElementById('cantidad_vendida').addEventListener('input', calcularVenta);

function calcularVenta() {
    const select = document.getElementById('id_inventario');
    const option = select.options[select.selectedIndex];
    const cantidad = document.getElementById('cantidad_vendida').value || 0;
    
    if (option.value !== "") {
        const precio = parseFloat(option.getAttribute('data-precio'));
        const total = precio * cantidad;
        
        document.getElementById('display-precio').innerText = '$ ' + precio.toFixed(2);
        document.getElementById('display-total').innerText = '$ ' + total.toFixed(2);
    }
}
</script>
<?= $this->endSection() ?>