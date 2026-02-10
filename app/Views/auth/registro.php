<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center w-100 g-0">
    <div class="col-11 col-sm-10 col-md-8 col-lg-5">
        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-cookie-bite fa-3x cupcake-icon mb-2" style="color: var(--rosa-logo);"></i>
                    <h3 class="fw-bold" style="color: var(--negro-logo);">Únete a Mi Costo Dulce</h3>
                    <p class="text-muted small">Comienza a organizar tus costos hoy mismo</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                            <div class="small">
                            <?= session()->getFlashdata('error') ?>
                            </div>
                        </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

<form action="<?= base_url('auth/registrar') ?>" method="POST"></form>

                <form action="<?= base_url('auth/registrar') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre del Emprendimiento</label>
                        <input type="text" name="nombre_negocio" class="form-control form-control-lg fs-6" placeholder="Ej: Dulce Capricho" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tu correo</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="chef@reposteria.com" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg fs-6" placeholder="Crea una clave segura" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="toggleView('password', 'icon-pass')" style="border-color: #dee2e6;">
                                    <i class="fa-regular fa-eye" id="icon-pass"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-lg fs-6" placeholder="Repite tu clave" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="toggleView('password_confirm', 'icon-confirm')" style="border-color: #dee2e6;">
                                    <i class="fa-solid fa-eye" id="icon-confirm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3 shadow-sm fw-bold">
                        Registrarme
                    </button>

                    <p class="text-center small mb-0">
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
            
            // Usamos replace para cambiar el icono de forma moderna
            icon.classList.replace('fa-eye', 'fa-eye-slash'); //Quita el ícono de ojo abierto y coloca el tachado.
            icon.classList.replace('fa-regular', 'fa-solid'); 
        } else {
            // lo contraario, oculta la contraseña.
            input.type = 'password'; //Convierte el tipo texto del input, en tipo password.
            
            icon.classList.replace('fa-eye-slash', 'fa-eye'); //Quita el ícono de ojo tachado y coloca el abierto.
            icon.classList.replace('fa-solid', 'fa-regular');
        }
    }
</script>

<?= $this->endSection() ?>