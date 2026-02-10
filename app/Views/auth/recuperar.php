<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row justify-content-center w-100 g-0">
    <div class="col-11 col-sm-8 col-md-6 col-lg-4">
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('mensaje') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-key fa-3x mb-3 cupcake-icon" style="color: var(--rosa-logo);"></i>
                    <h4 class="fw-bold" style="color: var(--negro-logo);">Recuperar acceso</h4>
                    <p class="text-muted small">Te enviaremos las instrucciones a tu correo</p>
                </div>

                <form action="<?= base_url('auth/enviar-recuperacion') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Correo registrado</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="ejemplo@correo.com" value="<?= old('email') ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg mb-3 shadow-sm fw-bold">
                        ENVIAR ENLACE
                    </button>

                    <div class="text-center">
                        <a href="<?= base_url('login') ?>" class="text-muted small text-decoration-none">
                            <i class="fa-solid fa-arrow-left me-1"></i> Volver al inicio
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>