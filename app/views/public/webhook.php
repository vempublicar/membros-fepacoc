<?php
include "app/functions/push/upWebHook.php";  // Ensure the path is correct based on your folder structure

function logData($message) {
    file_put_contents('webhook_errors.log', $message, FILE_APPEND);
}

$data = file_get_contents("php://input");
logData("Received: " . $data . "\n");

$json = json_decode($data, true);

try {
    if ($json) {
        // Suponha que você tem uma função para salvar os dados
        $result = saveToDatabase($json['data']);
        if ($result === true) {
            logData("Data saved successfully\n");
        } else {
            logData("Failed to save data: " . $result . "\n");
        }
    } else {
        throw new Exception("Invalid JSON data");
    }
} catch (Exception $e) {
    logData("Error: " . $e->getMessage() . "\n");
}
?>