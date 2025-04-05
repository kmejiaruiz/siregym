<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Realizar Reserva</h3>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form action="index.php?controller=reservation&action=create" method="POST">
            <!-- Se asume que el usuario ya est&aacute; logueado -->
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>" />
            <!-- Selecci&oacute;n del gimnasio (valor fijo para el ejemplo) -->
            <input type="hidden" name="gym_id" value="1" />
            <div class="form-group">
                <label for="reservation_date">Fecha</label>
                <input type="date" id="reservation_date" name="reservation_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reservation_time">Hora</label>
                <select id="reservation_time" name="reservation_time" class="form-control" required>
                    <option value="">Seleccione un horario</option>
                    <?php foreach ($slots as $slot): ?>
                        <option value="<?php echo $slot['slot_time']; ?>"><?php echo $slot['slot_time']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="voucher">Voucher</label>
                <input type="text" id="voucher" name="voucher" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Reservar</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Realizar Reserva";
include __DIR__ . '/../layouts/user_layout.php';
?>