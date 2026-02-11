<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #825a42;">
        <i class="fa-solid fa-mortar-pestle me-2" style="color: #f26185;"></i> Nueva Producción
    </h2>
    
    <a href="<?= base_url('inventario') ?>" class="btn rounded-pill px-4 shadow-sm" 
       style="border: 2px solid #ccc; color: #666; font-weight: 600; background: white; transition: all 0.3s ease;">
        Cancelar
    </a>
</div>

<div class="glass-card" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 30px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
    <form action="<?= base_url('inventario/guardar') ?>" method="POST">
        <div class="row g-3 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-bold" style="color: #444;">¿Qué vas a producir hoy?</label>
                <select name="id_receta" id="select_receta" class="form-select" style="border-radius: 12px; border: 1px solid #ddd; padding: 12px;" required>
                    <option value="">Selecciona una receta...</option>
                    <?php if (!empty($recetas)): ?>
                        <?php foreach ($recetas as $receta): ?>
                            <option
                                value="<?= $receta['Id_receta'] ?>"
                                data-porciones="<?= $receta['porciones'] ?>"
                                 value="<?= $receta['Id_usuario'] ?>"
                            >
                                <?= esc($receta['nombre_postre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No tienes recetas guardadas aún</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-bold" style="color: #444;">Cantidad de Porciones / Unidades</label>
                <div class="input-group">
                    <input type="number" name="stock_disponible" id="stock_input" class="form-control" style="border-radius: 12px 0 0 12px; border: 1px solid #ddd; padding: 12px;" placeholder="Ej: 8" required>
                    <span class="input-group-text bg-white" style="border-radius: 0 12px 12px 0; border: 1px solid #ddd; color: #888;">uds</span>
                </div>
            </div>
        </div>

        <div class="mt-4 p-3 rounded-3" style="background-color: rgba(22, 194, 232, 0.08); border: 1px solid #16c2e8;">
            <small style="color: #0d6efd; font-weight: 500;">
                <i class="fa-solid fa-circle-info me-2"></i> 
                Nota: Al registrar, se sumará al inventario y se guardará el costo actual de la receta.
            </small>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-lg w-100 shadow-sm text-uppercase py-3" 
                    style="background-color: #16c2e8; color: white; border-radius: 15px; font-weight: 700; border: none; letter-spacing: 1px; transition: transform 0.2s;">
                <i class="fa-solid fa-circle-check me-2"></i> REGISTRAR EN PRODUCCIÓN ACTIVA
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selector = document.getElementById('select_receta');
    const inputStock = document.getElementById('stock_input');

    selector.addEventListener('change', function() {
        // Obtenemos la opción seleccionada
        const selectedOption = this.options[this.selectedIndex];
        
        // Obtenemos el valor del atributo data-porciones
        const porcionesBase = selectedOption.getAttribute('data-porciones');

        if (porcionesBase) {
            // Lo ponemos en el input automáticamente
            inputStock.value = porcionesBase;
            
            // Un pequeño efecto visual de "parpadeo" para avisar que cambió
            inputStock.style.transition = "background-color 0.3s";
            inputStock.style.backgroundColor = "#e8faff";
            setTimeout(() => {
                inputStock.style.backgroundColor = "white";
            }, 500);
        }
    });
});
</script>

<?= $this->endSection() ?>