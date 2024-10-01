<?php

class Conexion
{

    private $server = "localhost";
    private $user = "root";
    private $pass = "";
    private $dataBase = "ADSO810";
    public $connect;

    public function __construct()
    {
        try {
            $conexion = "mysql:host=" . $this->server . ";dbname=" . $this->dataBase . ";charset=utf8";
            $this->connect = new PDO($conexion, $this->user, $this->pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexion exitosa";
        } catch (PDOException $error) {
            echo "Error al conectar con la base de datos: " . $error->getMessage();
        }
    }
}
