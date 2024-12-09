<?php
session_start();
include "../../config/supabase/supabase_config.php";
include "../email/envio-email.php";

// Função para enviar requisições ao Supabase
function sendSupabaseRequest($method, $endpoint, $data = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    $headers = [
        "Content-Type: application/json",
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
    ]);

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return ['status' => 'error', 'message' => $error];
    }

    return ['status' => 'success', 'http_code' => $httpCode, 'response' => json_decode($response, true)];
}

// Função para manipular o banco SQLite para listas de transmissão
function saveToBroadcastList($listName, $leadData) {
    $dbPath = '../db/broadcast_lists.sqlite';

    // Conectar ao banco SQLite
    $db = new SQLite3($dbPath);

    // Criar tabela caso não exista
    $db->exec("
        CREATE TABLE IF NOT EXISTS broadcast_list (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            list_name TEXT NOT NULL,
            lead_name TEXT NOT NULL,
            lead_email TEXT NOT NULL,
            lead_phone TEXT NOT NULL
        )
    ");

    // Inserir dados na tabela
    $stmt = $db->prepare("
        INSERT INTO broadcast_list (list_name, lead_name, lead_email, lead_phone)
        VALUES (:list_name, :lead_name, :lead_email, :lead_phone)
    ");
    $stmt->bindValue(':list_name', $listName, SQLITE3_TEXT);
    $stmt->bindValue(':lead_name', $leadData['nome'], SQLITE3_TEXT);
    $stmt->bindValue(':lead_email', $leadData['email'], SQLITE3_TEXT);
    $stmt->bindValue(':lead_phone', $leadData['fone'], SQLITE3_TEXT);
    $stmt->execute();

    return ['status' => 'success', 'message' => 'Lead adicionado à lista de transmissão'];
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
                'dados' => $_POST['dados'], // Dados complementares
                'tipo' => $_POST['tipo'] ?? 'Gratuito', // Atualiza o tipo para "Aluno" se necessário
            ];

            $response = sendSupabaseRequest('PATCH', "leads?id=eq.$id", $leadData);

            if ($response['status'] === 'success') {
                header("Location: ".$_SERVER['HTTP_REFERER']."#leads");
            } else {
                header("Location: ".$_SERVER['HTTP_REFERER']."&erro=falha#leads");
            }
        } elseif ($action === 'sendPassword') {
            $email = $_POST['email'] ?? null;
            $nome = $_POST['nome'] ?? null;
            $senha = $_POST['acesso'] ?? null;

            $resultadoEmail = enviarEmailRecuperar($email, $nome, $senha);

            if ($resultadoEmail === '1') {
                header("Location: ".$_SERVER['HTTP_REFERER']."#leads");
            } else {
                header("Location: ".$_SERVER['HTTP_REFERER']."&erro=falha#leads");
            }

            // Simular envio de e-mail (implementar lógica real posteriormente)
            // echo json_encode(['status' => 'success', 'message' => 'Senha enviada para o e-mail do lead']);
        } elseif ($action === 'addToBroadcast') {
            // Adicionar lead à lista de transmissão
            $listName = $_POST['list'] ?? null;
            if (!$listName) throw new Exception('Nome da lista de transmissão não informado');

            $leadData = [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'fone' => $_POST['fone'],
            ];

            $response = saveToBroadcastList($listName, $leadData);
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
