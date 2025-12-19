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
        /* Fondo del Navbar con el rosa de la marca  de dulce capricho*/
        .navbar {
            background-color: var(--rosa-logo) !important;
        }

        /* ICONO CUPCAKE*/
        .cupcake-icon {
            color: #85C1E9 !important; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .nav-link {
            font-weight: 500;
        }

        footer {
            border-top: 1px solid #f1f1f1ff;
            margin-top: 4rem !important;
        }

        /* Estilo suave para las alertas de Mi Costo Dulce */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
            <i class="fa-solid fa-cake-candles cupcake-icon me-2"></i> Mi Costo Dulce
        </a>
        
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
    </div>
</nav>

<main class="container">
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

<footer class="text-center mt-5 py-3" style="color: var(--marron-logo);">
    <small>
        Hecho con ❤️ para <b>Dulce Capricho</b> &copy; <?= date('Y') ?>
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/scripts.js') ?>"></script>

</body>
</html>