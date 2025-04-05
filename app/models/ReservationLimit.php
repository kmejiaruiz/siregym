<?php
// app/models/ReservationLimit.php

require_once __DIR__ . '/Database.php';

class ReservationLimit
{
    // Obtiene el límite para un gimnasio y una fecha determinada
    public static function getLimit($gym_id, $date)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM reservation_limits WHERE gym_id = ? AND reservation_date = ?");
        $stmt->execute([$gym_id, $date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserta o actualiza el límite para un gimnasio y una fecha determinada
    public static function setLimit($gym_id, $date, $max_reservations)
    {
        $existing = self::getLimit($gym_id, $date);
        $db = Database::getInstance()->getConnection();
        if ($existing) {
            $stmt = $db->prepare("UPDATE reservation_limits SET max_reservations = ? WHERE gym_id = ? AND reservation_date = ?");
            return $stmt->execute([$max_reservations, $gym_id, $date]);
        } else {
            $stmt = $db->prepare("INSERT INTO reservation_limits (gym_id, reservation_date, max_reservations) VALUES (?,?,?)");
            return $stmt->execute([$gym_id, $date, $max_reservations]);
        }
    }

    // Obtiene todos los límites para un gimnasio
    public static function getAllLimits($gym_id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM reservation_limits WHERE gym_id = ? ORDER BY reservation_date ASC");
        $stmt->execute([$gym_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
