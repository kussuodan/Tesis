<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $monto = $_POST['monto'];

    $sql = "INSERT INTO ahorros (cliente_id, monto) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $cliente_id, $monto);

    if ($stmt->execute()) {
        header("Location: gestionar_ahorros.php");
        exit;
    } else {
        echo "Error al registrar ahorro: " . $conn->error;
    }
}
?>
