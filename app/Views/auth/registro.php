<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-cookie-bite fa-3x cupcake-icon"></i>
                    <h3 class="fw-bold mt-2" style="color: var(--negro-logo);">Únete a Mi Costo Dulce</h3>
                    <p class="text-muted">Comienza a organizar tus costos hoy mismo</p>
                </div>

                <form action="<?= base_url('auth/registrar') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre del Emprendimiento</label>
                        <input type="text" name="nombre_negocio" class="form-control" placeholder="Ej: Dulce Capricho" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tu correo</label>
                        <input type="email" name="email" class="form-control" placeholder="chef@reposteria.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Crea una clave segura" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                <i class="fa-regular fa-eye eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Repite tu clave" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirm">
                                <i class="fa-regular fa-eye eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                        Registrarme
                    </button>

                    <p class="text-center small">
                        ¿Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-rosa fw-bold text-decoration-none">Inicia sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionamos todos los botones que tienen la clase toggle-password
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtenemos el ID del input que este botón debe controlar
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('.eye-icon');

                // Cambiamos el tipo de input (texto o password)
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Cambiamos el icono según el estado
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>