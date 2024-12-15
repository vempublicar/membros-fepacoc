<?php
header('Content-Type: application/json');
session_start();

// Verifica o token enviado pelo navegador
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['token']) && in_array($data['token'], $_SESSION['valid_tokens'] ?? [])) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Token inválido']);
}
?>