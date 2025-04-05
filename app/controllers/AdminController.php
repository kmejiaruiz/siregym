<?php
// app/controllers/AdminController.php

require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Alert.php';
require_once __DIR__ . '/../models/ScheduleSlot.php';
require_once __DIR__ . '/../models/ReservationLimit.php';

class AdminController
{
    // Verifica que el usuario tenga rol de admin
    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();
        $reservations = Reservation::getAll();
        $alerts = Alert::getAll();
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function updateStatus()
    {
        $this->checkAdmin();
        $id = $_POST['id'];
        $status = $_POST['status'];
        Reservation::updateStatus($id, $status);
        header("Location: index.php?controller=admin&action=dashboard");
    }

    // Gesti\u00f3n de horarios y cupos
    public function manageSlots()
    {
        $this->checkAdmin();
        $gym_id = 1; // Valor fijo para este ejemplo

        // Procesar actualizaci\u00f3n del l\u00edmite de reservaciones
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['limit_date']) && isset($_POST['max_reservations']) && !isset($_POST['new_slot']) && !isset($_POST['new_slot_time'])) {
            $limit_date = $_POST['limit_date'];
            $max_reservations = intval($_POST['max_reservations']);
            $result = ReservationLimit::setLimit($gym_id, $limit_date, $max_reservations);
            if ($result) {
                $_SESSION['success'] = "L\u00edmite de reservaciones actualizado para $limit_date.";
            } else {
                $_SESSION['error'] = "Error al actualizar el l\u00edmite.";
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Procesar la adici\u00f3n de un nuevo horario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_slot'])) {
            $new_slot = $_POST['new_slot'];
            $result = ScheduleSlot::addSlot($gym_id, $new_slot);
            if ($result) {
                $_SESSION['success'] = "Horario $new_slot agregado exitosamente.";
            } else {
                $_SESSION['error'] = "Error al agregar el horario o ya existe.";
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Procesar la edici\u00f3n de un horario (nueva hora)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slot_id']) && isset($_POST['new_slot_time'])) {
            $slot_id = $_POST['slot_id'];
            $new_time = $_POST['new_slot_time'];
            if (ScheduleSlot::updateSlotTime($slot_id, $new_time)) {
                $_SESSION['success'] = "Horario actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el horario.";
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Procesar la alternancia (toggle) de disponibilidad
        if (isset($_GET['toggle_slot'])) {
            $slot_id = $_GET['toggle_slot'];
            // Obtener el horario actual
            $slots = ScheduleSlot::getAll($gym_id);
            foreach ($slots as $slot) {
                if ($slot['id'] == $slot_id) {
                    $newAvailability = $slot['is_available'] ? 0 : 1;
                    ScheduleSlot::updateAvailability($slot_id, $newAvailability);
                    break;
                }
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Procesar eliminaci\u00f3n de un horario
        if (isset($_GET['delete_slot'])) {
            $slot_id = $_GET['delete_slot'];
            $result = ScheduleSlot::deleteSlot($slot_id);
            if ($result) {
                $_SESSION['success'] = "Horario eliminado correctamente.";
            } else {
                $_SESSION['error'] = "Error al eliminar el horario.";
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Procesar edici\u00f3n de cupos (l\u00edmite) - se maneja en el formulario de l\u00edmite arriba
        // Procesar eliminaci\u00f3n de un l\u00edmite
        if (isset($_GET['delete_limit'])) {
            $limit_id = $_GET['delete_limit'];
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM reservation_limits WHERE id = ?");
            $stmt->execute([$limit_id]);
            $_SESSION['success'] = "L\u00edmite eliminado.";
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        }

        // Obtener todos los horarios y cupos para mostrar en la vista
        $slots = ScheduleSlot::getAll($gym_id);
        $limits = ReservationLimit::getAllLimits($gym_id);
        include __DIR__ . '/../views/admin/manage_slots.php';
    }

    // M\u00e9todo para mostrar formulario de edici\u00f3n de l\u00edmite
    public function editLimit()
    {
        $this->checkAdmin();
        if (isset($_GET['limit_id'])) {
            $limit_id = $_GET['limit_id'];
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM reservation_limits WHERE id = ?");
            $stmt->execute([$limit_id]);
            $limitData = $stmt->fetch(PDO::FETCH_ASSOC);
            include __DIR__ . '/../views/admin/edit_limit.php';
        }
    }

    public function updateLimit()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['limit_id']) && isset($_POST['max_reservations'])) {
            $limit_id = $_POST['limit_id'];
            $max_reservations = $_POST['max_reservations'];
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE reservation_limits SET max_reservations = ? WHERE id = ?");
            if ($stmt->execute([$max_reservations, $limit_id])) {
                $_SESSION['success'] = "Limite actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el limite.";
            }
        }
        header("Location: index.php?controller=admin&action=manageSlots");
    }
    // En app/controllers/AdminController.php, agregar:
    public function editSlot()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slot_id']) && isset($_POST['new_slot_time'])) {
            $slot_id = $_POST['slot_id'];
            $new_time = $_POST['new_slot_time'];
            if (ScheduleSlot::updateSlotTime($slot_id, $new_time)) {
                $_SESSION['success'] = "Horario actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el horario.";
            }
            header("Location: index.php?controller=admin&action=manageSlots");
            exit;
        } else {
            echo "Acción no encontrada.";
        }
    }

}
