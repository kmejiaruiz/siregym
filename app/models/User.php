<?php
// app/models/User.php

require_once __DIR__ . '/Database.php';

class User
{
    // Busca un usuario por su nombre de usuario
    public static function findByUsername($username)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca un usuario por su correo electrónico
    public static function findByEmail($email)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crea un nuevo usuario
    public static function create($username, $hashedPassword, $fullName, $email)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO users (username, password, full_name, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $fullName, $email]);
    }
}
