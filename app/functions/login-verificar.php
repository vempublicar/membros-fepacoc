<?php
session_start();
include '../config/supabase/supabase_config.php';  // Ajuste o caminho conforme necessário
include '../config/supabase/SupabaseClient.php';
// include_once "../data/carrega-dados.php"; 
include '../config/path.php';

$client = new SupabaseClient();

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validações básicas
    if (empty($email) || empty($password)) {
        $errorMsg = 'Informe corretamente o login e senha.';
        $errorMsg = base64_encode($errorMsg);
        header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
        exit();
    }

    // Preparar dados para enviar à API do Supabase
    $data = [
        'email' => $email,
        'password' => $password
    ];

    // Inicializar cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => SUPABASE_URL . "/auth/v1/token?grant_type=password",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "apikey: " . SUPABASE_KEY,
        ],
    ]);

    // Executar a requisição
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
print_r($response);
    if ($err) {
        $errorMsg = 'Erro ao tentar se conectar ao banco de dados.';
        $errorMsg = base64_encode($errorMsg);
        header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
        exit();
    } else {
        // Processar a resposta
        $decodedResponse = json_decode($response, true);

        // Verificar se há um token de acesso
        if (isset($decodedResponse["access_token"])) {
            $_SESSION['user_dados'] = $response;
            $_SESSION['refresh_token'] = $decodedResponse["refresh_token"];
            $_SESSION['user_token'] = $decodedResponse["access_token"];
            $_SESSION['user_email'] = $decodedResponse["user"]["email"];
            $_SESSION['user_id'] = $decodedResponse["user"]["id"];
            $_SESSION['user_created_at'] = $decodedResponse["user"]["created_at"];

            // carregarTodosDados();

            header("Location: " . BASE_URL . "painel");
            exit();
        } else {
            // Verificar se o código de erro é de credenciais inválidas
            if (isset($decodedResponse["error_code"]) && $decodedResponse["error_code"] === "invalid_credentials") {
                $errorMsg = 'Credenciais inválidas. ';
                $errorMsg = base64_encode($errorMsg);
                header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
                exit();
            } else {
                $errorMsg = 'Erro ao tentar realizar o acesso ao sistema.';
                $errorMsg = base64_encode($errorMsg);
                // header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
                exit();
            }
        }
    }
} else {
    $errorMsg = 'Método de requisição inválido.';
    $errorMsg = base64_encode($errorMsg);
    header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
    exit();
}
