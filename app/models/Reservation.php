<?php
// app/models/Reservation.php

require_once __DIR__ . '/Database.php';

class Reservation
{
    public static function getAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT r.*, u.username, g.name as gym_name 
                           FROM reservations r
                           JOIN users u ON r.user_id = u.id
                           JOIN gyms g ON r.gym_id = g.id
                           ORDER BY r.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT r.*, u.username, g.name as gym_name 
                            FROM reservations r
                            JOIN users u ON r.user_id = u.id
                            JOIN gyms g ON r.gym_id = g.id
                            WHERE r.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $gym_id, $reservation_date, $reservation_time, $voucher, $status = 'pendiente')
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO reservations (user_id, gym_id, reservation_date, reservation_time, voucher, status) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$user_id, $gym_id, $reservation_date, $reservation_time, $voucher, $status]);
    }

    public static function updateStatus($id, $status)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
    public static function getCountByDate($date)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM reservations WHERE reservation_date = ?");
        $stmt->execute([$date]);
        return $stmt->fetchColumn();
    }

}
