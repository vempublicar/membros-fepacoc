<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

// Inclua o arquivo de conexão com o banco de dados
include "../../config/bd/connection.php";

if (isset($_POST['tipo'], $_POST['favorito']) && isset($_SESSION['user_id'])) {
    $tipo     = $_POST['tipo'];
    $favorito = $_POST['favorito'];
    $idUser   = $_SESSION['user_id'];

    // Inicializa as variáveis para as colunas
    $assunto    = null;
    $video      = null;
    $ferramenta = null;

    if ($tipo === 'video') {
        $video = $favorito;
    } elseif ($tipo === 'assunto') {
        $assunto = $favorito;
    } elseif ($tipo === 'ferramenta') {
        $ferramenta = $favorito;
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Tipo inválido.'
        ]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO favorito (assunto, video, ferramenta, usuario, created_at) VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Erro na preparação da query: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("ssis", $assunto, $video, $ferramenta, $idUser);

    if ($stmt->execute()) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Favorito salvo com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Erro ao salvar favorito: ' . $stmt->error
        ]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Dados inválidos ou usuário não logado.'
    ]);
}
?>
