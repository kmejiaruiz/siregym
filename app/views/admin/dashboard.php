<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dashboard Administrativo</h3>
    </div>
    <div class="card-body">
        <h4>Alertas</h4>
        <?php if (empty($alerts)): ?>
            <p>No hay alertas.</p>
        <?php else: ?>
            <ul class="list-group mb-4">
                <?php foreach ($alerts as $alert): ?>
                    <li class="list-group-item">
                        <?php echo $alert['message']; ?>
                        <small>(<?php echo $alert['created_at']; ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h4>Reservas</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Usuario</th>
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
                        <!-- <td><?php echo $res['username']; ?></td> -->
                         <td>---</td>
                        <td><?php echo $res['status']; ?></td>
                        <td>
                            <form action="index.php?controller=admin&action=updateStatus" method="POST" class="status-form"
                                style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $res['id']; ?>">

                                <select name="status" class="form-select form-select-sm status-select"
                                    style="width: auto; display:inline-block;"
                                    data-reservation-id="<?php echo $res['id']; ?>" <?php if (in_array($res['status'], ['confirmada', 'cerrada', 'cancelada']))
                                           echo 'disabled'; ?>>
                                    <option value="confirmada" <?php if ($res['status'] == 'confirmada')
                                        echo 'selected'; ?>>
                                        Confirmada</option>
                                    <option value="cerrada" <?php if ($res['status'] == 'cerrada')
                                        echo 'selected'; ?>>Cerrada
                                    </option>
                                    <option value="cancelada" <?php if ($res['status'] == 'cancelada')
                                        echo 'selected'; ?>>
                                        Cancelada</option>
                                </select>

                                <button type="submit" class="btn btn-warning btn-sm status-btn"
                                    data-reservation-id="<?php echo $res['id']; ?>" <?php if (in_array($res['status'], ['confirmada', 'cerrada', 'cancelada']))
                                           echo 'disabled'; ?>>
                                    Actualizar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Confirmar Cambio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>Estás a punto de cambiar el estado de la reserva a: <strong id="selectedStatus"></strong></p>
                <p>Solo puedes cambiar el estado de la reserva una vez. ¿Estás seguro de continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmChange">Sí, cambiar estado</button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectedForm;
        let selectedButton;
        let selectedSelect;

        document.querySelectorAll(".status-btn").forEach(button => {
            button.addEventListener("click", function (event) {
                let reservationId = this.getAttribute("data-reservation-id");
                selectedForm = this.closest("form");
                selectedButton = this;
                selectedSelect = document.querySelector(`select[data-reservation-id='${reservationId}']`);

                let newStatus = selectedSelect.value; // Obtiene el estado seleccionado
                document.getElementById("selectedStatus").textContent = newStatus; // Lo inserta en el modal

                // Si ya tiene un estado final, muestra el modal antes de enviar el formulario
                let currentStatus = selectedSelect.value;
                if (["confirmada", "cerrada", "cancelada"].includes(currentStatus)) {
                    event.preventDefault(); // Evita el envío inmediato
                    let modal = new bootstrap.Modal(document.getElementById("confirmationModal"));
                    modal.show();
                }
            });
        });

        document.getElementById("confirmChange").addEventListener("click", function () {
            if (selectedForm) {
                selectedForm.submit(); // Envía el formulario
                selectedButton.disabled = true; // Deshabilita el botón después del cambio
                selectedSelect.disabled = true; // Deshabilita el select después del cambio
            }
        });
    });
</script>
<?php
$content = ob_get_clean();
$title = "Dashboard Admin";
include __DIR__ . '/../layouts/admin_layout.php';
?>