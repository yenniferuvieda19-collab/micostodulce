<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Costo Dulce | Panel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css') ?>">

    <style>
        .navbar {
            background-color: var(--rosa-logo) !important;
        }

        .cupcake-icon {
            color: var(--azul-logo) !important; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        footer {
            border-top: 1px solid rgba(0,0,0,0.05);
            /* Quite el margin-top: 4rem !important, y le agregue flexbox para que lo maneje */
        }

        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
        }

        /* Ajuste para que el contenido no quede pegado a la navbar en el login */
        .auth-bg main {
            padding-top: 5rem;
        }
    </style>
</head>

<body class="<?= (url_is('login') || url_is('registro') || url_is('recuperar')) ? 'auth-bg' : '' ?> d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
            <i class="fa-solid fa-cake-candles cupcake-icon me-2"></i> Mi Costo Dulce
        </a>
        
        <?php if(session()->get('isLoggedIn')): ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('ingredientes') ?>">Mis Insumos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('recetas') ?>">Mis Recetas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light btn-sm text-dark ms-lg-3 px-3 shadow-sm" href="<?= base_url('salir') ?>">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>

<main class="container flex-grow-1">
    <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success shadow-sm mb-4 border-success">
            <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger shadow-sm mb-4 border-danger">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('contenido') ?>

</main>

<footer class="bg-light text-center py-3 mt-auto">
    <div class="container">
        <small class="text-muted">
            Hecho con ❤️ para <strong>Dulce Capricho</strong> &copy; 2026
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/scripts.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmarBorrado(event, url) {
            event.preventDefault(); // Detiene la acción para que no borre de una vez
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás recuperar este elemento después!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Rojo para borrar
                cancelButtonColor: '#3085d6', // Azul para cancelar
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url; // Si dice sí, procedemos a borrar
                }
            })
        }
    </script>

</body>
</html>