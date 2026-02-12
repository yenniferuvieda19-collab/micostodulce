<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-center" style="color: var(--azul-logo);">Editar Gasto Indirecto</h3>
                    
                    <form action="<?= base_url('gastos/actualizar/'.$gasto['Id_gasto']) ?>" method="post">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nombre del gasto</label>
                            <input type="text" class="form-control form-control-lg" name="nombre_gasto" 
                                   value="<?= esc($gasto['nombre_gasto']) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Categoría</label>
                            <select class="form-select form-select-lg" name="categoria" required>
                                <option value="Delivery" <?= ($gasto['categoria'] == 'Delivery') ? 'selected' : '' ?>>Delivery</option>
                                
                                <option value="Servicios Basicos" <?= ($gasto['categoria'] == 'Servicios Basicos') ? 'selected' : '' ?>>Mano de Obra</option>
                                
                                <option value="Otro" <?= ($gasto['categoria'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="form-check form-switch mb-4 p-3 rounded bg-light border d-flex align-items-center">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" 
                                   id="switchTipoGasto" name="es_fijo" value="1" 
                                   <?= ($gasto['es_fijo'] == 1) ? 'checked' : '' ?> 
                                   style="transform: scale(1.3);">
                            
                            <label class="form-check-label fw-bold cursor-pointer" for="switchTipoGasto">
                                Actívalo si el gasto indirecto tiene costo fijo
                                <small class="d-block text-muted fw-normal mt-1">
                                    Ejemplo: Delivery = $3.00
                                </small>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" id="labelValor">Valor</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text fw-bold" id="simboloValor">
                                    <?= ($gasto['es_fijo'] == 1) ? '$' : '%' ?>
                                </span>
                                
                                <input type="number" step="0.01" class="form-control" 
                                       name="valor_gasto" id="inputValor" 
                                       value="<?= esc($gasto['precio_unitario']) ?>" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill" style="background-color: var(--azul-logo); border:none;">
                                ACTUALIZAR GASTO
                            </button>
                            <a href="<?= base_url('gastos') ?>" class="btn btn-light text-muted">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const switchGasto = document.getElementById('switchTipoGasto');
        const labelValor = document.getElementById('labelValor');
        const simboloValor = document.getElementById('simboloValor');

        function actualizarFormulario() {
            if (switchGasto.checked) {
                // MODO: Costo Fijo ($)
                labelValor.textContent = "Costo Fijo ($)";
                simboloValor.textContent = "$";
                simboloValor.className = "input-group-text bg-success text-white fw-bold";
            } else {
                // MODO: Porcentaje (%)
                labelValor.textContent = "Porcentaje (%)";
                simboloValor.textContent = "%";
                simboloValor.className = "input-group-text bg-primary text-white fw-bold";
            }
        }
        
        switchGasto.addEventListener('change', actualizarFormulario);
        actualizarFormulario();
    });
</script>
<?= $this->endSection() ?>