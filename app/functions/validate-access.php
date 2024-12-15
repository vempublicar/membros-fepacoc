<?php
header('Content-Type: application/json');
session_start();

// Substitua pela sua senha segura
define('ADMIN_PASSWORD', 'chapisco251251');

// Função para gerar um token simples
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password']) && $data['password'] === ADMIN_PASSWORD) {
    // Gera o token e salva no servidor (em sessão ou banco de dados)
    $token = generateToken();
    $_SESSION['valid_tokens'][] = $token;

    echo json_encode(['status' => 'success', 'token' => $token]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Senha inválida']);
}
?>