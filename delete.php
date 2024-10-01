<?php
require_once 'connect.php';

class EliminarAprendiz
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para eliminar un registro por ID
    public function eliminarAprendizPorId($id)
    {
        try {
            $stmt = $this->conexionDB->connect->prepare("DELETE FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirigir con éxito después de eliminar
            header('Location: read.php?status=deleted');
            exit();
        } catch (PDOException $error) {
            echo "Error al eliminar el aprendiz: " . $error->getMessage();
        }
    }
}

// Verificar si se recibe un ID por GET para eliminar
//if (isset($_GET['id']) && is_numeric($_GET['id'])) {
//   $id = (int)$_GET['id'];
if ($_GET['id']) {
    $id = $_GET['id'];

    // Crear instancia de la clase EliminarAprendiz y eliminar el registro
    $eliminarRegistro = new EliminarAprendiz();
    $eliminarRegistro->eliminarAprendizPorId($id);
} else {
    echo "ID inválido.";
    header("Location: read.php");
    exit();
}
