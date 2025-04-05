<?php
// app/controllers/HomeController.php

class HomeController
{
    public function index()
    {
        // Verifica si el usuario está autenticado
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }
        include __DIR__ . '/../views/home/index.php';
    }
}
