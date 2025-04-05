<?php
// index.php (en la raíz del proyecto)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Obtener controlador y acción desde la URL
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'loginForm';

// Cargar el controlador correspondiente
switch ($controller) {
    case 'reservation':
        require_once __DIR__ . '/app/controllers/ReservationController.php';
        $obj = new ReservationController();
        break;
    case 'admin':
        require_once __DIR__ . '/app/controllers/AdminController.php';
        $obj = new AdminController();
        break;
    case 'auth':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        $obj = new AuthController();
        break;
    default:
        require_once __DIR__ . '/app/controllers/HomeController.php';
        $obj = new HomeController();
        break;
}

// Ejecutar la acción solicitada
if (method_exists($obj, $action)) {
    $obj->$action();
} else {
    echo 'Acción no encontrada.';
}
