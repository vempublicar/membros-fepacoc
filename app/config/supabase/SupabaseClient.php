<?php
include_once 'supabase_config.php';

class SupabaseClient {
    private $url;
    private $key;

    public function __construct() {
        $this->url = SUPABASE_URL;
        $this->key = SUPABASE_KEY;
    }

    public function listItemsFromTable($tableName) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . "/rest/v1/" . $tableName,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "apikey: " . $this->key,
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response, true);
        }
    }

    public function getItemByUserId($tableName, $userId) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . "/rest/v1/" . $tableName . "?select=*&user_id=eq." . $userId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->key,
                "apikey: " . $this->key,
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return null;
        } else {
            return json_decode($response, true);
        }
    }

    // Outros métodos da classe, se houver
}

?>
