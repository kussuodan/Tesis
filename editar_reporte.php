<?php
include 'conexion.php';

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contenido = $_POST['contenido'];

    $sql = "UPDATE reportes SET nombre = ?, contenido = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $contenido, $id);

    if ($stmt->execute()) {
        echo "Reporte actualizado exitosamente.";
    } else {
        echo "Error al actualizar el reporte: " . $conn->error;
    }
}

// Obtener datos actuales
$sql = "SELECT * FROM reportes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$reporte = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reporte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Reporte</h1>
        <form action="editar_reporte.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $reporte['id']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre del Reporte:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $reporte['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="10" required><?php echo $reporte['contenido']; ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Guardar</button>
                <button type="button" class="btn cancelar" onclick="location.href='ver_reportes.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
