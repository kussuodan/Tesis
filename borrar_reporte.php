<?php
include 'conexion.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM reportes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Reporte eliminado exitosamente.";
    } else {
        echo "Error al eliminar el reporte: " . $conn->error;
    }
}
header("Location: ver_reportes.php");
?>
