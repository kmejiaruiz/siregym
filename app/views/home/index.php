<?php
ob_start();
?>
<div class="conatiner-fluid text-dark d-flex justify-content-center align-items-center" style="min-height: 70vh !important;">
    <div>
        <h1 class="display-4">Bienvenido al Sistema de Reservas para Gimnasios</h1>
        <p class="lead">Administra tus reservas y consulta tus comprobantes de forma sencilla.</p>
        <hr class="my-4">
        <p>
            <a href="index.php?controller=reservation&action=form" class="btn btn-success btn-lg">Realizar Reserva</a>
            <a href="index.php?controller=reservation&action=list" class="btn btn-primary btn-lg">Ver Mis Reservas</a>
        </p>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Inicio";
include __DIR__ . '/../layouts/user_layout.php';
?>