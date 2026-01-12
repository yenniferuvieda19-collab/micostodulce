<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Costo Dulce | Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css?v=' . time()) ?>">

    <style>
        .navbar {
            background-color: var(--rosa-logo) !important;
        }

        .cupcake-icon {
            color: var(--azul-logo) !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
        }

        /* Ajuste para que el contenido baje un poco más */
        .auth-bg main {
            padding-top: 5rem;
        }
    </style>
</head>

<body class="auth-bg d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="<?= base_url() ?>"
                style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.5px;">
                <i class="fa-solid fa-cake-candles cupcake-icon fa-lg me-3"></i> Mi Costo Dulce
            </a>

            <?php if (session()->get('isLoggedIn')): ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">

                        <li class="nav-item">
                            <a class="nav-link btn btn-light btn-sm text-dark ms-lg-3 px-5 shadow-sm" href="<?= base_url('salir') ?>">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container flex-grow-1">

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-success mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                    <div>
                        <strong>¡Éxito!</strong> <?= session()->getFlashdata('mensaje') ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-danger mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-triangle-exclamation me-3 fs-4"></i>
                    <div>
                        <strong>Atención:</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('contenido') ?>

    </main>

    <footer class="bg-light text-center py-3 mt-4">
        <div class="container">
            <small class="text-muted">
                Hecho con ❤️ para <strong>Dulce Capricho</strong> &copy; 2026
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (file_exists('assets/js/scripts.js')): ?>
        <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <?php endif; ?>

    <?= $this->renderSection('scripts') ?>

</body>

</html>