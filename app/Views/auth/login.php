<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center w-100 g-0 py-4">
    <div class="col-11 col-sm-8 col-md-6 col-lg-4">
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-exclamation me-2 fs-5"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" role="alert" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                    <div><?= session()->getFlashdata('mensaje') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5 text-center">
                
                <i class="fa-solid fa-cake-candles fa-3x mb-3 cupcake-icon" style="color: var(--rosa-logo);"></i>
                <h3 class="fw-bold mb-4" style="color: var(--negro-logo);">¡Hola de nuevo!</h3>

                <form action="<?= base_url('auth/ingresar') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Correo electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="tu@correo.com" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-4 text-start">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-lg fs-6" placeholder="Tu clave" required>
                            <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword()" style="border-color: #dee2e6; background: white;">
                                <i class="fa-solid fa-eye" id="icon-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-4 shadow-sm fw-bold text-white" style="background-color: var(--azul-logo) !important; border: none;">
                        ENTRAR A MI COCINA
                    </button>

                    <div class="d-flex justify-content-between align-items-center small">
                        <a href="<?= base_url('recuperar') ?>" class="text-muted text-decoration-none">¿Olvidaste la clave?</a>
                        <a href="<?= base_url('registro') ?>" class="text-rosa text-decoration-none fw-bold">Crear cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('icon-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

<?= $this->endSection() ?>