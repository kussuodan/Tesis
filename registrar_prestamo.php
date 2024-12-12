<?php
include 'conexion.php';

// Consulta para obtener los clientes
$sql = "SELECT id, nombre FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Préstamo</title>
    <link rel="stylesheet" href="style_alineado.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Préstamo</h1>
        <form action="procesar_prestamo.php" method="POST">
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hay clientes registrados</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto del Préstamo:</label>
                <input type="number" id="monto" name="monto" required>
            </div>
            <div class="form-group">
                <label for="tasa">Tasa de Interés:</label>
                <input type="number" id="tasa" name="tasa" value="28" readonly>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Guardar</button>
                <button type="button" class="btn cancelar" onclick="location.href='index.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
