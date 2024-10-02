<?php
require_once 'connect.php';

class EliminarAprendiz
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }
    public function eliminarAprendizPorId($id)
    {
        try {
            $stmt = $this->conexionDB->connect->prepare("DELETE FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
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
    $eliminarRegistro = new EliminarAprendiz();
    $eliminarRegistro->eliminarAprendizPorId($id);
} else {
    echo "ID inválido.";
    header("Location: read.php");
    exit();
}
