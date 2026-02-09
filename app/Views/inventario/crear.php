<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h3 class="fw-bold mb-4" style="color: var(--azul-logo);">
                    <i class="fa-solid fa-plus-circle me-2"></i>Nueva Producción
                </h3>
                
                <form action="<?= base_url('inventario/guardar') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Selecciona la Receta</label>
                        <select name="id_receta" class="form-select" required>
                            <option value="" selected disabled>-- Selecciona una de tus recetas creadas --</option>

                            <?php if (!empty($recetas)): ?>
                            <?php foreach($recetas as $receta): ?>
                                <option value="<?= $receta['Id_receta'] ?>">
                                    <?= esc($receta['nombre_postre']) ?>
                                </option>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No tienes recetas registradas aún</option>
                                <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cantidad Producida (Porciones)</label>
                        <input type="number" name="cantidad" class="form-control" placeholder="Ej: 12" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Producción</label>
                        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill" style="background-color: var(--rosa-logo); border:none;">
                            Guardar en Inventario
                        </button>
                        <a href="<?= base_url('inventario') ?>" class="btn btn-light rounded-pill">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>