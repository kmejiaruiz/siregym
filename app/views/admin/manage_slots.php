<?php
ob_start();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestionar Horarios y Cupos de Reservaciones</h3>
    </div>
    <div class="card-body">
        <!-- Mensajes de \u00e9xito y error -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Secci\u00f3n de Gesti\u00f3n de Horarios -->
        <h4>Gesti\u00f3n de Horarios Disponibles</h4>
        <form method="POST" action="index.php?controller=admin&action=manageSlots">
            <div class="form-group">
                <label for="new_slot">Agregar Nuevo Horario (Formato HH:MM)</label>
                <input type="time" name="new_slot" id="new_slot" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Agregar Horario</button>
        </form>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hora</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slots as $slot): ?>
                    <tr>
                        <td><?php echo $slot['id']; ?></td>
                        <td>
                            <?php if (isset($_GET['edit_slot']) && $_GET['edit_slot'] == $slot['id']): ?>
                                <form method="POST" action="index.php?controller=admin&action=editSlot">
                                    <input type="hidden" name="slot_id" value="<?php echo $slot['id']; ?>">
                                    <input type="time" name="new_slot_time" value="<?php echo $slot['slot_time']; ?>" required>
                                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                </form>
                            <?php else: ?>
                                <?php echo $slot['slot_time']; ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $slot['is_available'] ? 'Disponible' : 'No Disponible'; ?></td>
                        <td>
                            <?php if (!(isset($_GET['edit_slot']) && $_GET['edit_slot'] == $slot['id'])): ?>
                                <a href="index.php?controller=admin&action=manageSlots&edit_slot=<?php echo $slot['id']; ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                            <?php endif; ?>
                            <a href="index.php?controller=admin&action=toggleSlot&slot_id=<?php echo $slot['id']; ?>"
                                class="btn btn-info btn-sm">
                                <?php echo $slot['is_available'] ? 'Deshabilitar' : 'Habilitar'; ?>
                            </a>
                            <a href="index.php?controller=admin&action=manageSlots&delete_slot=<?php echo $slot['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar este horario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <!-- Secci\u00f3n de Configuraci\u00f3n de Cupos -->
        <h4>Configurar Cupos Disponibles por Fecha</h4>
        <form method="POST" action="index.php?controller=admin&action=manageSlots">
            <div class="form-group">
                <label for="limit_date">Fecha:</label>
                <input type="date" name="limit_date" id="limit_date" class="form-control" required
                    value="<?php echo isset($_GET['limit_date']) ? htmlspecialchars($_GET['limit_date']) : ''; ?>">
            </div>
            <div class="form-group mt-2">
                <label for="max_reservations">N\u00famero M\u00e1ximo de Reservaciones:</label>
                <input type="number" name="max_reservations" id="max_reservations" class="form-control" required min="1"
                    value="<?php echo (isset($current_limit) && $current_limit) ? $current_limit['max_reservations'] : 10; ?>">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar Limite</button>
        </form>

        <hr>

        <h4>Lista de Cupos Configurados</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>L\u00edmite</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($limits)): ?>
                    <?php foreach ($limits as $limit): ?>
                        <tr>
                            <td><?php echo $limit['id']; ?></td>
                            <td><?php echo $limit['reservation_date']; ?></td>
                            <td><?php echo $limit['max_reservations']; ?></td>
                            <td>
                                <a href="index.php?controller=admin&action=editLimit&limit_id=<?php echo $limit['id']; ?>"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?controller=admin&action=deleteLimit&limit_id=<?php echo $limit['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este l\u00edmite?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan=\"4\">No se han configurado cupos para ninguna fecha.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
<?php
$content = ob_get_clean();
$title = "Gestionar Horarios y Cupos";
include __DIR__ . '/../layouts/admin_layout.php';
?>