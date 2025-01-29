<?php
session_start();

include '../config/bd/connection.php';  // Caminho corrigido e nome do arquivo corrigido
include '../config/path.php';
include 'cadastro-lead.php';
include 'email/envio-email.php';

// Função para sanitizar dados
function sanitizar($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = sanitizar($_POST['name']);
    $whatsapp = sanitizar($_POST['whatsapp']);
    $email = sanitizar($_POST['email-username']);
    $password = sanitizar($_POST['password']);

    if (empty($nome) || empty($whatsapp) || empty($email) || empty($password)) {
        redirecionarComMensagem("cadastro", "Por favor, preencha todos os campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirecionarComMensagem("cadastro", "Formato de email inválido.");
    }

    try {
        $pdo = db_connect();  // Usando a função definida no arquivo connection.php

        $tabela = 'leads';
        $dados = [
            'nome' => $nome,
            'fone' => $whatsapp,
            'email' => $email,
            'acesso' => $password,
        ];

        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO $tabela ($colunas) VALUES ($valores)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        enviarLinkCadastroSenha($email, $nome, $password);

        header("Location: " . BASE_URL . "verificar-email");
        exit();

    } catch (PDOException $e) {
        redirecionarComMensagem("cadastro", "Erro ao inserir dados no banco de dados: " . $e->getMessage());
    }
} else {
    header("Location: " . BASE_URL . "login");
    exit();
}

function redirecionarComMensagem($url, $mensagem) {
    header("Location: " . BASE_URL . $url . "?msg=" . urlencode($mensagem));
    exit();
}
