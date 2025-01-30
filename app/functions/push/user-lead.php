<?php
session_start();
include "../../config/bd/connection.php"; // Conexão com o banco de dados MySQL
include "../email/envio-email.php";

// Função para salvar leads na tabela `transmite` no MySQL
function saveToTransmite($listName, $leadData) {
    try {
        $pdo = db_connect();

        $sql = "
            INSERT INTO transmite (nomeUsuario, emailUsuario, celUsuario, conteudo, dataEnvio, status)
            VALUES (:nome, :email, :celular, :conteudo, NOW(), 'pendente')
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $leadData['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $leadData['email'], PDO::PARAM_STR);
        $stmt->bindValue(':celular', $leadData['fone'], PDO::PARAM_STR);
        $stmt->bindValue(':conteudo', $listName, PDO::PARAM_STR);
        $stmt->execute();

        return ['status' => 'success', 'message' => 'Lead adicionado à lista de transmissão no MySQL'];
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Erro ao salvar no MySQL: ' . $e->getMessage()];
    }
}

// Função para atualizar o lead no MySQL
function updateLead($id, $dados) {
    try {
        $pdo = db_connect();

        // Converter para JSON apenas se for um array
        if (is_array($dados['dados'])) {
            $dados['dados'] = json_encode($dados['dados'], JSON_UNESCAPED_UNICODE);
        }

        // Verificar se o JSON é válido antes de salvar
        if (!json_decode($dados['dados'])) {
            throw new Exception('Formato de JSON inválido para a coluna `dados`.');
        }

        $sql = "UPDATE leads SET dados = :dados, tipo = :tipo WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':dados', $dados['dados'], PDO::PARAM_STR);
        $stmt->bindValue(':tipo', $dados['tipo'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return ['status' => 'success', 'message' => 'Lead atualizado com sucesso'];
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Erro ao atualizar o lead: ' . $e->getMessage()];
    }
}


// Função para excluir um lead do MySQL
function deleteLead($id) {
    try {
        $pdo = db_connect();

        // Verifica se o lead existe antes de excluir
        $checkStmt = $pdo->prepare("SELECT id FROM leads WHERE id = :id");
        $checkStmt->bindValue(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() === 0) {
            return ['status' => 'error', 'message' => 'Lead não encontrado.'];
        }

        $sql = "DELETE FROM leads WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return ['status' => 'success', 'message' => 'Lead excluído com sucesso'];
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => 'Erro ao excluir o lead: ' . $e->getMessage()];
    }
}

// Lidar com as requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'update') {
            // Atualizar os dados do lead
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do lead não informado.');

            $leadData = [
                'dados' => $_POST['dados'],
                'tipo' => $_POST['tipo'] ?? 'Gratuito',
            ];

            $response = updateLead($id, $leadData);
            echo json_encode($response);
            exit;

        } elseif ($action === 'sendPassword') {
            // Enviar senha por e-mail
            $email = $_POST['email'] ?? null;
            $nome = $_POST['nome'] ?? null;

            if (!$email) {
                throw new Exception('E-mail não informado.');
            }

            // Buscar a senha do lead no banco
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT acesso FROM leads WHERE email = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception('Usuário não encontrado.');
            }

            $senha = $user['acesso'];

            $resultadoEmail = enviarEmailRecuperar($email, $nome, $senha);

            if ($resultadoEmail === '1') {
                echo json_encode(['status' => 'success', 'message' => 'Senha enviada para o e-mail.']);
            } else {
                throw new Exception('Falha ao enviar o e-mail.');
            }
            exit;

        } elseif ($action === 'addToBroadcast') {
            // Adicionar lead à lista de transmissão (agora MySQL)
            $listName = $_POST['list'] ?? null;
            if (!$listName) throw new Exception('Nome da lista de transmissão não informado.');

            $leadData = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'fone' => $_POST['fone'],
            ];

            $response = saveToTransmite($listName, $leadData);
            echo json_encode($response);
            exit;

        } elseif ($action === 'deleteLead') {
            // Excluir lead
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do lead não informado.');

            $response = deleteLead($id);
            echo json_encode($response);
            exit;

        } else {
            throw new Exception('Ação inválida.');
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
    exit;
}
