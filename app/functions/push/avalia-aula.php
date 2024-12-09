<?php
session_start();
include "../../config/supabase/supabase_config.php";

// Função para enviar requisições cURL ao Supabase
function sendSupabaseRequest($method, $endpoint, $data = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    $headers = [
        "Content-Type: application/json",
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
    ]);

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return ['status' => 'error', 'message' => $error];
    }

    return ['status' => 'success', 'http_code' => $httpCode, 'response' => json_decode($response, true)];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Coletar dados do formulário
        $contentId = $_POST['videoId'] ?? null;
        $userEmail = $_POST['userEmail'] ?? null;
        $reviewText = $_POST['reviewText'] ?? null;
        $rating = $_POST['rating'] ?? null;

        // Validar os dados obrigatórios
        if (!$contentId || !$userEmail || !$reviewText || !$rating) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        // Preparar os dados para inserção
        $data = [
            'conteudo' => $contentId,
            'user' => $userEmail,
            'text' => $reviewText,
            'nota' => (int)$rating,
        ];

        // Enviar os dados para o Supabase
        $response = sendSupabaseRequest('POST', 'avaliador', $data);

        // Verificar a resposta do Supabase
        if ($response['status'] === 'success' && $response['http_code'] === 201) {
            // Redirecionar de volta com sucesso
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#success");
            exit;
        } else {
            // Redirecionar de volta com erro
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#error");
            exit;
        }
    } catch (Exception $e) {
        // Retornar mensagem de erro
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido']);
}
