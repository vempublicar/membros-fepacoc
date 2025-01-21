<?php
include "app/functions/push/upWebHook.php";  // Ensure the path is correct based on your folder structure

function logData($message) {
    file_put_contents('webhook_errors.log', $message, FILE_APPEND);
}

$data = file_get_contents("php://input");
logData("Received: " . $data . "\n");

$json = json_decode($data, true);
$result = saveToDatabase($json['data']);
logData('resposta:'.$result);

?>