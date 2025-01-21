<?php
include "config/supabase/supabase_config.php"; // Ajuste o caminho conforme necessário

// Função para lidar com o webhook do Pagar.me
function handlePagarMeWebhook($event) {
    switch ($event['type']) {
        case 'customer.created':
        case 'customer.updated':
            saveCustomerEvent($event['data']);
            break;
        case 'charge.payment_failed':
            savePaymentFailure($event['data']);
            break;
    }
}

// Função para salvar eventos de cliente
function saveCustomerEvent($data) {
    $customerData = [
        'email' => $data['email'],
        'name' => $data['name'],
        'document' => $data['document'],
        'address' => json_encode($data['address']),
        'phone' => $data['phones']['mobile_phone']['number'],
        'updated_at' => date('Y-m-d H:i:s'),
        'created_at' => date('Y-m-d H:i:s')  // A data de criação é sempre atualizada para garantir o registro
    ];
    sendSupabaseRequest('POST', 'users', $customerData);
}

// Função para salvar falhas de pagamento
function savePaymentFailure($data) {
    $failureData = [
        'email' => $data['customer']['email'],
        'payment_status' => 'failed',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    sendSupabaseRequest('PATCH', "users?email=eq." . $data['customer']['email'], $failureData);
}

// Função para enviar requisições ao Supabase
function sendSupabaseRequest($method, $endpoint, $data) {
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
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
}

?>
