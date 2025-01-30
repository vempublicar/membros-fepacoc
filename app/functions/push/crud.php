<?php
session_start();
include "../../config/bd/connection.php"; // Conexão com o banco de dados

// Função para criar pastas automaticamente
function checkAndCreateFolder($folderPath) {
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}

// Função para upload de arquivos
function handleFileUpload($file, $uploadDir) {
    checkAndCreateFolder($uploadDir);

    if ($file['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('file_') . '.' . $extensao;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename; // Retorna o nome do arquivo salvo
        }
    }
    return null;
}

// Processamento do CRUD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$action = $_POST['action'] ?? null;
$tabela = $_POST['tabela'] ?? null;

// Validação da tabela (evita SQL Injection)
if (!$tabela || !preg_match('/^[a-zA-Z0-9_]+$/', $tabela)) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#erro");
    exit();
}

try {
    $pdo = db_connect();
    $dados = [];

    // Detecta os novos padrões de colunas
    foreach ($_POST as $chave => $valor) {
        if (!in_array($chave, ['action', 'tabela', 'id'])) {
            $dados[$chave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }
    }

    // Campos mapeados para uploads (imagens e arquivos)
    $camposUploads = [
        'capa' => ["catCapa", "ferCapa", "proCapa", "matCapa", "vidCapa"],
        'cover' => ["matCover"],
        'link' => ["matLink", "vidLink"]
    ];

    // Processamento de arquivos enviados
    foreach ($_FILES as $campo => $file) {
        if (!empty($file['size'])) {
            foreach ($camposUploads as $campoPadrao => $variacoes) {
                if (in_array($campo, $variacoes)) {
                    $uploadDir = "../../../vendor/uploads/" . $tabela . "/";
                    if ($campo === 'link') {
                        $uploadDir .= "arquivo/"; // Diretório específico para arquivos
                    }
                    $dados[$campo] = handleFileUpload($file, $uploadDir);
                }
            }
        }
    }

    if ($action === 'create') {
        // Construção da query SQL dinâmica
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO `$tabela` ($colunas) VALUES ($valores)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();

    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
            exit();
        }

        // Construção da query SQL dinâmica
        $setCampos = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($dados)));
        $sql = "UPDATE `$tabela` SET $setCampos WHERE id = :id";
        $dados['id'] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();

    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
            exit();
        }

        // Deletar o registro do banco
        $sql = "DELETE FROM `$tabela` WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();
    }

    header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
    exit();

} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#erro");
    exit();
}
?>
