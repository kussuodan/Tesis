<?php
include 'conexion.php';

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID de cliente no proporcionado.");
}

$id = (int) $_GET['id']; // Asegurarse de que sea un entero

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Actualizar el cliente en la base de datos
    $sql = "UPDATE clientes SET nombre = ?, telefono = ?, direccion = ?, estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $telefono, $direccion, $estado, $id);

    if ($stmt->execute()) {
        header("Location: gestionar_clientes.php");
        exit;
    } else {
        echo "Error al actualizar cliente: " . $conn->error;
    }
} else {
    // Obtener los datos del cliente para mostrarlos en el formulario
    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if (!$cliente) {
        die("Error: Cliente no encontrado.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>
        <form action="editar_cliente.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cliente['direccion']); ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="activo" <?php echo $cliente['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
                    <option value="moroso" <?php echo $cliente['estado'] === 'moroso' ? 'selected' : ''; ?>>Moroso</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Guardar Cambios</button>
                <button type="button" class="btn cancelar" onclick="location.href='gestionar_clientes.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>

