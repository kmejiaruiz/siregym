<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Cupos para Fecha: <?php echo $limitData['reservation_date']; ?></h3>
    </div>
    <div class="card-body">
        <form method="POST" action="index.php?controller=admin&action=updateLimit">
            <input type="hidden" name="limit_id" value="<?php echo $limitData['id']; ?>">
            <div class="form-group">
                <label for="max_reservations">Numero Maximo de Reservaciones:</label>
                <input type="number" name="max_reservations" id="max_reservations" class="form-control" required min="1"
                    value="<?php echo $limitData['max_reservations']; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Editar Cupos";
include __DIR__ . '/../layouts/admin_layout.php';
?>