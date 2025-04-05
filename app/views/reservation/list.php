<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Reservas</h3>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Gimnasio</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><?php echo $res['id']; ?></td>
                        <td><?php echo $res['reservation_date']; ?></td>
                        <td><?php echo $res['reservation_time']; ?></td>
                        <td><?php echo $res['gym_name']; ?></td>
                        <td><?php echo $res['status']; ?></td>
                        <td>
                            <a href="index.php?controller=reservation&action=view&id=<?php echo $res['id']; ?>"
                                class="btn btn-info btn-sm">Ver Detalle</a>
                            <a href="index.php?controller=reservation&action=generatePDF&id=<?php echo $res['id']; ?>"
                                class="btn btn-primary btn-sm">Descargar PDF</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Mis Reservas";
include __DIR__ . '/../layouts/user_layout.php';
?>