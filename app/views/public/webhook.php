<?php
include "app/functions/push/upWebHook.php";  // Verifique se o caminho está correto

function logData($message) {
    file_put_contents('webhook_errors.log', $message, FILE_APPEND);
}

$data = file_get_contents("php://input");
logData("Received: " . $data . "\n");

$json = json_decode($data, true);
logData('Json: ' . print_r($json, true) . "\n");
$result = handlePagarMeWebhook($json);  // Ajuste para chamar a função correta
logData('Resposta: ' . print_r($result, true) . "\n");


?>