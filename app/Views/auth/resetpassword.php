<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
    /* Hola, arreglé el fondo para que cubra toda la pantalla y no se viera recortado. Att: Andrés <3 */
    /* Lo optimicé usando min-height para que el contenido siempre quepa */
    .auth-background-reset {
        background-image: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), 
                          url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>');
        background-size: cover;
        background-position: center center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Este contenedor centra la tarjeta vertical y horizontalmente, corrigiendo lo feo que se veía a un lado*/
    .reset-wrapper {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reset-card {
        width: 100%;
        max-width: 450px; /* Un poquito más ancha para que respire mejor en PC */
        border-radius: 20px !important;
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        border: none;
    }

    /* Estilo para que el "ojito" se vea igual que en el login */
    .input-group-text {
        border-left: none;
        background-color: #ffffff !important;
        border-color: #dee2e6;
        color: var(--marron-logo);
        cursor: pointer;
    }
    
    .form-control { 
        border-right: none; 
    }
    
    .form-control:focus { 
        border-color: #dee2e6; 
        box-shadow: none; 
    }

    /* Ajuste para que el botón no se vea gigante en PC pero sí cómodo en móvil */
    .btn-update {
        padding: 12px;
        font-size: 1rem;
    }
</style>

<div class="row justify-content-center w-100 g-0 py-5">
    <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
        <div class="card reset-card shadow-lg mx-auto">
            <div class="card-header bg-transparent text-center py-4 border-0">
                <i class="fa-solid fa-shield-halved fa-3x mb-3 cupcake-icon" style="color: var(--rosa-logo);"></i>
                <h2 class="fw-bold" style="color: var(--rosa-logo); margin-bottom: 0;">Nueva Contraseña</h2>
                <p class="text-muted small">Ingresa tu nueva clave de acceso</p>
            </div>

            <div class="card-body p-4 p-md-5 pt-0">
                <form action="<?= base_url('auth/update_password') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="Id_usuario" value="<?= $Id_usuario ?>"> 
                    <input type="hidden" name="token" value="<?= $token ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: var(--marron-logo);">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="p1" class="form-control form-control-lg fs-6" placeholder="••••••••" required>
                            <span class="input-group-text" onclick="togglePassword('p1')">
                                <i class="fa-solid fa-eye" id="icon-p1"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: var(--marron-logo);">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="p2" class="form-control form-control-lg fs-6" placeholder="••••••••" required>
                            <span class="input-group-text" onclick="togglePassword('p2')">
                                <i class="fa-solid fa-eye" id="icon-p2"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-update fw-bold shadow-sm text-white">
                            ACTUALIZAR CONTRASEÑA
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold small" style="color: var(--marron-logo);">
                        <i class="fa-solid fa-arrow-left me-1"></i> Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

<?= $this->endSection() ?>