<?php
session_start();
include '../config/bd/connection.php';  // Conexão com o banco MySQL
include '../config/path.php';
include "data/busca-dados.php";

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Validações básicas
    if (empty($email) || empty($password)) {
        $errorMsg = base64_encode('Informe corretamente o login e senha.');
        header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
        exit();
    }

    try {
        // Conectar ao banco de dados
        $pdo = db_connect();

        // Busca o usuário na tabela leads
        $stmt = $pdo->prepare("SELECT id, email, nome, fone, tipo, acesso, created_at FROM leads WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verifica se encontrou o usuário
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha
            if ($password === $user['acesso']) {
                // Salva dados do usuário na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['fone'] = $user['fone'];
                $_SESSION['tipo'] = $user['tipo'];
                $_SESSION['created_at'] = $user['created_at'];

                // Verifica se o usuário tem uma empresa vinculada
                $stmtEmpresa = $pdo->prepare("SELECT * FROM empresa WHERE email = :email");
                $stmtEmpresa->bindParam(':email', $email);
                $stmtEmpresa->execute();

                if ($stmtEmpresa->rowCount() > 0) {
                    // Armazena os dados da empresa na sessão
                    $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['dados_profissionais'] = json_encode($empresa, JSON_UNESCAPED_UNICODE);
                    $_SESSION['videos'] = fetchVideos();
                    $_SESSION['produtos'] = fetchProdutos();
                    $_SESSION['materiais'] = fetchMateriais();
                    $_SESSION['leads'] = fetchLeads();
                    $_SESSION['categorias'] = fetchCategorias();
                    $_SESSION['ferramentas'] = fetchFerramentas();
                    $_SESSION['capas'] = fetchCapas();
                    $_SESSION['assuntos'] = fetchAssunto();                    
                } else {
                    // Caso o usuário não tenha empresa vinculada
                    $_SESSION['dados_profissionais'] = json_encode([]);
                }

                header("Location: " . BASE_URL . "painel");
                exit();
            } else {
                $errorMsg = base64_encode('Credenciais inválidas.');
                header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
                exit();
            }
        } else {
            $errorMsg = base64_encode('Usuário não encontrado.');
            header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
            exit();
        }
    } catch (PDOException $e) {
        $errorMsg = base64_encode("Erro ao tentar se conectar ao banco de dados: " . $e->getMessage());
        header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
        exit();
    }
} else {
    $errorMsg = base64_encode('Método de requisição inválido.');
    header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
    exit();
}
