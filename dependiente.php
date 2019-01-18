<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 08/04/2018
 * Time: 01:18 PM
 */

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        
        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
require_once 'UsersModel.php';



$errors = [

    'EMPTY_USER' => 'No se realizo el registro',
    'VARS_EMPTY' => 'Datos incompletos',
];

$response = [
    'success' => false,
    'error' => ''
];

$request = file_get_contents("php://input");
$request = json_decode($request, true);
if (count($request) > 0 ) {
    $option = $request['option'];
    try {
        switch ($option) {
            case 'dependiente':

                $nombre= $request['user_name'];
                $apellidos = $request['user_lastname'];
                $edad = $request['user_age'];
                $sexo = $request['user_sexo'];
                $id= $request['user_id'];

                $model = new UsersModel();
                $user = $model->getDependiente($nombre,$apellidos,$edad,$sexo,$id);
                if(!$user){
                    throw new Exception($errors['EMPTY_USER']);
                }
                else{
                    $response['success']=true;
                    echo json_encode($response); die();

                }
                break;

        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    } finally {
        echo json_encode($response);
        die();
    }


}