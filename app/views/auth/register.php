<?php
ob_start();
?>
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Gimnasio</b>Reservas</a>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['flash'];
                    unset($_SESSION['flash']);
                    ?>
                </div>
            <?php endif; ?>
            <p class="register-box-msg">Regístrate para comenzar</p>
            <form action="index.php?controller=auth&action=register" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="full_name" class="form-control" placeholder="Nombre Completo" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1 text-center">
                <a href="index.php?controller=auth&action=loginForm">¿Ya tienes una cuenta? Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Registro de Usuario";
include __DIR__ . '/../layouts/user_layout.php';
?>