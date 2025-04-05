<?php
// app/models/ScheduleSlot.php

require_once __DIR__ . '/Database.php';

class ScheduleSlot
{
    // Retorna todos los horarios disponibles para un gimnasio
    public static function getAllAvailable($gym_id = 1)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM schedule_slots WHERE gym_id = ? AND is_available = 1 ORDER BY slot_time ASC");
        $stmt->execute([$gym_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retorna todos los horarios (para administraci\u00f3n)
    public static function getAll($gym_id = 1)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM schedule_slots WHERE gym_id = ? ORDER BY slot_time ASC");
        $stmt->execute([$gym_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agrega un nuevo horario
    public static function addSlot($gym_id, $slot_time)
    {
        $db = Database::getInstance()->getConnection();
        // Evitar duplicados
        $stmt = $db->prepare("SELECT COUNT(*) FROM schedule_slots WHERE gym_id = ? AND slot_time = ?");
        $stmt->execute([$gym_id, $slot_time]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }
        $stmt = $db->prepare("INSERT INTO schedule_slots (gym_id, slot_time, is_available) VALUES (?, ?, 1)");
        return $stmt->execute([$gym_id, $slot_time]);
    }

    // Elimina un horario
    public static function deleteSlot($slot_id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM schedule_slots WHERE id = ?");
        return $stmt->execute([$slot_id]);
    }

    // Actualiza la disponibilidad de un horario (1: disponible, 0: no disponible)
    public static function updateAvailability($slot_id, $is_available)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE schedule_slots SET is_available = ? WHERE id = ?");
        return $stmt->execute([$is_available, $slot_id]);
    }

    // Actualiza el valor de un horario
    public static function updateSlotTime($slot_id, $new_time)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE schedule_slots SET slot_time = ? WHERE id = ?");
        return $stmt->execute([$new_time, $slot_id]);
    }
}
