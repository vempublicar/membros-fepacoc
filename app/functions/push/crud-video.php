<?php
session_start();
include "../../config/supabase/supabase_config.php";

// Função para enviar requisições cURL ao Supabase
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

// Função para gerenciar o upload de arquivos
function handleFileUpload($file, $uploadDir) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = uniqid('video_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $destination = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            // Preparar os dados do vídeo
            $videoData = [
                'form' => $_POST['form'],
                'title' => $_POST['videoTitle'],
                'short' => $_POST['videoShort'],
                'link' => $_POST['videoLink'],
                'cover' => null, // Caminho da capa
                'sector' => $_POST['videoSector'],
                'category' => $_POST['videoCategory'],
                'type' => $_POST['videoType'],
                'status' => $_POST['status'],
                'description' => $_POST['videoDesc']
            ];

            
            // Enviar os dados para o Supabase
            $formMap = [
                'Video Curto' => ['table' => 'videos', 'hash' => 'videos'],
                'Produto' => ['table' => 'produtos', 'hash' => 'produtos'],
                'Material' => ['table' => 'materiais', 'hash' => 'materiais'],
                'Aula' => ['table' => 'videos', 'hash' => 'aulas']
            ];
            $formType = $formMap[$_POST['form']];
            $hash = $formType['hash'];
            $table = $formType['table'];
            
            if($_POST['form'] == 'Video Curto'){
                $response = sendSupabaseRequest('POST', 'videos', $videoData);
            }
            if($_POST['form'] == 'Produto'){
                $response = sendSupabaseRequest('POST', 'produtos', $videoData);
            }
            if($_POST['form'] == 'Material'){
                $response = sendSupabaseRequest('POST', 'materiais', $videoData);
            }
            if($_POST['form'] == 'Aula'){
                $response = sendSupabaseRequest('POST', 'videos', $videoData);
            }

            // Gerenciar upload da capa do vídeo
            if (isset($_FILES['videoCover'])) {
                $uploadDir = "../../../vendor/img/".$hash."/capas/";
                $uploadedFile = handleFileUpload($_FILES['videoCover'], $uploadDir);
                if ($uploadedFile) {
                    $videoData['cover'] = $uploadedFile;
                }
            }

            // Verificar a resposta e redirecionar
            if ($response['status'] === 'success' && $response['http_code'] === 201) {
                header("Location: ".$_SERVER['HTTP_REFERER'].'#'.$hash);
                exit;
            } else {
                header("Location: ".$_SERVER['HTTP_REFERER'].'#'.$hash);
                exit;
            }
            

        } elseif ($action === 'update') {
            // Atualizar vídeo existente
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('ID do vídeo não informado');

            $videoData = [
                'form' => $_POST['form'],
                'title' => $_POST['videoTitle'],
                'short' => $_POST['videoShort'],
                'link' => $_POST['videoLink'],
                'sector' => $_POST['videoSector'],
                'category' => $_POST['videoCategory'],
                'type' => $_POST['videoType'],
                'status' => $_POST['status'],
                'description' => $_POST['videoDesc']
            ];

            // Gerenciar upload da capa do vídeo, se houver
            if (isset($_FILES['videoCover'])) {
                $uploadDir = "../../../vendor/videos/capas/";
                $uploadedFile = handleFileUpload($_FILES['videoCover'], $uploadDir);
                if ($uploadedFile) {
                    $videoData['cover'] = $uploadedFile;
                }
            }

            // Enviar atualização para o Supabase
            $response = sendSupabaseRequest('PATCH', "videos?id=eq.$id", $videoData);
            if($_POST['form'] == 'Video Curto'){$hash = '#videos';}
            if($_POST['form'] == 'Produto'){$hash = '#produtos';}
            if($_POST['form'] == 'Serviço'){$hash = '#servicos';}
            if($_POST['form'] == 'Aula'){$hash = '#aulas';}
            if ($response['status'] === 'success' && $response['http_code'] === 204) {
                header("Location: ".$_SERVER['HTTP_REFERER'].$hash);
                exit;
            } else {
                header("Location: ".$_SERVER['HTTP_REFERER'].$hash);
                exit;
            }

        } elseif ($action === 'delete') {
            // Excluir vídeo
            $id = $_POST['id'] ?? null;
            $tabela = $_POST['tabela'] ?? null;
            if (!$id) throw new Exception('ID do vídeo não informado');

            $response = sendSupabaseRequest('DELETE', "$tabela?id=eq.$id");
            echo json_encode($response);

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ação inválida']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido']);
}
