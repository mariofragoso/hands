<?php
$servername = "localhost";
$username = "root";
$password = "";
$response = [
    'success' => false,
    'error' => ''
];
try {
    $conn = new PDO("mysql:host=$servername;dbname=handswithvoice", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    $sql= "SELECT * FROM usuarios where Usuarios_id = 1";
    $response['user_data'] = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if (count($response['user_data']) > 0) {
        $response['success'] = true;
        echo json_encode($response['user_data']);
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}





