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

        $sql = "
            UPDATE leads SET dados = :dados, tipo = :tipo WHERE id = :id
        ";

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
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'update') {
            // Atualizar os dados do lead
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do lead não informado');

            $leadData = [
                'dados' => $_POST['dados'],
                'tipo' => $_POST['tipo'] ?? 'Gratuito',
            ];

            $response = updateLead($id, $leadData);

            if ($response['status'] === 'success') {
                header("Location: " . $_SERVER['HTTP_REFERER'] . "#leads");
            } else {
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&erro=falha#leads");
            }

        } elseif ($action === 'sendPassword') {
            // Enviar senha por e-mail
            $email = $_POST['email'] ?? null;
            $nome = $_POST['nome'] ?? null;
            $senha = $_POST['acesso'] ?? null;

            $resultadoEmail = enviarEmailRecuperar($email, $nome, $senha);

            if ($resultadoEmail === '1') {
                header("Location: " . $_SERVER['HTTP_REFERER'] . "#leads");
            } else {
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&erro=falha#leads");
            }

        } elseif ($action === 'addToBroadcast') {
            // Adicionar lead à lista de transmissão (agora MySQL)
            $listName = $_POST['list'] ?? null;
            if (!$listName) throw new Exception('Nome da lista de transmissão não informado');

            $leadData = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'fone' => $_POST['fone'],
            ];

            $response = saveToTransmite($listName, $leadData);
            echo json_encode($response);
        } elseif ($action === 'deleteLead') {
            // Excluir lead
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do lead não informado');

            $response = deleteLead($id);
            echo json_encode($response);
        } else {
            throw new Exception('Ação inválida');
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido']);
}
