<?php
//curl -X POST -H "Content-Type: application/json" -d '{"id": "test_id", "type": "customer.created"}' https://members.fepacoc.com.br/webhook

// Caminho para o arquivo de log
$logFilePath = 'webhook_log.txt';

// Verifica se o arquivo de log existe
if (file_exists($logFilePath)) {
    // Abre o arquivo de log
    $file = fopen($logFilePath, "r");

    // Lê o conteúdo do arquivo de log
    echo "<h1>Conteúdo do Log de Webhook:</h1>";
    echo "<pre>";
    while (($line = fgets($file)) !== false) {
        echo htmlspecialchars($line) . "<br>";
    }
    echo "</pre>";

    // Fecha o arquivo
    fclose($file);
} else {
    echo "O arquivo de log não foi encontrado.";
}