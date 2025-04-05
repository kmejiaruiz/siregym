<?php
// app/models/Alert.php

require_once __DIR__ . '/Database.php';

class Alert
{
    public static function getAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM alerts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $type, $message)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO alerts (user_id, type, message) VALUES (?,?,?)");
        return $stmt->execute([$user_id, $type, $message]);
    }
}
