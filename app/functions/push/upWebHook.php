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
            return ['status' => 'error', 'message' => 'Unhandled event type'];
    }
}

// Função para salvar dados no banco
function saveToDatabase($table, $data, $method, $key = null) {
    $endpoint = $table;
    if ($key) {
        $endpoint .= "?email=eq.$key";
    }
    return sendSupabaseRequest($method, $endpoint, $data);
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
?>
