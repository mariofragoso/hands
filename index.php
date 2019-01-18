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
    'IS_NOT_POST' => 'No es una petición aceptable',
    'OPTION_ERROR' => 'NO es una opción valida',
    'VARS_EMPTY' => 'Datos incompletos',
    'EMPTY_USER' => 'Usuario no encontrado'
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
            case 'login':

                if (empty($request['user_email']) || empty($request['user_password'])) {
                    throw new Exception($errors['VARS_EMPTY']);
                }

                $user = $request['user_email'];
                $password = $request['user_password'];

                $model = new UsersModel();
                $user = $model->getUser($user, $password);

                if ($user['success']) {
                    $response['success'] = true;
                    $response['user'] = $user;
                    echo json_encode($response); die();
                } else {
                    throw new Exception($errors['EMPTY_USER']);
                }
            break;
            default:
                throw new Exception($errors['OPTION_ERROR']);
            break;
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    } finally {
        echo json_encode($response);
        die();
    }


} else {
    $response['error'] = $errors['IS_NOT_POST'];
    echo json_encode($response);
    die();
}