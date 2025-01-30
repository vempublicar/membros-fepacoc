<?php
session_start();
include_once "../../config/bd/connection.php"; // Conexão com o MySQL

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtém o email do formulário
        $email = $_POST['email'] ?? null;
        if (!$email) {
            throw new Exception('E-mail não informado.');
        }

        // Prepara os dados do formulário
        $formData = [
            'empresa' => $_POST['empresa'] ?? '',
            'cnpj' => $_POST['cnpj'] ?? '',
            'email_pro' => $_POST['emailPro'] ?? '',
            'setor' => $_POST['setor'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'cep' => $_POST['cep'] ?? '',
            'cidade' => $_POST['cidade'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'faturamento' => $_POST['faturamento'] ?? '',
            'prioridade' => $_POST['prioridade'] ?? '',
            'necessidade' => isset($_POST['necessidade']) ? json_encode($_POST['necessidade'], JSON_UNESCAPED_UNICODE) : '[]'
        ];

        // Conectar ao banco de dados
        $pdo = db_connect();

        // Verifica se a empresa já existe para este email
        $stmt = $pdo->prepare("SELECT id FROM empresa WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Atualiza os dados se a empresa já existir
            $updateStmt = $pdo->prepare("
                UPDATE empresa SET 
                    empresa = :empresa, 
                    cnpj = :cnpj, 
                    email_pro = :email_pro, 
                    setor = :setor, 
                    phone = :phone, 
                    cep = :cep, 
                    cidade = :cidade, 
                    estado = :estado, 
                    faturamento = :faturamento, 
                    prioridade = :prioridade, 
                    necessidade = :necessidade 
                WHERE email = :email
            ");
        } else {
            // Insere um novo registro caso não exista
            $updateStmt = $pdo->prepare("
                INSERT INTO empresa 
                (email, empresa, cnpj, email_pro, setor, phone, cep, cidade, estado, faturamento, prioridade, necessidade) 
                VALUES 
                (:email, :empresa, :cnpj, :email_pro, :setor, :phone, :cep, :cidade, :estado, :faturamento, :prioridade, :necessidade)
            ");
        }

        // Bind dos parâmetros
        foreach ($formData as $key => &$value) {
            $updateStmt->bindParam(":$key", $value, PDO::PARAM_STR);
        }
        $updateStmt->bindParam(":email", $email, PDO::PARAM_STR);
        $updateStmt->execute();

        // **Agora salvamos os dados da empresa na sessão para carregamento automático**
        $_SESSION['dados_profissionais'] = json_encode($formData, JSON_UNESCAPED_UNICODE);

        $_SESSION['message'] = 'Dados da empresa salvos com sucesso!';
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
