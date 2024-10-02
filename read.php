<?php
require_once 'connect.php';

class ListarAprendices
{
    private $conexionDB;
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }
    public function obtenerRegistros()
    {
        try {
            $obtener = $this->conexionDB->connect->prepare("SELECT * FROM datos");
            $obtener->execute();
            return $obtener->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los registros: " . $e->getMessage();
            return [];
        }
    }
}
$mostrarRegistros = new ListarAprendices();
$datos = $mostrarRegistros->obtenerRegistros();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Aprendices</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Aprendices registrados</h1>

    <a href="create.php">Crear nuevo registro</a>
    <table border="0.5">
        <tr>
            <th>ID</th>
            <th>Nombre(s)</th>
            <th>Apellidos(s)</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($datos)): ?>
            <?php foreach ($datos as $dato): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dato['id']); ?></td>
                    <td><?php echo htmlspecialchars($dato['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($dato['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($dato['correo']); ?></td>
                    <td><?php echo htmlspecialchars($dato['telefono']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $dato['id']; ?>">Editar</a>
                        <a href="delete.php?id=<?php echo $dato['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No se encontraron registros.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
</body>

</html>
