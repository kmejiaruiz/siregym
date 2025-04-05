<?php
// app/models/Database.php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        try {
            $dsn = "mysql:host=" . $config['db']['host'] . ";dbname=" . $config['db']['dbname'] . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión a la BD: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
