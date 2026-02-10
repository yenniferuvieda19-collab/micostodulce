<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                            <select name="id_inventario" class="form-select rounded-pill border-2" required>
                                <option value="" disabled selected>Selecciona del inventario...</option>
                                <?php foreach($productos as $p): ?>
                                    <option value="<?= $p['Id_produccion'] ?>">
                                        <?= $p['nombre_receta'] ?> (Quedan: <?= $p['cantidad_producida'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">PORCIONES VENDIDAS</label>
                                <input type="number" name="vendidas" class="form-control rounded-pill border-2" min="0" value="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">PORCIONES PERDIDAS</label>
                                <input type="number" name="perdidas" class="form-control rounded-pill border-2" min="0" value="0" required>
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
<?= $this->endSection() ?>