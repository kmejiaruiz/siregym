<?php
ob_start();
?>

<style>
    body {
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .login-container {
        display: flex;
        width: 80%;
        max-width: 900px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .login-form {
        flex: 1;
        padding: 40px;
    }

    .login-image {
        flex: 1;
        background: url('https://cdn.open-pr.com/L/1/L119850978_g.jpg') center/cover;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-custom {
        background-color: #3b531c;
        color: #fff;
        border-radius: 5px;
    }

    .btn-custom:hover {
        background-color: #2f4216;
    }

    .text-small {
        font-size: 14px;
    }
</style>
</head>

<body>

    <div class="login-container">
        <div class="login-form">
            <h2 class="fw-bold">Bienvenido de nuevo!</h2>
            <p class="text-muted">Accede con tus credenciales.</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=auth&action=login" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" id="username" name="username" class="form-control"
                        placeholder="Introduce tu usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Introduce tu contraseña" required>
                    <div class="text-end">
                        <a href="#" class="text-decoration-none text-small">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Recuérdame</label>
                </div>
                <button type="submit" class="btn btn-custom w-100 py-2">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <p class="text-small">¿No tienes cuenta? <a href="index.php?controller=auth&action=registerForm"
                        class="text-decoration-none">Crea una</a></p>
            </div>
        </div>

        <div class="login-image"></div>
    </div>

</body>

<?php
$content = ob_get_clean();
$title = "Iniciar Sesión";
include __DIR__ . '/../layouts/user_layout.php';
?>