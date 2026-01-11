<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="dashboard-container"> 
    <div class="container">
    <h3>Editar Insumo</h3>
    <div class="card shadow-sm p-4">
        <form action="<?= base_url('ingredientes/actualizar/' . $ingrediente['Id_ingrediente']) ?>" method="post">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre"
                    value="<?= esc($ingrediente['nombre_ingrediente']) ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="precio" class="form-label fw-bold">Costo de Compra ($)</label>
                    <input type="number" step="0.01" class="form-control" name="precio" id="precio"
                        value="<?= (float)$ingrediente['costo_unidad'] ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cantidad" class="form-label fw-bold">Cantidad del Paquete</label>
                    <input type="number" step="0.01" class="form-control" name="cantidad" id="cantidad"
                        value="<?= (float)$ingrediente['cantidad_paquete'] ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Unidad</label>
                <select class="form-select" name="unidad_id">
                    <?php foreach ($unidades as $u): ?>
                        <option value="<?= $u['Id_unidad'] ?>"
                            <?= ($u['Id_unidad'] == $ingrediente['Id_unidad_base']) ? 'selected' : '' ?>>
                            <?= esc($u['nombre_unidad']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="<?= base_url('ingredientes') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    </div>
</div>

<style>/*Agregué el estilo del fondo*/
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
</style>
<?= $this->endSection() ?>