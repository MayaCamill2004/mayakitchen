<?php

//use this for security, tokens etc
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../core/initialize.php');

//create instance of user 
$user = new User($db);



$data = json_decode(file_get_contents('php://input'));

$user->username = $data->username;
$user->email = $data->email;
$user->password= $data->password;

if($user->create()){
    echo json_encode(array('message' => 'User created.'));
}
else{
    echo json_encode(array('message' => 'User not created.'));
}