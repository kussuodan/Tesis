<?php
include 'conexion.php';

// Consultas para generar el reporte
$sql_prestamos = "SELECT COUNT(*) AS total_prestamos, SUM(monto) AS total_monto FROM prestamos";
$result_prestamos = $conn->query($sql_prestamos);
$prestamos = $result_prestamos->fetch_assoc();

$sql_ahorros = "SELECT SUM(monto) AS total_ahorros FROM ahorros";
$result_ahorros = $conn->query($sql_ahorros);
$ahorros = $result_ahorros->fetch_assoc();

$sql_morosos = "SELECT nombre FROM clientes WHERE estado = 'moroso'";
$result_morosos = $conn->query($sql_morosos);
$clientes_morosos = $result_morosos->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reportes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Reportes Generados</h1>

        <div class="report">
            <h2>Resumen de Préstamos</h2>
            <p><strong>Total de Préstamos Otorgados:</strong> <?php echo $prestamos['total_prestamos']; ?></p>
            <p><strong>Total en Monto de Préstamos:</strong> $<?php echo number_format($prestamos['total_monto'], 2); ?></p>
        </div>

        <div class="report">
            <h2>Total de Ahorros</h2>
            <p><strong>Monto Total en Ahorros:</strong> $<?php echo number_format($ahorros['total_ahorros'], 2); ?></p>
        </div>

        <div class="report">
            <h2>Clientes Morosos</h2>
            <?php if (!empty($clientes_morosos)) { ?>
                <ul>
                    <?php foreach ($clientes_morosos as $moroso) { ?>
                        <li><?php echo $moroso['nombre']; ?></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No hay clientes morosos actualmente.</p>
            <?php } ?>
        </div>

        <div class="form-actions">
            <button onclick="location.href='exportar_excel.php'" class="btn guardar">Exportar a Excel</button>
            <button onclick="location.href='index.php'" class="btn cancelar">Volver Atrás</button>
        </div>
    </div>
</body>
</html>
