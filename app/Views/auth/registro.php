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
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleView('password', 'icon-pass')">
                                <i class="fa-regular fa-eye" id="icon-pass"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Repite tu clave" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleView('password_confirm', 'icon-confirm')">
                                <i class="fa-solid fa-eye" id="icon-confirm"></i>
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
    function toggleView(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            // Condicional para mostrar contraseña, al cumplirse, significa que el input está en tipo "password" (Puntos negros).
            input.type = 'text'; //Toma el tipo de entrada del input, y la convierte en tipo texto para mostrarla.
            icon.classList.remove('fa-eye'); //Quita el ícono de ojo abierto.
            icon.classList.add('fa-eye-slash'); //Coloca el ícono de ojo tachado.
        } else {
            // lo contraario, oculta la contraseña.
            input.type = 'password'; //Convierte el tipo texto del input, en tipo password.
            icon.classList.remove('fa-eye-slash'); //Quita el ícono de ojo tachado.
            icon.classList.add('fa-eye'); //Coloca el ojo abierto.
        }
    }
</script>

<?= $this->endSection() ?>