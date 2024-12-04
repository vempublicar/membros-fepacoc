<?php
session_start();

include '../config/supabase/supabase_config.php';
include '../config/path.php';
include 'cadastro-lead.php';
include 'email/envio-email.php';

// Verificar se os dados do formulário foram enviados 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    // print_r($_POST);
    $nome = $_POST['name'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email-username'];
    $password = $_POST['password'];

    // Validações básicas (ajuste conforme necessário)
    if (empty($email) || empty($password)) {
        // Retornar erro se algum campo estiver vazio
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
    curl_close($curl);

    if ($err) {
        echo "Erro ao conectar ao Supabase: $err";
    } else {
        // Processar a resposta
        $responseArray = json_decode($response, true);

        // print_r($responseArray);
        $responseArray = json_decode($response, true);
        //cadastrar email senha e dados do usuário na tabela leads
        $tabelaLead = 'leads';
        $dados = [
            'nome' => $nome,
            'fone' => $whatsapp,
            'email' => $email,
            'acesso' => $password
        ];
        $cadastroLeads = inserirDadosSupabase($tabelaLead, $dados);
        sleep(1);
        // print_r($cadastroLeads);
        // echo '<hr>teste';
        if (isset($responseArray['id'])) {

            enviarLinkCadastroSenha($email, $nome, $password);
            sleep(1);
            if (empty($responseArray['identities'])) {
                // Usuário já registrado e confirmou o email
                header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
            } else {
                // Usuário registrado, mas precisa verificar o email
                header("Location: " . BASE_URL . "verificar-email");
            }
        } elseif (isset($responseArray['code'])) {
            $errorCode = $responseArray['code'];
            $errorMsg = $responseArray['msg'];
            $errorDetail = isset($responseArray['error_code']) ? $responseArray['error_code'] : '';
            $titulo = 'Erro de Cadastro! Fepacoc Membros';
            $texto = 'Estamos com problemas para cadastrar este e-mail, verifique com a equipe de suporte. <br> Acreditamos que este e-mail já está registrado, basta solicitar nova senha.';
            enviarEmailGenerico($email, $nome, $titulo, $texto);
            sleep(1);
            switch ($errorCode) {
                case 400:
                    if ($errorDetail === 'email_address_not_authorized') {
                        $errorMsg = 'Este email já está registrado. Por favor, faça login ou use outro email.';
                    } else {
                        $errorMsg = 'Dados inválidos. Por favor, revise as informações.';
                    }
                    break;
                case 401:
                    $errorMsg = 'Você não está autorizado. Verifique suas permissões.';
                    break;
                case 429:
                    $errorMsg = 'Limite de requisições excedido. Tente novamente mais tarde.';
                    break;
                default:
                    $errorMsg = 'Acreditamos que este email já esta registrado. Verifique com o suporte.';
                    break;
            }

            $errorMsg = base64_encode($errorMsg);
            header("Location: " . BASE_URL . "register&msg=" . $errorMsg);
        } else {
            // Caso não haja um código de erro, redireciona para um erro genérico
            $errorMsg = base64_encode('Tente novamente com outro email');
            header("Location: " . BASE_URL . "register&msg=" . $errorMsg);
        }
    }
} else {
    header("Location: " . BASE_URL . "login");
}
