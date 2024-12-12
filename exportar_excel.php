<?php
// Configurar las cabeceras para exportar como Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Financiero.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Agregar BOM para codificación UTF-8
echo "\xEF\xBB\xBF";

// Incluir la conexión a la base de datos
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

// Inicia la salida del contenido en formato HTML para Excel
echo "<table border='1'>";

// Encabezado principal del reporte
echo "<tr><th colspan='2' style='font-size:18px; background-color:#d9edf7; text-align:center;'>Reporte Financiero</th></tr>";

// Sección: Resumen de Préstamos
echo "<tr><th colspan='2' style='font-size:16px; background-color:#f2f2f2;'>Resumen de Préstamos</th></tr>";
echo "<tr><td>Total de Préstamos Otorgados</td><td style='text-align:right;'>" . $prestamos['total_prestamos'] . "</td></tr>";
echo "<tr><td>Total en Monto de Préstamos</td><td style='text-align:right;'>$" . number_format($prestamos['total_monto'], 2, '.', ',') . "</td></tr>";

// Sección: Total de Ahorros
echo "<tr><th colspan='2' style='font-size:16px; background-color:#f2f2f2;'>Total de Ahorros</th></tr>";
echo "<tr><td>Monto Total en Ahorros</td><td style='text-align:right;'>$" . number_format($ahorros['total_ahorros'], 2, '.', ',') . "</td></tr>";

// Sección: Clientes Morosos
echo "<tr><th colspan='2' style='font-size:16px; background-color:#f2f2f2;'>Clientes Morosos</th></tr>";
if (!empty($clientes_morosos)) {
    foreach ($clientes_morosos as $moroso) {
        echo "<tr><td colspan='2'>" . htmlspecialchars($moroso['nombre']) . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='2' style='text-align:center;'>No hay clientes morosos</td></tr>";
}

// Fin de la tabla
echo "</table>";
?>
