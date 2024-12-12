<?php
include 'conexion.php';

if (isset($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']);

    // Consulta para obtener los préstamos del cliente seleccionado
    $result = $conn->query("SELECT id, monto FROM prestamos WHERE cliente_id = $cliente_id AND estado = 'pendiente'");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>Préstamo #{$row['id']} - $ {$row['monto']}</option>";
        }
    } else {
        echo "<option value=''>No hay préstamos pendientes</option>";
    }
}
?>
