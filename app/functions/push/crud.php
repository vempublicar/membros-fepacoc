<?php
session_start();
include "../../config/bd/connection.php"; // Conexão com o banco de dados

// Função para criar pastas automaticamente
function checkAndCreateFolder($folderPath) {
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}

// Função para excluir arquivos antigos
function deleteOldFile($oldFile, $uploadDir) {
    if (!empty($oldFile) && file_exists($uploadDir . $oldFile)) {
        unlink($uploadDir . $oldFile);
    }
}

// Função para upload de arquivos
function handleFileUpload($file, $uploadDir, $oldFile = null) {
    checkAndCreateFolder($uploadDir);

    if ($file['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('file_') . '.' . $extensao;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Exclui arquivo antigo, se existir
            deleteOldFile($oldFile, $uploadDir);
            return $filename;
        }
    }
    return $oldFile;
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

    // Estrutura de diretórios por tabela
    $uploadDirs = [
        'capas' => [
            'desktop' => "vendor/uploads/$tabela/desktop/",
            'mobile' => "vendor/uploads/$tabela/mobile/"
        ],
        'videos' => [
            'capa' => "vendor/uploads/$tabela/capa/",
            'arquivo' => "vendor/uploads/$tabela/arquivo/"
        ],
        'materiais' => [
            'capa' => "vendor/uploads/$tabela/capa/",
            'arquivo' => "vendor/uploads/$tabela/arquivo/"
        ]
    ];

    // Processamento de arquivos enviados
    foreach ($_FILES as $campo => $file) {
        if (!empty($file['size'])) {
            // Define a pasta correta para upload com base no campo do formulário
            if ($tabela === 'capas' && in_array($campo, ['capaDesktop', 'capaMobile'])) {
                $uploadDir = $uploadDirs['capas'][$campo === 'capaDesktop' ? 'desktop' : 'mobile'];
            } elseif ($tabela === 'videos' && in_array($campo, ['vidCapa', 'vidLink'])) {
                $uploadDir = $uploadDirs['videos'][$campo === 'vidCapa' ? 'capa' : 'arquivo'];
            } elseif ($tabela === 'materiais' && in_array($campo, ['matCapa', 'matLink'])) {
                $uploadDir = $uploadDirs['materiais'][$campo === 'matCapa' ? 'capa' : 'arquivo'];
            } else {
                continue;
            }

            $dados[$campo] = handleFileUpload($file, $uploadDir, $_POST["old_$campo"] ?? null);
        }
    }

    if ($action === 'create') {
        // Construção da query SQL dinâmica
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO `$tabela` ($colunas) VALUES ($valores)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        $_SESSION['message'] = 'Registro criado com sucesso!';
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

        $_SESSION['message'] = 'Registro atualizado com sucesso!';
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

        $_SESSION['message'] = 'Registro excluído com sucesso!';
        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();
    }

    $_SESSION['message'] = 'Operação realizada com sucesso!';
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = "Erro: " . $e->getMessage();
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#erro");
    exit();
}
