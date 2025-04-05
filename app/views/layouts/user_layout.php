<?php
$loggedIn = isset($_SESSION['user']); // Verifica si hay un usuario logueado
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Sistema de Reservas'; ?></title>
    <!-- CSS de AdminLTE (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./app/assets/css/darkmode.css"> -->
    <style>
        body.no-sidebar {
            height: 100vh !important;
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<?php include 'loader.php'; ?>

<body class="<?= $loggedIn ? 'hold-transition sidebar-mini' : 'no-sidebar' ?>">

    <?php if ($loggedIn): ?>
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars">Toggle</i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto ">
                    <li class="nav-item">
                        <a href="index.php?controller=home&action=index" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?controller=reservation&action=form" class="nav-link">Reservar</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?controller=reservation&action=list" class="nav-link">Mis Reservas</a>
                    </li>
                    <li class="nav-item">
                        <button onclick="alert('Opcion no disponible actualmente')" class="nav-link">Dark Mode</button>
                    </li>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a href="index.php?controller=admin&action=dashboard" class="nav-link">Espacio Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="index.php?controller=auth&action=logout" class="nav-link">Cerrar sesión</a>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="index.php?controller=home&action=index" class="brand-link">
                    <img src="assets/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3"> <br>
                    <span class="brand-text font-weight-light text-start">
                        <?= htmlspecialchars($_SESSION['user']['full_name']) ?>
                    </span>
                </a>
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column">
                            <li class="nav-item">
                                <a href="index.php?controller=home&action=index" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Inicio</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?controller=reservation&action=form" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-plus"></i>
                                    <p>Realizar Reserva</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?controller=reservation&action=list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Mis Reservas</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <section class="content">
                    <?= $content ?>
                </section>
            </div>

            <!-- Footer -->
            <footer class="main-footer text-center">
                <strong>&copy; <?php echo date("Y"); ?> Gimnasio Profesional.</strong>
            </footer>
        </div>
    <?php endif; ?>
    <div class="container-fluid pt-3 d-flex justify-content-center">
        <?php echo $content; ?>
    </div>

    <!-- JS (jQuery, Bootstrap, AdminLTE) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script src="./app/assets/js/toggle-dark.js"></script>
</body>

</html>