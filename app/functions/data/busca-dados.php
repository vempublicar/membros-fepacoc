<?php
include "app/config/supabase/supabase_config.php";


function fetchVideos() {
    $queryParams = [
        'limit' => 500,       // Limite de 500 registros
        'order' => 'id.desc', // Ordenação decrescente pelo campo 'id'
    ];
    $response = sendSupabaseRequest('GET', 'videos?' . http_build_query($queryParams)); // Endpoint da tabela "videos"
    if ($response['status'] === 'success' && $response['http_code'] === 200) {
        return $response['response'];
    }
    return [];
}
function fetchMateriais() {
    $queryParams = [
        'limit' => 500,       // Limite de 500 registros
        'order' => 'id.desc', // Ordenação decrescente pelo campo 'id'
    ];
    $response = sendSupabaseRequest('GET', 'materiais?' . http_build_query($queryParams)); // Endpoint da tabela "videos"
    if ($response['status'] === 'success' && $response['http_code'] === 200) {
        return $response['response'];
    }
    return [];
}
function fetchProdutos() {
    $queryParams = [
        'limit' => 500,       // Limite de 500 registros
        'order' => 'id.desc', // Ordenação decrescente pelo campo 'id'
    ];
    $response = sendSupabaseRequest('GET', 'produtos?' . http_build_query($queryParams)); // Endpoint da tabela "videos"
    if ($response['status'] === 'success' && $response['http_code'] === 200) {
        return $response['response'];
    }
    return [];
}
function fetchLeads() {
    // Parâmetros de consulta para limitar e ordenar
    $queryParams = [
        'limit' => 500,       // Limite de 500 registros
        'order' => 'id.desc', // Ordenação decrescente pelo campo 'id'
    ];

    // Faz a chamada ao Supabase com os parâmetros
    $response = sendSupabaseRequest('GET', 'leads?' . http_build_query($queryParams));

    if ($response['status'] === 'success' && $response['http_code'] === 200) {
        return $response['response'];
    }
    return [];
}

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