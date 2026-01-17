<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
    /* 1. Fondo que ocupa TODA la pantalla */
    .auth-background {
        background-image: url('<?= base_url('assets/img/backgrounds/fondo-login.jpg') ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100vw;
        /* Ancho completo de la ventana */
        min-height: 100vh;
        /* Alto completo de la ventana */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: calc(-50vw + 50%);
        /* Truco para ignorar márgenes si los hubiera */
        margin-top: -1.5rem;
        /* Sube para pegarse a la navbar rosa */
        padding: 20px;
    }

    /* 2. Aseguramos que la tarjeta tenga un tamaño decente */
    .reset-card {
        width: 100%;
        max-width: 400px;
        /* Tamaño estándar de login */
        border-radius: 15px;
        background-color: rgba(255, 255, 255, 0.95);
        border: none;
    }

    /* 3. Tus estilos de inputs (mantenemos los originales) */
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

    .input-group:focus-within .form-control,
    .input-group:focus-within .input-group-text {
        border-color: var(--azul-logo);
        box-shadow: 0 0 0 0.25rem rgba(22, 194, 232, 0.25);
    }

    .btn-primary {
        background-color: var(--marron-logo, #8B4513);
        border: none;
    }

    .btn-primary:hover {
        background-color: var(--rosa-logo, #e91e63);
    }
</style>

<div class="auth-background">
    <div class="card reset-card shadow-lg">
        <div class="card-header bg-transparent text-center py-4 border-0">
            <h2 class="fw-bold" style="color: var(--rosa-logo); margin-bottom: 0;">Nueva Contraseña</h2>
            <p class="text-muted small">Ingresa tu nueva clave de acceso</p>
        </div>

        <div class="card-body p-4">
            <form action="<?= base_url('auth/update_password') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= $token ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold" style="color: var(--marron-logo);">Nueva Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="p1" class="form-control" placeholder="••••••••" required>
                        <span class="input-group-text" onclick="togglePassword('p1')">
                            <i class="fa-solid fa-eye" id="icon-p1"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: var(--marron-logo);">Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="p2" class="form-control" placeholder="••••••••" required>
                        <span class="input-group-text" onclick="togglePassword('p2')">
                            <i class="fa-solid fa-eye" id="icon-p2"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm text-white">
                        ACTUALIZAR CONTRASEÑA
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold" style="color: var(--marron-logo);">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver al inicio
                </a>
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
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        
        <form action="<?= base_url('auth/update_password') ?>" method="POST">
            
            <input type="hidden" name="token" value="<?= $token ?>">
            
            <div class="form-group">
                <label>Nueva Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary">
                Actualizar y Guardar
            </button>
            
            </form>
    </div>
<?= $this->endSection() ?>