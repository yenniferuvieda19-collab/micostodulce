<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <i class="fa-solid fa-cake-candles fa-3x mb-3 cupcake-icon"></i>
                <h3 class="fw-bold mb-4" style="color: var(--negro-logo);">¡Hola de nuevo!</h3>
                
                <form action="<?= base_url('auth/ingresar') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Correo electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="tu@correo.com" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Tu clave" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                        Entrar a mi cocina
                    </button>
                    
                    <div class="d-flex justify-content-between small">
                        <a href="<?= base_url('recuperar') ?>" class="text-muted text-decoration-none">¿Olvidaste la clave?</a>
                        <a href="<?= base_url('registro') ?>" class="text-rosa text-decoration-none fw-bold">Crear cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.querySelector('.toggle-password');
    
    if (btnToggle) {
        btnToggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input) {
                // Cambiamos el tipo de input de password a text y viceversa
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                
                // Cambiamos el icono correctamente
                if (isPassword) {
                    // Mostrar clave: cambiamos a ojo con barra
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    // Ocultar clave: volvemos al ojo normal
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>