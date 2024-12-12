<?php
include 'conexion.php';

// Obtener todos los clientes
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);

// Función para determinar si un cliente es moroso
function esMoroso($estado) {
    return $estado === 'moroso';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Clientes</h1>

        <!-- Formulario para registrar nuevos clientes -->
        <h2>Registrar Nuevo Cliente</h2>
        <form action="registrar_cliente.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="activo">Activo</option>
                    <option value="moroso">Moroso</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn guardar">Registrar</button>
                <button type="button" class="btn cancelar" onclick="location.href='index.php'">Cancelar</button>
            </div>
        </form>

        <!-- Tabla para listar clientes -->
        <h2>Clientes Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="<?php echo esMoroso($row['estado']) ? 'moroso' : ''; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td><?php echo $row['direccion']; ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?php echo $row['id']; ?>" class="btn">Editar</a>
                                <a href="eliminar_cliente.php?id=<?php echo $row['id']; ?>" class="btn cancelar" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">No hay clientes registrados.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
