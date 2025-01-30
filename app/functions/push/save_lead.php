<?php
session_start();
include_once "../../config/bd/connection.php"; // Conexão com o MySQL

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtém o email do formulário
        $email = $_POST['email'] ?? null;
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

        // Conectar ao banco de dados
        $pdo = db_connect();

        // Verifica se o lead já existe
        $stmt = $pdo->prepare("SELECT id FROM leads WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Atualiza os dados se o lead já existe
            $updateStmt = $pdo->prepare("
                UPDATE leads SET tipo = :tipo, dados = :dados WHERE email = :email
            ");
            $updateStmt->bindParam(':tipo', $tipo);
            $updateStmt->bindParam(':dados', $jsonDados);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            $_SESSION['message'] = 'Dados atualizados com sucesso!';
        } else {
            // Insere um novo lead caso não exista
            $insertStmt = $pdo->prepare("
                INSERT INTO leads (email, tipo, dados) VALUES (:email, :tipo, :dados)
            ");
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':tipo', $tipo);
            $insertStmt->bindParam(':dados', $jsonDados);
            $insertStmt->execute();

            $_SESSION['message'] = 'Dados cadastrados com sucesso!';
        }

        // **Agora salvamos os dados da empresa na sessão para carregamento automático**
        $_SESSION['dados_profissionais'] = $jsonDados;

        header("Location: " . $_SERVER['HTTP_REFERER'] . "#sucesso");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Erro: " . $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER'] . "#error");
        exit();
    }
} else {
    $_SESSION['error'] = 'Método de requisição inválido.';
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#error");
    exit();
}
