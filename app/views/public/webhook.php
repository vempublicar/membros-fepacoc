<?php
include "app/functions/push/upWebHook.php";  // Ensure the path is correct based on your folder structure

$data = file_get_contents("php://input");
file_put_contents('webhook_log.txt', $data, FILE_APPEND);
$event = json_decode($data, true);

if ($event) {
    $result = handlePagarMeWebhook($event);
    echo json_encode(['status' => 'success', 'message' => 'Webhook processed successfully', 'result' => $result]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid webhook data']);
}
?>