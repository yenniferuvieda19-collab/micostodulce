<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Costo Dulce | Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --rosa-logo: #f26185;
            --marron-logo: #825a42;
            --azul-logo: #0fa7ee;
        }

        /* AJUSTE PARA FOOTER AL FINAL */
        body { 
            font-family: 'Montserrat', sans-serif; 
            min-height: 100vh; 
            margin: 0;
            display: flex;
            flex-direction: column; /* Esto permite que el contenido empuje al footer */
        }
        
        .auth-bg {
            background-image: url('<?= base_url("assets/img/backgrounds/fondo-login.jpg") ?>'); 
            background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;
        }

        .navbar { height: 80px; background-color: var(--rosa-logo) !important; border-bottom: 3px solid var(--marron-logo); }
        .navbar .container-fluid { padding-left: 60px !important; padding-right: 40px !important; }
        .navbar-brand { font-family: 'Playfair Display', serif !important; font-size: 1.8rem; display: flex; align-items: center; }

        .logo-cupcake-container {
            background-color: white; width: 50px; height: 50px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; margin-right: 15px;
        }

        /* EL MAIN CRECE PARA OCUPAR EL ESPACIO DISPONIBLE */
        main.container { 
            background-color: transparent !important; 
            padding: 20px; 
            margin-top: 20px;
            flex: 1 0 auto; /* Esto empuja el footer hacia abajo */
        }

        .glass-card {
            background-color: rgba(255, 255, 255, 0.95) !important; 
            border-radius: 20px !important; padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
        }

        /* BOTONES SÓLIDOS */
        .btn-dulce-rosa { background-color: #f26185 !important; color: white !important; border: none !important; font-weight: 600; }
        .btn-dulce-marron { background-color: #825a42 !important; color: white !important; border: none !important; font-weight: 600; }

        /* FOOTER ESTILIZADO */
        footer {
            flex-shrink: 0; /* Evita que el footer se encoja */
            background-color: rgba(255, 255, 255, 0.9);
            border-top: 2px solid var(--marron-logo);
        }

        @keyframes beat {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .heart-beat { color: var(--rosa-logo); display: inline-block; animation: beat 1.5s infinite; }
    </style>
</head>
<body class="auth-bg">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <div class="logo-cupcake-container"><i class="fa-solid fa-cake-candles" style="color: var(--rosa-logo);"></i></div>
                <span>Mi Costo Dulce</span>
            </a>
            <?php if (session()->get('isLoggedIn')): ?>
                <div class="ms-auto">
                    <a class="btn btn-light btn-sm rounded-pill fw-bold" href="<?= base_url('salir') ?>">Cerrar Sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container">
        <?= $this->renderSection('contenido') ?>
    </main>

    <footer class="text-center py-3">
        <div class="container">
            <p class="mb-0" style="font-family: 'Quicksand', sans-serif; color: var(--marron-logo); font-weight: 700;">
                Hecho con <i class="fa-solid fa-heart heart-beat"></i> para 
                <span style="font-family: 'Playfair Display', serif; color: var(--rosa-logo);">Dulce Capricho</span>
            </p>
            <small class="text-muted" style="font-size: 0.7rem;">&copy; <?= date('Y') ?> Mi Costo Dulce</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEliminacion(id, url) {
            Swal.fire({
                title: '¿Eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#825a42',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => { if (result.isConfirmed) window.location.href = url + '/' + id; });
        }
    </script>
</body>
</html>