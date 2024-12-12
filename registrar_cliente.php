<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO clientes (nombre, telefono, direccion, estado) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $telefono, $direccion, $estado);

    if ($stmt->execute()) {
        header("Location: gestionar_clientes.php");
    } else {
        echo "Error al registrar cliente: " . $conn->error;
    }
}
?>
