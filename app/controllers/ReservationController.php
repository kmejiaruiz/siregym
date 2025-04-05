<?php
// app/controllers/ReservationController.php

require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Para Dompdf
use Dompdf\Dompdf;

class ReservationController
{
    // Verifica si el usuario está autenticado
    private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=loginForm");
            exit;
        }
    }

    public function form()
    {
        $this->checkAuth();
        // Obtener horarios disponibles para el gimnasio (se asume gym_id = 1)
        require_once __DIR__ . '/../models/ScheduleSlot.php';
        $slots = ScheduleSlot::getAllAvailable(1);
        include __DIR__ . '/../views/reservation/form.php';
    }


    public function create()
    {
        $this->checkAuth();
        $user_id = $_POST['user_id'];
        $gym_id = $_POST['gym_id'];
        $reservation_date = $_POST['reservation_date'];
        $reservation_time = $_POST['reservation_time'];
        $voucher = $_POST['voucher'];

        if (empty($reservation_date) || empty($reservation_time) || empty($voucher)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: index.php?controller=reservation&action=form");
            exit;
        }
        if ($reservation_date < date('Y-m-d')) {
            $_SESSION['error'] = "La fecha no puede ser anterior a hoy.";
            header("Location: index.php?controller=reservation&action=form");
            exit;
        }
        if ($reservation_date == date('Y-m-d') && $reservation_time < date('H:i')) {
            $_SESSION['error'] = "La hora seleccionada no puede ser menor que la hora actual.";
            header("Location: index.php?controller=reservation&action=form");
            exit;
        }

        $result = Reservation::create($user_id, $gym_id, $reservation_date, $reservation_time, $voucher);
        if ($result) {
            $_SESSION['success'] = "Reserva creada con éxito.";
        } else {
            $_SESSION['error'] = "Error al crear la reserva.";
        }
        header("Location: index.php?controller=reservation&action=list");
    }

    public function list()
    {
        $this->checkAuth();
        $reservations = Reservation::getAll();
        include __DIR__ . '/../views/reservation/list.php';
    }

    public function view()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=reservation&action=list");
            exit;
        }
        $reservation = Reservation::getById($id);
        include __DIR__ . '/../views/reservation/view.php';
    }

    public function generatePDF()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "Reserva no encontrada.";
            header("Location: index.php?controller=reservation&action=list");
            exit;
        }
        $reservation = Reservation::getById($id);
        if (!$reservation) {
            $_SESSION['error'] = "Reserva no encontrada.";
            header("Location: index.php?controller=reservation&action=list");
            exit;
        }

        $html = '
         <!DOCTYPE html>
         <html lang="es">
         <head>
             <meta charset="UTF-8">
             <title>Comprobante de Reserva</title>
             <style>
                body { font-family: Arial, sans-serif; }
                .header { text-align: center; margin-bottom: 20px; }
                .header img { max-width: 120px; }
                .details { width: 80%; margin: 0 auto; }
                .details table { width: 100%; border-collapse: collapse; }
                .details th, .details td { border: 1px solid #ddd; padding: 8px; }
                .details th { background: #f2f2f2; }
                .footer { text-align: center; margin-top: 30px; font-size: 0.9em; color: #555; }
             </style>
         </head>
         <body>
             <div class="header">
                 <img src="http://' . $_SERVER['HTTP_HOST'] . '/assets/img/logo.png" alt="Logo Gimnasio">
                 <h1>Gimnasio Profesional</h1>
                 <p>Av. Ejemplo 123, Ciudad, País | Tel: (123) 456-7890</p>
             </div>
             <div class="details">
                 <h2 style="text-align:center;">Comprobante de Reserva</h2>
                 <table>
                     <tr>
                         <th>ID Reserva</th>
                         <td>' . htmlspecialchars($reservation['id']) . '</td>
                     </tr>
                     <tr>
                         <th>Fecha Reservada</th>
                         <td>' . htmlspecialchars($reservation['reservation_date']) . '</td>
                     </tr>
                     <tr>
                         <th>Hora Reservada</th>
                         <td>' . htmlspecialchars($reservation['reservation_time']) . '</td>
                     </tr>
                     <tr>
                         <th>Usuario</th>
                         <td>' . htmlspecialchars($reservation['username']) . '</td>
                     </tr>
                     <tr>
                         <th>Gimnasio</th>
                         <td>' . htmlspecialchars($reservation['gym_name']) . '</td>
                     </tr>
                     <tr>
                         <th>Voucher</th>
                         <td>' . htmlspecialchars($reservation['voucher']) . '</td>
                     </tr>
                     <tr>
                         <th>Status</th>
                         <td>' . htmlspecialchars($reservation['status']) . '</td>
                     </tr>
                 </table>
             </div>
             <div class="footer">
                 <p>&copy; ' . date("Y") . ' Gimnasio Profesional. Todos los derechos reservados.</p>
             </div>
         </body>
         </html>
         ';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Comprobante_Reserva_" . $reservation['id'] . ".pdf", ["Attachment" => true]);
        exit;
    }
}
