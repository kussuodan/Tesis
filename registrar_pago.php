<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $prestamo_id = $_POST['prestamo_id'];
    $monto_pago = $_POST['monto_pago'];

    // Verificar si el préstamo existe
    $sql_verificar = "SELECT id FROM prestamos WHERE id = ? AND cliente_id = ?";
    $stmt_verificar = $conn->prepare($sql_verificar);
    $stmt_verificar->bind_param("ii", $prestamo_id, $cliente_id);
    $stmt_verificar->execute();
    $result_verificar = $stmt_verificar->get_result();

    if ($result_verificar->num_rows == 0) {
        die("Error: El préstamo no existe o no está relacionado con el cliente seleccionado.");
    }

    // Insertar el pago
    $sql = "INSERT INTO pagos (cliente_id, prestamo_id, monto_pago) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $cliente_id, $prestamo_id, $monto_pago);

    if ($stmt->execute()) {
        header("Location: registrar_pagos.php");
        exit;
    } else {
        echo "Error al registrar el pago: " . $conn->error;
    }
}
?>
