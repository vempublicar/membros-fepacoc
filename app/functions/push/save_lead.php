<?php
session_start();
include_once "../../config/supabase/supabase_config.php";

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

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtém o email do formulário
        $email = $_POST['email'] ?? null;
//         echo 'teste';
// print_r($email);
        if (!$email) {
            throw new Exception('E-mail não informado');
        }
        $tipo = $_POST['tipo'] ?? '';
        // Prepara os dados do formulário
        $formData = [
            'empresa' => $_POST['empresa'] ?? '',
            'cnpj' => $_POST['cnpj'] ?? '',
            'email-pro' => $_POST['emailPro'] ?? '',
            'setor' => $_POST['setor'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'cep' => $_POST['cep'] ?? '',
            'cidade' => $_POST['cidade'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'faturamento' => $_POST['faturamento'] ?? '',
            'prioridade' => $_POST['prioridade'] ?? '',
            'necessidade' => $_POST['necessidade'] ?? []
        ];

        // Gera o JSON para a coluna `dados`
        $jsonDados = json_encode($formData, JSON_UNESCAPED_UNICODE);

        // Atualiza o lead no Supabase com base no email
        $updateData = [
            'tipo' => $tipo,
            'dados' => $jsonDados
        ];
        
        $response = sendSupabaseRequest('PATCH', "leads?email=eq.$email", $updateData);

        // Verifica a resposta
        if ($response['status'] === 'success' && $response['http_code'] === 204) {
            $_SESSION['message'] = 'Dados atualizados com sucesso!';
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#sucesso");
        } else {
            throw new Exception('Erro ao atualizar os dados: ' . json_encode($response['response']));
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER'] . "#error");
    }
} else {
    $_SESSION['error'] = 'Método de requisição inválido.';
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#error");
}
