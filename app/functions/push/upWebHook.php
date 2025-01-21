<?php
include "../../config/supabase/supabase_config.php"; // Adjust the path as necessary

// Function to handle Pagar.me webhook
function handlePagarMeWebhook($event) {
    // Check the type of event (e.g., transaction approved, subscription canceled)
    switch ($event['type']) {
        case 'transaction_approved':
            return updateUserAccess($event['data']);
        case 'subscription_canceled':
            return cancelUserAccess($event['data']);
        default:
            return ['status' => 'error', 'message' => 'Unhandled event type'];
    }
}

// Function to update or create user access based on transaction details
function updateUserAccess($data) {
    $email = $data['customer']['email'];
    $subscriptionId = $data['subscription_id'];
    $accessGranted = true; // Set based on your business logic

    // Check if user exists
    $response = sendSupabaseRequest('GET', "users?email=eq.$email");

    if (!empty($response['response'])) {
        // User exists, update access
        $updateData = ['access_granted' => $accessGranted];
        return sendSupabaseRequest('PATCH', "users?email=eq.$email", $updateData);
    } else {
        // No user found, create new user with access
        $newUserData = ['email' => $email, 'access_granted' => $accessGranted, 'subscription_id' => $subscriptionId];
        return sendSupabaseRequest('POST', 'users', $newUserData);
    }
}

// Function to cancel user access based on subscription details
function cancelUserAccess($data) {
    $email = $data['customer']['email'];
    $updateData = ['access_granted' => false];
    return sendSupabaseRequest('PATCH', "users?email=eq.$email", $updateData);
}