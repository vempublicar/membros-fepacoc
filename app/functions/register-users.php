<?php
session_start();

include '../config/supabase/supabase_config.php';
include '../config/path.php';
include 'cadastro-lead.php';
include 'email/envio-email.php';

// Verificar se os dados do formulário foram enviados 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $nome = $_POST['name'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email-username'];
    $password = $_POST['password'];

    // Validações básicas
    if (empty($email) || empty($password)) {
        exit('Por favor, preencha todos os campos.');
    }

    // Preparar dados para enviar à API do Supabase
    $data = [
        'email' => $email,
        'password' => $password
    ];

    // Inicializar cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => SUPABASE_URL . "/auth/v1/signup",
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
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    sleep(2);
    if ($err) {
        echo "Erro ao conectar ao Supabase: $err";
    } else {
        // Processar a resposta
        $responseArray = json_decode($response, true);

        // Verificar o código HTTP retornado
        if ($httpCode === 201 && isset($responseArray['access_token'])) {
            // Cadastro bem-sucedido
            enviarLinkCadastroSenha($email, $nome, $password);
            header("Location: " . BASE_URL . "verificar-email");
            exit();
        } elseif ($httpCode === 409 || (isset($responseArray['error_code']) && $responseArray['error_code'] === 'user_already_exists')) {
            // Email já registrado
            $titulo = 'Erro de Cadastro! Fepacoc Membros';
            $texto = 'Estamos com problemas para cadastrar este e-mail, verifique com a equipe de suporte. <br> Acreditamos que este e-mail já está registrado, basta solicitar nova senha.';
            enviarEmailGenerico($email, $nome, $titulo, $texto);

            $errorMsg = 'Este email já está registrado. Por favor, faça login ou use outro email.';
            redirecionarComMensagem("register", $errorMsg);
        } else {
            // Caso não haja um código específico, redireciona para um erro genérico
            redirecionarComMensagem("register", 'Erro ao registrar, tente novamente.');
        }
    }
} else {
    header("Location: " . BASE_URL . "login");
    exit();
}
function redirecionarComMensagem($url, $mensagem) {
    header("Location: " . BASE_URL . $url . "&msg=" . base64_encode($mensagem));
    exit();
}
