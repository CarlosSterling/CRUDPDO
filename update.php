<?php
require_once 'connect.php';

class ActualizarAprendiz
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para obtener los datos de un aprendiz por ID
    public function obtenerAprendizPorId($id)
    {
        try {
            $stmt = $this->conexionDB->connect->prepare("SELECT * FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error al obtener el aprendiz: " . $error->getMessage();
        }
    }

    // Método para actualizar los datos de un aprendiz
    public function actualizarAprendiz($datos)
    {
        try {
            $stmt = $this->conexionDB->connect->prepare("UPDATE datos SET nombres = :nombres, apellidos = :apellidos, correo = :correo, telefono = :telefono WHERE id = :id");
            $stmt->bindParam(':nombres', $datos['nombres'], PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $datos['id'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: read.php?status=updated');

            exit();
        } catch (PDOException $error) {
            echo "Error al actualizar el aprendiz: " . $error->getMessage();
        }
    }
}

// Verificar si se recibe un ID por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Instancia de la clase para obtener y actualizar aprendiz
    $actualizarAprendiz = new ActualizarAprendiz();
    $datosAprendiz = $actualizarAprendiz->obtenerAprendizPorId($id);
}

// Verificar si se envían los datos por POST para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $datos = [
        'id' => $_POST['id'],
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono']
    ];

    // Llamar al método para actualizar los datos del aprendiz
    $actualizarAprendiz->actualizarAprendiz($datos);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar aprendiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Actualizar aprendiz</h1>

    <?php if (isset($datosAprendiz) && !empty($datosAprendiz)): ?>
        <form action="update.php?id=<?php echo htmlspecialchars($datosAprendiz['id']); ?>" method="post">
            <!-- Campo oculto para enviar el ID del aprendiz -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($datosAprendiz['id']); ?>">

            <label for="nombres">Nombre(s):</label>
            <input type="text" name="nombres" value="<?php echo htmlspecialchars($datosAprendiz['nombres']); ?>" placeholder="Ingrese su nombre completo" required><br>

            <label for="apellidos">Apellido(s):</label>
            <input type="text" name="apellidos" value="<?php echo htmlspecialchars($datosAprendiz['apellidos']); ?>" placeholder="Ingrese sus apellidos" required><br>

            <label for="correo">Email:</label>
            <input type="email" name="correo" value="<?php echo htmlspecialchars($datosAprendiz['correo']); ?>" placeholder="Ingrese su correo" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($datosAprendiz['telefono']); ?>" placeholder="Ingrese su número teléfonico"><br>

            <button type="submit">Actualizar</button>
        </form>
    <?php else: ?>
        <p>No se encontraron datos del aprendiz para actualizar.</p>
    <?php endif; ?>
    <br>
    <a href="read.php">Listar Aprendices</a>
</body>

</html>
