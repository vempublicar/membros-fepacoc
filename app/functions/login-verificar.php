<?php
session_start();
include '../config/bd/connection.php';  // Ajuste o caminho conforme necessário
include '../config/path.php';

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

    // Inicializar a conexão com o banco de dados
    try {
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT id, email, password, created_at FROM leads WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verificar se encontrou o usuário
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar a senha
            if (password_verify($password, $user['password'])) {
                // Armazenar dados na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_created_at'] = $user['created_at'];

                header("Location: " . BASE_URL . "painel");
                exit();
            } else {
                $errorMsg = 'Credenciais inválidas. ';
                $errorMsg = base64_encode($errorMsg);
                header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
                exit();
            }
        } else {
            $errorMsg = 'Usuário não encontrado.';
            $errorMsg = base64_encode($errorMsg);
            header("Location: " . BASE_URL . "login&msg=" . $errorMsg);
            exit();
        }
    } catch (PDOException $e) {
        $errorMsg = 'Erro ao tentar se conectar ao banco de dados: ' . $e->getMessage();
        $errorMsg = base64_encode($errorMsg);
        header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
        exit();
    }
} else {
    $errorMsg = 'Método de requisição inválido.';
    $errorMsg = base64_encode($errorMsg);
    header("Location: " . BASE_URL . "erro&msg=" . $errorMsg);
    exit();
}
?>
