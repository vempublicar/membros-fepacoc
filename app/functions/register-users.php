<?php
session_start();

include '../config/bd/conection.php';
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

    // Inicializar a conexão com o MySQL
    $mysqlClient = new MySQLClient();

    // Inserir dados no banco de dados MySQL
    try {
        $tabela = 'leads';
        $dados = [
            'nome' => $nome,
            'fone' => $whatsapp,
            'email' => $email,
            'acesso' => $password,
        ];

        // Preparar a query SQL
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO $tabela ($colunas) VALUES ($valores)";

        // Executar a query
        $stmt = $mysqlClient->getPdo()->prepare($sql);
        $stmt->execute($dados);

        // Enviar email de confirmação
       // enviarLinkCadastroSenha($email, $nome, $password);

        // Redirecionar para página de verificação de email
        header("Location: " . BASE_URL . "verificar-email");
        exit();

    } catch (PDOException $e) {
        // Em caso de erro, redirecionar com mensagem de erro
        redirecionarComMensagem("cadastro", "Erro ao inserir dados no banco de dados: " . $e->getMessage());
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
