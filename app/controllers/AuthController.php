<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    // Muestra el formulario de login
    public function loginForm()
    {
        include __DIR__ . '/../views/auth/login.php';
    }

    // Procesa el login
    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],  // Agregado para evitar el warning
                'role' => $user['role']
            ];
            // Si el usuario es administrador, redirige al panel de admin
            if ($user['role'] === 'admin') {
                header("Location: index.php?controller=admin&action=dashboard");
                exit;
            } else {
                header("Location: index.php?controller=home&action=index");
                exit;
            }
        } else {
            $_SESSION['error'] = "Credenciales inválidas.";
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }
    }


    // Muestra el formulario de registro
    public function registerForm()
    {
        include __DIR__ . '/../views/auth/register.php';
    }

    // Procesa el registro de usuario
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullName = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';

            // Validación de campos obligatorios
            if (empty($username) || empty($password) || empty($fullName) || empty($email)) {
                $_SESSION['error'] = "Todos los campos son obligatorios.";
                header("Location: index.php?controller=auth&action=registerForm");
                exit;
            }

            // Verificar si el usuario o el email ya existen
            if (User::findByUsername($username)) {
                $_SESSION['error'] = "El usuario ya existe.";
                header("Location: index.php?controller=auth&action=registerForm");
                exit;
            }

            if (User::findByEmail($email)) {
                $_SESSION['error'] = "El email ya está registrado.";
                header("Location: index.php?controller=auth&action=registerForm");
                exit;
            }

            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Crear el usuario en la base de datos
            $created = User::create($username, $hashedPassword, $fullName, $email);
            if ($created) {
                $_SESSION['flash'] = "¡Te has registrado con éxito!";
                $_SESSION['flash_type'] = "success";
                header("Location: index.php?controller=auth&action=loginForm");
                exit;
            } else {
                $_SESSION['error'] = "Error al registrar el usuario.";
                header("Location: index.php?controller=auth&action=registerForm");
                exit;
            }
        }
    }

    // Cierra la sesión
    public function logout()
    {
        session_destroy();
        header("Location: index.php?controller=auth&action=loginForm");
        exit;
    }
}
