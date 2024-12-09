<?php
session_start();
include "../../config/supabase/supabase_config.php";

// Função para enviar requisições ao Supabase
function sendSupabaseRequest($method, $endpoint, $data = null)
{
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
        // Coletar os dados enviados via POST
        $rawPostData = file_get_contents('php://input');
        $postData = json_decode($rawPostData, true);

        $title = $postData['title'] ?? null;
        $email = $postData['email'] ?? null;
        $date = $postData['date'] ?? null;
        $time = $postData['time'] ?? null;

        // Validar os dados obrigatórios
        if (!$title || !$email || !$date || !$time) {
            throw new Exception($email);
        }

        // Preparar os dados para inserção
        $data = [
            'titulo' => $title,
            'email' => $email,
            'data' => $date,
            'hora' => $time,
        ];

        // Enviar os dados para o Supabase
        $response = sendSupabaseRequest('POST', 'track', $data);

        // Verificar a resposta do Supabase
        if ($response['status'] === 'success' && $response['http_code'] === 201) {
            echo json_encode(['status' => 'success', 'message' => 'Ação registrada com sucesso']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar a ação no Supabase']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido']);
}
