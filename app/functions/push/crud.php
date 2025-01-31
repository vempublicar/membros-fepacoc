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

    // Estrutura de diretórios por tabela
    $uploadDirs = [
        'capas' => [
            'desktop' => "../../vendor/uploads/capas/desktop/",
            'mobile' => "../../vendor/uploads/capas/mobile/"
        ],
        'videos' => [
            'capa' => "../../vendor/uploads/videos/capa/",
            'arquivo' => "../../vendor/uploads/videos/arquivo/"
        ],
        'materiais' => [
            'capa' => "../../vendor/uploads/materiais/capa/",
            'arquivo' => "../../vendor/uploads/materiais/arquivo/"
        ]
    ];

    // Processamento de arquivos enviados
    foreach ($_FILES as $campo => $file) {
        if (!empty($file['size'])) {
            if ($tabela === 'capas' && in_array($campo, ['capaDesktop', 'capaMobile'])) {
                $uploadDir = $uploadDirs['capas'][$campo === 'capaDesktop' ? 'desktop' : 'mobile'];
            } elseif ($tabela === 'videos' && in_array($campo, ['vidCapa', 'vidLink'])) {
                $uploadDir = $uploadDirs['videos'][$campo === 'vidCapa' ? 'capa' : 'arquivo'];
            } elseif ($tabela === 'materiais' && in_array($campo, ['matCapa', 'matLink'])) {
                $uploadDir = $uploadDirs['materiais'][$campo === 'matCapa' ? 'capa' : 'arquivo'];
            } else {
                continue; // Se não pertence a nenhuma das tabelas, ignora
            }

            $dados[$campo] = handleFileUpload($file, $uploadDir);
        }
    }

    // Processa os dados do formulário
    foreach ($_POST as $chave => $valor) {
        if (!in_array($chave, ['action', 'tabela', 'id'])) {
            $dados[$chave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
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
            $_SESSION['error'] = "ID inválido para atualização.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
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
            $_SESSION['error'] = "ID inválido para exclusão.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Buscar os arquivos do registro antes de excluir
        $stmt = $pdo->prepare("SELECT * FROM `$tabela` WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registro) {
            $_SESSION['error'] = "Registro não encontrado.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Remover arquivos associados
        foreach ($registro as $campo => $valor) {
            if (!empty($valor)) {
                if ($tabela === 'capas' && in_array($campo, ['capaDesktop', 'capaMobile'])) {
                    @unlink($uploadDirs['capas'][$campo === 'capaDesktop' ? 'desktop' : 'mobile'] . $valor);
                } elseif ($tabela === 'videos' && in_array($campo, ['vidCapa', 'vidLink'])) {
                    @unlink($uploadDirs['videos'][$campo === 'vidCapa' ? 'capa' : 'arquivo'] . $valor);
                } elseif ($tabela === 'materiais' && in_array($campo, ['matCapa', 'matLink'])) {
                    @unlink($uploadDirs['materiais'][$campo === 'matCapa' ? 'capa' : 'arquivo'] . $valor);
                }
            }
        }

        // Deletar o registro do banco
        $sql = "DELETE FROM `$tabela` WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $_SESSION['message'] = 'Registro excluído com sucesso!';
        header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "#$tabela");
        exit();
    }

} catch (Exception $e) {
    $_SESSION['error'] = "Erro: " . $e->getMessage();
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#erro");
    exit();
}
