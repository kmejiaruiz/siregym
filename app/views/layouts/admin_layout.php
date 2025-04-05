<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Dashboard Admin'; ?></title>
    <!-- CSS de Flatkit (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatkit@latest/css/flatkit.min.css">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./app/assets/css/darkmode.css"> -->

</head>

<body>
    <?php include 'loader.php'; ?>
    <header class="header header-fixed navbar">
        <div class="header-brand">
            <a href="index.php?controller=admin&action=dashboard">
                <img src="assets/img/logo.png" alt="Logo" class="logo">
            </a>
        </div>
        <ul class="nav">

            <li class="nav-item">
                <button onclick="alert('Opcion no disponible actualmente')" class="nav-link">Dark Mode</button>
            </li>
            <li class="nav-item">
                <a href="index.php?controller=admin&action=dashboard" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="index.php?controller=admin&action=manageSlots" class="nav-link">Gestionar
                    Horarios</a>
            </li>
            <li class="nav-item">
                <a href="index.php?controller=home&action=index" class="nav-link">Salir al Sitio</a>
            </li>
        </ul>
    </header>
    <div class="content">
        <div class="container">
            <?php echo $content; ?>
        </div>
    </div>
    <footer class="footer text-center">
        <p>&copy; <?php echo date("Y"); ?> Gimnasio Profesional. Todos los derechos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatkit@latest/js/flatkit.min.js"></script>
    <script src="./app/assets/js/toggle-dark.js"></script>

</body>

</html>