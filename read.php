<?php
require_once 'connect.php';

class ListarAprendices
{
    private $conexionDB;

    // Constructor para inicializar la conexión con la base de datos
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para obtener los datos de la tabla 'datos'
    public function obtenerRegistros()
    {
        try {
            $obtener = $this->conexionDB->connect->prepare("SELECT * FROM datos");
            $obtener->execute();
            return $obtener->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar errores y mostrar un mensaje
            echo "Error al obtener los registros: " . $e->getMessage();
            return []; // Retornar un array vacío en caso de error
        }
    }
}

// Creamos la instancia de la clase ListarAprendices
$mostrarRegistros = new ListarAprendices();
// Obtenemos los registros para mostrarlos en una tabla
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
