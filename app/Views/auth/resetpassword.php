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