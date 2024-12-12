<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contenido = $_POST['contenido'];

    $sql = "INSERT INTO reportes (nombre, contenido) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $contenido);

    if ($stmt->execute()) {
        echo "Reporte creado exitosamente.";
    } else {
        echo "Error al crear el reporte: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reporte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Reporte</h1>
        <form action="crear_reporte.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Reporte:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="10" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Guardar</button>
                <button type="button" class="btn cancelar" onclick="location.href='ver_reportes.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
