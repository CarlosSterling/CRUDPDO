<?php
require_once 'connect.php';

class RegistrarAprendiz
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    public function crearAprendiz($datos)
    {
        try {
            $stmt = $this->conexionDB->connect->prepare("INSERT INTO datos (nombres, apellidos, correo, telefono) VALUES (:nombres, :apellidos, :correo, :telefono)");
            $stmt->bindParam(':nombres', $datos['nombres'], PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
            $stmt->execute();

            header('Location: read.php?status=success');

            exit();
        } catch (PDOException $error) {
            echo "Error al registrar un nuevo aprendiz>" . $error->getMessage();
        }
    }
}

if (isset($_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['telefono'])) {
    $datos = [
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono']
    ];
    $nuevoAprendiz = new RegistrarAprendiz();
    $nuevoAprendiz->crearAprendiz($datos);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear aprendiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Registrar un nuevo aprendiz</h1>
    <!--<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <p style="color:green;">Aprendiz registrado con éxito.</p>
    <?php endif; ?>-->
    <form action="create.php" method="post">
        <label for="nombre">Nombre(s):</label>
        <input type="text" name="nombres" placeholder="Ingrese su nombre completo" required><br>
        <label for="apellido">Apellido(s):</label>
        <input type="text" name="apellidos" placeholder="Ingrese sus apellidos" required><br>
        <label for="correo">Email:</label>
        <input type="email" name="correo" placeholder="Ingrese su correo" required><br>
        <label for="telefono">Teléfono:</label>
        <input type="number" name="telefono" placeholder="Ingrese su número teléfonico"><br>

        <button type="submit">Guardar</button>
    </form>
    <br>
    <a href="read.php">Listar Aprendices</a>
</body>

</html>
