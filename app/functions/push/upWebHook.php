<?php
include "../../config/supabase/supabase_config.php"; // Adjust the path as necessary

// Function to handle Pagar.me webhook
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

// Handle customer creation or update events
function handleCustomerEvent($data) {
    $email = $data['email'];
    $customerData = [
        'email' => $email,
        'name' => $data['name'],
        'document' => $data['document'],
        'address' => json_encode($data['address']), // Store address as JSON string
        'phone' => $data['phones']['mobile_phone']['number'],
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Check if user exists
    $response = sendSupabaseRequest('GET', "users?email=eq.$email");
    if (!empty($response['response'])) {
        // User exists, update data
        return sendSupabaseRequest('PATCH', "users?email=eq.$email", $customerData);
    } else {
        // No user found, create new user
        $customerData['created_at'] = date('Y-m-d H:i:s');
        return sendSupabaseRequest('POST', 'users', $customerData);
    }
}

// Handle payment failure events
function handlePaymentFailure($data) {
    $email = $data['customer']['email'];
    $updateData = [
        'payment_status' => 'failed',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return sendSupabaseRequest('PATCH', "users?email=eq.$email", $updateData);
}
?>
