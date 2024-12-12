<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

include 'conexion.php';

// Generar contenido del reporte
$sql_prestamos = "SELECT COUNT(*) AS total_prestamos, SUM(monto) AS total_monto FROM prestamos";
$result_prestamos = $conn->query($sql_prestamos);
$prestamos = $result_prestamos->fetch_assoc();

$sql_ahorros = "SELECT SUM(monto) AS total_ahorros FROM ahorros";
$result_ahorros = $conn->query($sql_ahorros);
$ahorros = $result_ahorros->fetch_assoc();

$sql_morosos = "SELECT nombre FROM clientes WHERE estado = 'moroso'";
$result_morosos = $conn->query($sql_morosos);
$clientes_morosos = $result_morosos->fetch_all(MYSQLI_ASSOC);

// Crear contenido HTML
$html = "
<h1>Reporte Financiero</h1>
<h2>Resumen de Préstamos</h2>
<p><strong>Total de Préstamos Otorgados:</strong> {$prestamos['total_prestamos']}</p>
<p><strong>Total en Monto de Préstamos:</strong> $".number_format($prestamos['total_monto'], 2)."</p>

<h2>Total de Ahorros</h2>
<p><strong>Monto Total en Ahorros:</strong> $".number_format($ahorros['total_ahorros'], 2)."</p>

<h2>Clientes Morosos</h2>";

if (!empty($clientes_morosos)) {
    $html .= "<ul>";
    foreach ($clientes_morosos as $moroso) {
        $html .= "<li>{$moroso['nombre']}</li>";
    }
    $html .= "</ul>";
} else {
    $html .= "<p>No hay clientes morosos actualmente.</p>";
}

// Crear el PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Reporte_Financiero.pdf", ["Attachment" => false]);
?>
