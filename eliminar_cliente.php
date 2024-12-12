<?php
include 'conexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: gestionar_clientes.php");
} else {
    echo "Error al eliminar cliente: " . $conn->error;
}
?>
