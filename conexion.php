<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Sin contraseña por defecto
$database = 'fyrcobranza';
$port = 3310; // Cambia según tu configuración

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
