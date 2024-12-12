<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); // Redirige al login si no hay sesión activa
    exit;
}



// Mostrar el nombre del usuario
echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "!";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Pantalla de inicio</h1>
        <div class="menu-navegacion">
    <button onclick="location.href='registrar_prestamo.php'" class="btn">Registrar Préstamo</button>
    <button onclick="location.href='ver_reportes.php'" class="btn">Ver Reportes</button>
    <button onclick="location.href='gestionar_clientes.php'" class="btn">Gestionar Clientes</button>
    <button onclick="location.href='gestionar_ahorros.php'" class="btn">Gestionar Ahorros</button> 
    <button onclick="location.href='registrar_pagos.php'" class="btn">Registrar Pagos</button>
    <a href="logout.php">Cerrar Sesión</a>

</div>
</body>
</html>
