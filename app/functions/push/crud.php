<?php
session_start();
include "../../config/bd/connection.php"; // Conexão com o banco de dados

// Função para verificar e criar diretório, se necessário
function checkAndCreateFolder($folderPath) {
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true); // Cria a pasta com permissões corretas
    }
}

// Função para fazer upload de arquivos (imagem/vídeo)
function handleFileUpload($file, $uploadDir) {
    checkAndCreateFolder($uploadDir); // Garante que a pasta existe

    if ($file['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('file_') . '.' . $extensao;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename; // Retorna o nome do arquivo salvo
        }
    }
    return null; // Retorna null se o upload falhar
}

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode("Método de requisição inválido."));
    exit();
}

$action = $_POST['action'] ?? null;
$tabela = $_POST['tabela'] ?? null;

// Valida a tabela para evitar SQL Injection
if (!$tabela || !preg_match('/^[a-zA-Z0-9_]+$/', $tabela)) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode("Tabela inválida ou não informada."));
    exit();
}

try {
    $pdo = db_connect(); // Conectar ao MySQL

    if ($action === 'create') {
        // Construir array de dados dinamicamente
        $dados = [];
        foreach ($_POST as $chave => $valor) {
            if (!in_array($chave, ['action', 'tabela'])) {
                $dados[$chave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
            }
        }

        // Upload de arquivos (se houver)
        if (!empty($_FILES)) {
            foreach ($_FILES as $inputName => $file) {
                if ($file['size'] > 0) {
                    $uploadDir = "../../../vendor/uploads/" . $tabela . "/";
                    $uploadedFile = handleFileUpload($file, $uploadDir);
                    if ($uploadedFile) {
                        $dados[$inputName] = $uploadedFile;
                    }
                }
            }
        }

        // Construir query SQL dinâmica
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO `$tabela` ($colunas) VALUES ($valores)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=success&msg=" . urlencode("Registro criado com sucesso."));
        exit();

    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode("ID inválido."));
            exit();
        }

        $dados = [];
        foreach ($_POST as $chave => $valor) {
            if (!in_array($chave, ['action', 'tabela', 'id'])) {
                $dados[$chave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
            }
        }

        // Upload de arquivos (se houver)
        if (!empty($_FILES)) {
            foreach ($_FILES as $inputName => $file) {
                if ($file['size'] > 0) {
                    $uploadDir = "../../../vendor/uploads/" . $tabela . "/";
                    $uploadedFile = handleFileUpload($file, $uploadDir);
                    if ($uploadedFile) {
                        $dados[$inputName] = $uploadedFile;
                    }
                }
            }
        }

        // Construir query SQL dinâmica
        $setCampos = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($dados)));
        $sql = "UPDATE `$tabela` SET $setCampos WHERE id = :id";
        $dados['id'] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=success&msg=" . urlencode("Registro atualizado com sucesso."));
        exit();

    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode("ID inválido."));
            exit();
        }

        $sql = "DELETE FROM `$tabela` WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=success&msg=" . urlencode("Registro excluído com sucesso."));
        exit();
    }

    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode("Ação inválida."));
    exit();

} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=error&msg=" . urlencode($e->getMessage()));
    exit();
}
?>
