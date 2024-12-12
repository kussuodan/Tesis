<?php
include 'conexion.php';

// Consultar los ahorros de los clientes
$sql = "
    SELECT c.id, c.nombre, 
           COALESCE(SUM(a.monto), 0) AS total_ahorrado,
           COALESCE(SUM(a.monto) * 0.15, 0) AS interes_generado
    FROM clientes c
    LEFT JOIN ahorros a ON c.id = a.cliente_id
    GROUP BY c.id, c.nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ahorros</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Ahorros</h1>

        <!-- Formulario para registrar nuevos ahorros -->
        <h2>Registrar Ahorro</h2>
        <form action="registrar_ahorro.php" method="POST">
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php
                    $clientes = $conn->query("SELECT id, nombre FROM clientes");
                    while ($cliente = $clientes->fetch_assoc()) {
                        echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto del Ahorro:</label>
                <input type="number" id="monto" name="monto" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Registrar</button>
                <button onclick="location.href='index.php'" class="btn cancelar">Volver Atrás</button>
            </div>
        </form>

        <!-- Tabla para mostrar ahorros -->
        <h2>Clientes y Ahorros</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Monto Ahorrado</th>
                    <th>Interés Generado</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td>$<?php echo number_format($row['total_ahorrado'], 2); ?></td>
                            <td>$<?php echo number_format($row['interes_generado'], 2); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">No hay datos de ahorros registrados.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
