<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-key fa-2x cupcake-icon"></i>
                    <h4 class="fw-bold mt-2" style="color: var(--negro-logo);">Recuperar acceso</h4>
                    <p class="text-muted small">Te enviaremos las instrucciones a tu correo</p>
                </div>
                
                <form action="<?= base_url('auth/enviar-recuperacion') ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Correo registrado</label>
                        <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        Enviar enlace
                    </button>
                    
                    <div class="text-center">
                        <a href="<?= base_url('login') ?>" class="text-muted small text-decoration-none">Volver al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>