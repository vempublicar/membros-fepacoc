<?php
session_start();
include "../../config/bd/connection.php"; // Conexão com o banco de dados

// Função para criar pastas automaticamente
function checkAndCreateFolder($folderPath) {
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
}

// Função para upload de arquivos em diretórios específicos
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

    // Coleta os dados do formulário
    foreach ($_POST as $chave => $valor) {
        if (!in_array($chave, ['action', 'tabela', 'id'])) {
            $dados[$chave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }
    }

    // Diretórios específicos para imagens
    $dirDesktop = "../../../uploads/capas/desktop/";
    $dirMobile = "../../../uploads/capas/mobile/";

    // Upload da imagem desktop
    if (!empty($_FILES['imagem_desktop']['size'])) {
        $dados['imagem_desktop'] = handleFileUpload($_FILES['imagem_desktop'], $dirDesktop);
    }

    // Upload da imagem mobile
    if (!empty($_FILES['imagem_mobile']['size'])) {
        $dados['imagem_mobile'] = handleFileUpload($_FILES['imagem_mobile'], $dirMobile);
    }

    // CRUD: Criação, atualização ou exclusão
    if ($action === 'create') {
        // Construção da query SQL dinâmica
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO `$tabela` ($colunas) VALUES ($valores)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($dados);

        $_SESSION['message'] = "Capa adicionada com sucesso!";
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

        $_SESSION['message'] = "Capa atualizada com sucesso!";
        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();

    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
            exit();
        }

        // Busca as imagens associadas antes de excluir
        $stmt = $pdo->prepare("SELECT imagem_desktop, imagem_mobile FROM `$tabela` WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $capa = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($capa) {
            // Remove os arquivos físicos das imagens
            if (!empty($capa['imagem_desktop']) && file_exists($dirDesktop . $capa['imagem_desktop'])) {
                unlink($dirDesktop . $capa['imagem_desktop']);
            }

            if (!empty($capa['imagem_mobile']) && file_exists($dirMobile . $capa['imagem_mobile'])) {
                unlink($dirMobile . $capa['imagem_mobile']);
            }

            // Deletar o registro do banco
            $sql = "DELETE FROM `$tabela` WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            $_SESSION['message'] = "Capa excluída com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao excluir a capa.";
        }

        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();
    }

    header("Location: " . $_SERVER['HTTP_REFERER'] . "#$tabela");
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = "Erro ao processar a requisição: " . $e->getMessage();
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#erro");
    exit();
}
?>
