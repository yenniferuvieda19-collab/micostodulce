<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: var(--rosa-logo);">Editar Receta: <?= $receta['nombre'] ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('recetas/actualizar/' . $receta['id']) ?>" method="POST">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold small">Nombre de la preparación</label>
                            <input type="text" name="nombre" class="form-control" value="<?= $receta['nombre'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Porciones finales</label>
                            <input type="number" name="porciones" class="form-control" value="<?= $receta['porciones'] ?>" required>
                        </div>
                    </div>

                    <div class="p-4 rounded border-pink mb-3" style="background-color: #fffafb;">
                        <h6 class="fw-bold mb-3" style="color: var(--marron-logo);">Ingredientes actuales</h6>
                        <p class="text-muted small italic">Puedes quitar o agregar nuevos insumos para ajustar el costo.</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('recetas') ?>" class="btn btn-light">Cancelar cambios</a>
                        <button type="submit" class="btn btn-primary px-4">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>