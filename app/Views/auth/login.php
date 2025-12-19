<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <i class="fa-solid fa-cake-candles fa-3x mb-3 cupcake-icon"></i>
                <h3 class="fw-bold mb-4" style="color: var(--negro-logo);">¡Hola de nuevo!</h3>
                
                <form action="<?= base_url('auth/ingresar') ?>" method="POST">
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Correo electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="tu@correo.com" required>
                    </div>
                    <div class="mb-4 text-start">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                        Entrar a mi cocina
                    </button>
                    
                    <div class="d-flex justify-content-between small">
                        <a href="<?= base_url('auth/recuperar') ?>" class="text-muted text-decoration-none">¿Olvidaste la clave?</a>
                        <a href="<?= base_url('auth/registro') ?>" class="text-rosa text-decoration-none fw-bold">Crear cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>