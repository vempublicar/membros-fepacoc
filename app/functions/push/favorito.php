<?php
session_start();

// Certifique-se de que sua função de conexão PDO está definida no arquivo incluído
include "../../config/bd/connection.php"; // Esse arquivo deve conter, por exemplo, a função db_connect()

// Se a requisição não for POST, redirecione (ou retorne um erro JSON)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Validação dos dados recebidos
$tipo = $_POST['tipo'] ?? null;
$favoritoValue = $_POST['favorito'] ?? null;

if (!$tipo || !$favoritoValue) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Dados inválidos.'
    ]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Usuário não logado.'
    ]);
    exit();
}

$user = $_SESSION['user_id'];

// Inicializa as variáveis para as colunas da tabela (todas nulas, exceto a que for definida)
$assunto    = null;
$video      = null;
$ferramenta = null;

// Atribui o valor à coluna correspondente conforme o tipo recebido
if ($tipo === 'video') {
    $video = $favoritoValue;
} elseif ($tipo === 'assunto') {
    $assunto = $favoritoValue;
} elseif ($tipo === 'ferramenta') {
    $ferramenta = $favoritoValue;
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Tipo inválido.'
    ]);
    exit();
}

try {
    // Conecta ao banco usando PDO (a função db_connect() deve retornar um objeto PDO)
    $pdo = db_connect();

    // Construção da query SQL para inserir o favorito
    $sql = "INSERT INTO favorito (assunto, video, ferramenta, usuario, created_at) 
            VALUES (:assunto, :video, :ferramenta, :usuario, NOW())";
    
    $stmt = $pdo->prepare($sql);

    $params = [
        ':assunto'    => $assunto,
        ':video'      => $video,
        ':ferramenta' => $ferramenta,
        ':usuario'    => $user
    ];

    if ($stmt->execute($params)) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Favorito salvo com sucesso!'
        ]);
    } else {
        // Se a execução falhar, retorne o erro
        echo json_encode([
            'status'  => 'error',
            'message' => 'Erro ao salvar favorito: ' . implode(" - ", $stmt->errorInfo())
        ]);
    }
} catch (Exception $e) {
    // Em caso de exceção, retorne o erro em JSON (somente em desenvolvimento)
    echo json_encode([
        'status'  => 'error',
        'message' => 'Exceção: ' . $e->getMessage()
    ]);
}
