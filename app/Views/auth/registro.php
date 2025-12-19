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
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre del Emprendimiento</label>
                        <input type="text" name="nombre_negocio" class="form-control" placeholder="Ej: Dulce Capricho" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tu correo</label>
                        <input type="email" name="email" class="form-control" placeholder="chef@reposteria.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Crea una clave segura" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                        Registrarme
                    </button>
                    
                    <p class="text-center small">
                        ¿Ya tienes cuenta? <a href="<?= base_url('auth/login') ?>" class="text-rosa fw-bold text-decoration-none">Inicia sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>