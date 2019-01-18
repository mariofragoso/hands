<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 08/04/2018
 * Time: 01:59 PM
 */

class UsersModel {

    private $connection;

    public function __construct () {
        $server = '127.0.0.1';
        $dataBase = 'handswithvoice';
        try {
            $this->connection = new PDO(
                "mysql:host=$server;dbname=$dataBase",
                "root", "", array(
                PDO::ATTR_PERSISTENT         => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUser($user, $password) {
        $response = [
            'success' => false,
            'error' => ''
        ];
        try {
            $query = "SELECT * FROM usuarios where Correo_electronico = '{$user}' AND Contrasena = '{$password}'";
            $response['user_data'] = $this->connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
            if (count($response['user_data']) > 0) {
                $response['success'] = true;
            }
        }  catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
        return $response;
    }
    public function getRegister($nombre,$apellidos,$edad,$sexo,$user,$correo,$contra) {
        $response = [
            'success' => false,
            'error' => ''
        ];
        $tipo="Principal";
        $id=0;
        try {
            $query = "INSERT INTO usuarios (Nombre,Apellidos,Edad,Sexo,Usuario,Correo_electronico,Contrasena,
          Tipos_de_usuario, Usuarios_id)values ('{$nombre}','{$apellidos}','{$edad}','{$sexo}','{$user}','{$correo}','{$contra}',
          '{$tipo}','{$id}')";
            if ($this->connection->query($query) === TRUE){
                echo "Connected successfully";
            }
        }  catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }
    public function getDependiente($nombre,$apellidos,$edad,$sexo,$id) {
        $response = [
            'success' => false,
            'error' => ''
        ];
        $tipo="Dependiente";
        try {
            $query = "INSERT INTO usuarios (Nombre,Apellidos,Edad,Sexo,
Tipos_de_usuario, Usuarios_id)values ('{$nombre}','{$apellidos}','{$edad}','{$sexo}','{$tipo}','{$id}')";
            if ($this->connection->query($query) === TRUE){
                echo "Connected successfully";
            }
        }  catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }
    public function getPrincipal($nombre,$apellidos,$edad,$sexo,$user,$correo,$contra,$id) {
        $response = [
            'success' => false,
            'error' => ''
        ];

        try {
            $query = "UPDATE usuarios SET Nombre= '{$nombre}', Apellidos='{$apellidos}',Edad='{$edad}',Sexo='{$sexo}',Usuario='{$user}',
             Correo_electronico='{$correo}', Contrasena='{$contra}' where id= '{$id}' ";
            if ($this->connection->query($query) === TRUE){
                echo "Connected successfully";
            }
        }  catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function acDependiente($nombre,$apellidos,$edad,$sexo,$id) {
        $response = [
            'success' => false,
            'error' => ''
        ];

        try {
            $query = "UPDATE usuarios SET Nombre= '{$nombre}', Apellidos='{$apellidos}',Edad='{$edad}',Sexo='{$sexo}'
           where id= '{$id}' ";
            if ($this->connection->query($query) === TRUE){
                echo "Connected successfully";
            }
        }  catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }
    public function setCampos($campo,$id) {
        $response = [
            'success' => false,
            'error' => ''
        ];

        try {
            $query = "INSERT INTO campo_semantico_has_usuarios value ('{$campo}','{$id}')";
            if ($this->connection->query($query) === TRUE){
                echo "Connected successfully";
            }
        }  catch (Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }

}