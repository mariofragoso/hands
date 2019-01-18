<?php

/**
 * Created by PhpStorm.
 * User: mario
 * Date: 08/04/2018
 * Time: 01:59 PM
 */

class DatosModel
{

    private $connection;

    public function __construct()
    {
        $server = '127.0.0.1';
        $dataBase = 'handswithvoice';
        try {
            $this->connection = new PDO(
                "mysql:host=$server;dbname=$dataBase",
                "root", "", array(
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDatos($user_id) {

        $query = $this->connection->prepare("SELECT id, Nombre, Apellidos, Edad, Sexo FROM usuarios where Usuarios_id={'$user_id'");
        $query->execute();
        $registros = "[";
        while($result = $query->fetch()){
            if ($registros != "[") {
                $registros .= ",";
            }
            $registros .= '{"id": "'.$result["id"].'",';
            $registros .= '"nombre": "'.$result["Nombre"].'",';
            $registros .= '"apellidos": "'.$result["Apellidos"].'",';
            $registros .= '"edad": "'.$result["Edad"].'",';
            $registros .= '"sexo": "'.$result["Sexo"].'"}';
        }
        $registros .= "]";
        return $registros;

    }
}




?>


