<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalle de la Reserva</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?php echo $reservation['id']; ?></td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td><?php echo $reservation['reservation_date']; ?></td>
            </tr>
            <tr>
                <th>Hora</th>
                <td><?php echo $reservation['reservation_time']; ?></td>
            </tr>
            <tr>
                <th>Usuario</th>
                <td><?php echo $reservation['username']; ?></td>
                <td>---</td>
            </tr>
            <tr>
                <th>Gimnasio</th>
                <td><?php echo $reservation['gym_name']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $reservation['status']; ?></td>
            </tr>
            <tr>
                <th>Voucher</th>
                <td><?php echo $reservation['voucher']; ?></td>
            </tr>
        </table>
        <a href="index.php?controller=reservation&action=list" class="btn btn-primary">Volver al Listado</a>
        <a href="index.php?controller=reservation&action=generatePDF&id=<?php echo $reservation['id']; ?>"
            class="btn btn-success">Descargar PDF</a>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Detalle de Reserva";
include __DIR__ . '/../layouts/user_layout.php';
?>