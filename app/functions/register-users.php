<?php
session_start();

include '../config/supabase/supabase_config.php';
include '../config/path.php';
include 'cadastro-lead.php';
include 'email/envio-email.php';

// Função para sanitizar dados
function sanitizar($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar e sanitizar dados do formulário
    $nome = sanitizar($_POST['name']);
    $whatsapp = sanitizar($_POST['whatsapp']);
    $email = sanitizar($_POST['email-username']);
    $password = sanitizar($_POST['password']);

    // Validações básicas
    if (empty($nome) || empty($whatsapp) || empty($email) || empty($password)) {
        redirecionarComMensagem("cadastro", "Por favor, preencha todos os campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirecionarComMensagem("cadastro", "Formato de email inválido.");
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

    if ($err || $httpCode >= 400) {
        $mensagemErro = $err ?: "Erro na requisição ao Supabase. Código HTTP: $httpCode";
        redirecionarComMensagem("cadastro", $mensagemErro);
    } else {
        // Decodificar a resposta para verificar o sucesso
        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            redirecionarComMensagem("cadastro", "Erro: " . $responseData['error']['message']);
        } else {
            // Inserir dados no banco de dados local
            $tabela = 'leads';
            $dados = [
                'nome' => $nome,
                'fone' => $whatsapp,
                'email' => $email,
                'acesso' => $password,
            ];

            inserirDadosSupabase($tabela, $dados);

            // Enviar email de confirmação
            enviarLinkCadastroSenha($email, $nome, $password);

            // Redirecionar para página de verificação de email
            header("Location: " . BASE_URL . "verificar-email");
            exit();
        }
    }
} else {
    header("Location: " . BASE_URL . "login");
    exit();
}

// Função para redirecionar com mensagem
function redirecionarComMensagem($url, $mensagem) {
    header("Location: " . BASE_URL . $url . "?msg=" . urlencode($mensagem));
    exit();
}
