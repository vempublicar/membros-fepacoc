<?php
session_start();
header('Content-Type: application/json');

// Inclua o arquivo de conexão com o banco de dados.
// Certifique-se de que o arquivo define, por exemplo, uma variável $conn (mysqli).
include "../../config/bd/connection.php";

// Verifica se os parâmetros foram enviados e se o usuário está logado
if (isset($_POST['tipo'], $_POST['favorito']) && isset($_SESSION['user_id'])) {
    $tipo     = $_POST['tipo'];
    $favorito = $_POST['favorito'];
    $idUser   = $_SESSION['user_id'];

    // Inicializa as variáveis para as colunas
    $assunto    = null;
    $video      = null;
    $ferramenta = null;

    // Define em qual coluna será salvo o favorito
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

    // Prepara o SQL para inserção.
    // Supondo que sua tabela se chame "favorito" com as colunas: id, assunto, video, ferramenta, usuario, created_at
    $stmt = $conn->prepare("INSERT INTO favorito (assunto, video, ferramenta, usuario, created_at) VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Erro na preparação da query: ' . $conn->error
        ]);
        exit;
    }

    // Bind dos parâmetros: usamos "s" para strings e "i" para inteiro
    // Se o id do usuário for inteiro, use "i"
    $stmt->bind_param("ssis", $assunto, $video, $ferramenta, $idUser);

    // Executa e verifica se foi inserido com sucesso
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
