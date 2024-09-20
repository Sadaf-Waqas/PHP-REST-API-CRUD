<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control, Authorization, X-Requested-With");

require('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {

    $deleteCustomer = deleteCustomer($_GET);
    echo $deleteCustomer;
} else {
    $data = [
        'status' => 405,
        'msg' => $requestMethod . "Request method not allowed",
    ];
    header("HTTP/1.1 405 Request method not allowed");
    echo json_encode($data);
}