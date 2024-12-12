<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $monto = $_POST['monto'];
    $fecha_inicio = $_POST['fecha_inicio'];

    // Cálculos
    $tasaInteres = 28;
    $interes = ($monto * $tasaInteres) / 100;
    $fecha_vencimiento = date('Y-m-d', strtotime($fecha_inicio . ' + 16 weeks'));

    // Insertar el préstamo en la base de datos
    $sql = "INSERT INTO prestamos (cliente_id, monto, plazo, tasa_interes, fecha_inicio, fecha_vencimiento, estado) 
            VALUES (?, ?, 16, ?, ?, ?, 'pendiente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iddss", $cliente_id, $monto, $tasaInteres, $fecha_inicio, $fecha_vencimiento);

    if ($stmt->execute()) {
        echo "Préstamo registrado con éxito.";
    } else {
        echo "Error al registrar el préstamo: " . $conn->error;
    }
}
?>
