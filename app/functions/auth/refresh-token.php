<?php
function isTokenExpiring($token) {
    if($token != ""){
        $payload = json_decode(base64_decode(explode(".", $token)[1]), true);
        return (time() > ($payload['exp'] - 300)); // 300 segundos (5 minutos) antes do token expirar
    }
}


function refreshToken() {
    $refreshToken = $_SESSION['refresh_token']; // Supondo que você tenha armazenado o refresh token na sessão

    // Inicializar cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => SUPABASE_URL . "/auth/v1/token?grant_type=refresh_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(['refresh_token' => $refreshToken]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "apikey: " . SUPABASE_KEY,
        ],
    ]);

    // Executar a requisição
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    // print_r($response);

    if ($err) {
        // echo "Erro ao renovar o token: $err";
    } else {
        $decodedResponse = json_decode($response, true);
        if (isset($decodedResponse["access_token"])) {
            // Atualizar o token na sessão
            $_SESSION['user_token'] = $decodedResponse["access_token"];
            // Também atualizar o refresh token
            $_SESSION['refresh_token'] = $decodedResponse["refresh_token"];
        } else {
            // Tratar erro ao renovar o token
            // print_r($decodedResponse);
        }
    }
}


?>