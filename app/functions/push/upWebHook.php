<?php
include "config/supabase/supabase_config.php"; // Ajuste o caminho conforme necessário

// Função para lidar com o webhook do Pagar.me
function handlePagarMeWebhook($event) {
    switch ($event['type']) {
        case 'customer.created':
        case 'customer.updated':
            return handleCustomerEvent($event['data']);
        case 'charge.payment_failed':
            return handlePaymentFailure($event['data']);
        default:
            return ['status' => 'error', 'message' => 'Tipo de evento não tratado'];
    }
}

// Função para salvar dados no banco
function saveToDatabase($table, $data, $method, $key = null) {
    $endpoint = $table . ($key ? "?email=eq.$key" : "");
    //$response = sendSupabaseRequest($method, $endpoint, $data);
    //if ($response['status'] === 'error') {
    //   return $response; // Retorna a resposta de erro para ser tratada ou logada
    //}
    return ['status' => 'success', 'message' => 'Dados processados com sucesso'];
}

// Manipular eventos de criação ou atualização de clientes
function handleCustomerEvent($data) {
    $email = $data['email'];
    $customerData = [
        'email' => $email,
        'name' => $data['name'],
        'document' => $data['document'],
        'address' => json_encode($data['address']),
        'phone' => $data['phones']['mobile_phone']['number'],
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Verifica se o usuário já existe
    $response = sendSupabaseRequest('GET', "users?email=eq.$email");
    if (!empty($response['response'])) {
        // Usuário existe, atualizar dados
        return saveToDatabase('users', $customerData, 'PATCH', $email);
    } else {
        // Nenhum usuário encontrado, criar novo usuário
        $customerData['created_at'] = date('Y-m-d H:i:s');
        return saveToDatabase('users', $customerData, 'POST');
    }
}

// Manipular eventos de falha de pagamento
function handlePaymentFailure($data) {
    $email = $data['customer']['email'];
    $updateData = [
        'payment_status' => 'failed',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return saveToDatabase('users', $updateData, 'PATCH', $email);
}

function sendSupabaseRequest($method, $endpoint, $data = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    $headers = [
        "Content-Type: application/json",
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers
    ]);

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode != 200 && $httpCode != 201) { // Considerando 200 e 201 como sucesso
        return ['status' => 'error', 'message' => 'Erro na requisição HTTP', 'http_code' => $httpCode];
    }

    return ['status' => 'success', 'response' => json_decode($response, true)];
}
?>
