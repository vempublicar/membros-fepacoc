<?php
session_start();
include "../../config/supabase/supabase_config.php";
include "../email/envio-email.php";
include '../../config/path.php';

// Função para enviar requisições ao Supabase
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

// Lidar com a recuperação de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;

    if ($email) {
        try {
            // Consultar o email na tabela leads
            $response = sendSupabaseRequest('GET', "leads?email=eq.$email", null);

            if ($response['status'] === 'success' && !empty($response['response'])) {
                $lead = $response['response'][0];
                $acesso = $lead['acesso'] ?? null;
                $nome = $lead['nome'] ?? "Usuário";

                if ($acesso) {
                    // Enviar email com a senha
                    $resultadoEmail = enviarEmailRecuperar($email, $nome, $acesso);
// print_r($resultadoEmail)
                    if ($resultadoEmail === '1') {
                        header("Location: " . BASE_URL . "verificar-email");
                    } else {
                        redirecionarComMensagem("esqueci-senha", 'Erro ao enviar o email.');
                    }
                } else {
                    redirecionarComMensagem("esqueci-senha", 'Acesso não encontrado.');
                }
            } else {
                redirecionarComMensagem("esqueci-senha", 'Email não encontrado.');
            }
        } catch (Exception $e) {
            redirecionarComMensagem("esqueci-senha", 'Erro ao registrar, tente novamente.');
        }
    } else {
        redirecionarComMensagem("esqueci-senha", 'Por favor, insira um email válido.');
    }
} else {
    redirecionarComMensagem("esqueci-senha", 'Método de requisição inválido');
}

function redirecionarComMensagem($url, $mensagem) {
    header("Location: " . BASE_URL . $url . "&msg=" . base64_encode($mensagem));
    exit();
}
?>
