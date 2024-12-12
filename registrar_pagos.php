<?php
include 'conexion.php'; // Asegúrate de que este archivo esté correctamente configurado

if (!$conn) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Consultar clientes
$clientes = $conn->query("SELECT id, nombre FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de incluir tus estilos aquí -->
    <script>
        // Función para cargar préstamos dinámicamente al seleccionar un cliente
        function cargarPrestamos(clienteId) {
            if (clienteId) {
                fetch(`cargar_prestamos.php?cliente_id=${clienteId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('prestamo_id').innerHTML = data;
                    });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Gestión de Pagos</h1>

        <!-- Formulario para registrar pagos -->
        <h2>Registrar Pago</h2>
        <form action="registrar_pago.php" method="POST">
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id" required onchange="cargarPrestamos(this.value)">
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php
                    while ($cliente = $clientes->fetch_assoc()) {
                        echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prestamo_id">Préstamo:</label>
                <select id="prestamo_id" name="prestamo_id" required>
                    <option value="" disabled selected>Selecciona un préstamo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="monto_pago">Monto del Pago:</label>
                <input type="number" id="monto_pago" name="monto_pago" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Registrar</button>
                <button onclick="location.href='index.php'" class="btn cancelar">Volver Atrás</button>
            </div>
        </form>

        <!-- Tabla para mostrar los pagos -->
        <h2>Clientes y Pagos</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Monto del Préstamo</th>
                    <th>Total Pagado</th>
                    <th>Saldo Pendiente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
                    SELECT c.nombre, pr.monto AS monto_prestamo, 
                           COALESCE(SUM(p.monto_pago), 0) AS total_pagado, 
                           (pr.monto - COALESCE(SUM(p.monto_pago), 0)) AS saldo_pendiente
                    FROM clientes c
                    LEFT JOIN prestamos pr ON c.id = pr.cliente_id AND pr.estado = 'pendiente'
                    LEFT JOIN pagos p ON pr.id = p.prestamo_id
                    GROUP BY c.id, pr.id";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>$" . number_format($row['monto_prestamo'], 2) . "</td>
                                <td>$" . number_format($row['total_pagado'], 2) . "</td>
                                <td>$" . number_format($row['saldo_pendiente'], 2) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
