<?php
// Caminho base absoluto dos arquivos
$basePath = '/vendor/img/produtos/play/';

// Obtenha o nome do arquivo solicitado (parâmetro GET)
$file = $_GET['file'] ?? null;
print_r($file);
if ($file) {
    // Resolva o caminho real do arquivo
    $realPath = realpath($basePath . $file);
print_r($realPath);
    // Verifique se o arquivo está dentro do diretório permitido e existe
    if ($realPath && strpos($realPath, $basePath) === 0 && file_exists($realPath)) {
        // Determine o tipo MIME do arquivo
        $mimeType = mime_content_type($realPath);

        // Cabeçalhos para exibir o PDF diretamente
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($realPath));
        header('Content-Disposition: inline; filename="' . basename($realPath) . '"');

        // Limpe buffers e leia o arquivo
        ob_clean();
        flush();
        readfile($realPath);
        exit;
    } else {
        // Caso o arquivo não seja encontrado ou esteja fora do diretório permitido
        http_response_code(404);
        echo "Arquivo não encontrado ou acesso não permitido.";
        exit;
    }
}

// Caso o parâmetro `file` não seja passado
http_response_code(400);
echo "Nenhum arquivo especificado.";