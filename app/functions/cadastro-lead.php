<?php
    function inserirDadosSupabase($tabela, $dados) {
        // Carregar a configuração do Supabase
        require_once '../config/supabase/supabase_config.php';

        // Inicializar cURL para enviar a requisição ao Supabase
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => SUPABASE_URL . "/rest/v1/" . $tabela,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "apikey: " . SUPABASE_KEY,
                "Authorization: Bearer " . SUPABASE_KEY
            ],
        ]);

        // Executar a requisição e obter a resposta
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ["status" => "error", "error" => $err];
        } else {
            if ($info['http_code'] == 201) {
                return ["status" => "success", "info" => $info, "response" => $response];
            } else {
                return ["status" => "error", "info" => $info, "response" => $response];
            }
        }
    }

?>
