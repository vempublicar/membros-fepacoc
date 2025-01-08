<img src="vendor/img/produtos/play/loja-lucrativa.jpg" alt="Teste de Imagem">
<?php
// Caminho base dos arquivos
$basePath = 'vendor/img/produto/play/';

// Obtenha o nome do arquivo solicitado (parâmetro GET)
$file = $_GET['file'] ?? null;

if ($file) {
    // Evite que acessem arquivos fora da pasta especificada
    $realPath = realpath($basePath . $file);
    echo 'teste';
print_r($realPath);
    if ($realPath && strpos($realPath, $basePath) === 0 && file_exists($realPath)) {
        // Determine o tipo MIME do arquivo
        $mimeType = mime_content_type($realPath);

        // Defina os cabeçalhos corretos
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($realPath));
        header('Content-Disposition: inline; filename="' . basename($realPath) . '"');

        // Leia e envie o arquivo
        readfile($realPath);
        exit;
    }
}

// Caso o arquivo não seja encontrado ou não seja permitido
http_response_code(404);
echo "Arquivo não encontrado ou acesso não permitido neste momento.".$file;