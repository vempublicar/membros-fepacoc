<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de PDF e Imagem</title>
</head>
<body>
    <!-- Teste de Imagem -->
    <h3>Teste de Imagem</h3>
    <img src="vendor/img/produto/play/loja-lucrativa.jpg" style="height: 100px" alt="Teste de Imagem">
    <hr>

    <!-- Link para Abrir o PDF -->
    <h3>Teste de PDF</h3>
    <p>Clique no link abaixo para abrir o PDF:</p>
    <a href="?file=loja-lucrativa.pdf" target="_blank">Abrir PDF</a>

    <?php
    // Caminho base absoluto dos arquivos
    $basePath = __DIR__ . '/vendor/img/produto/play/';

    // Obtenha o nome do arquivo solicitado (parâmetro GET)
    $file = $_GET['file'] ?? null;

    if ($file) {
        // Resolva o caminho real do arquivo
        $realPath = realpath($basePath . $file);

        // Log de depuração
        error_log("Caminho base: $basePath");
        error_log("Arquivo solicitado: $file");
        error_log("Caminho real: $realPath");

        // Verifique se o caminho real está dentro do diretório base e se o arquivo existe
        if ($realPath && strpos($realPath, $basePath) === 0 && file_exists($realPath)) {
            // Determine o tipo MIME do arquivo
            $mimeType = mime_content_type($realPath);

            // Cabeçalhos para exibir o PDF
            header('Content-Type: ' . $mimeType);
            header('Content-Length: ' . filesize($realPath));
            header('Content-Disposition: inline; filename="' . basename($realPath) . '"');

            // Limpe buffers, se necessário, e leia o arquivo
            ob_clean();
            flush();
            readfile($realPath);
            exit;
        } else {
            error_log("Arquivo não encontrado ou fora do diretório permitido.");
        }
    }

    // Caso o arquivo não seja encontrado ou o acesso seja restrito
    http_response_code(404);
    echo "<p>Arquivo não encontrado ou acesso não permitido.</p>";
    ?>
</body>
</html>