<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contraseña = $_POST['contraseña'];

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verifica la contraseña
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Configurar la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirigir a index.php
            header("Location: index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>
