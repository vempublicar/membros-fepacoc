<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

/**
 * Função para buscar os dados apenas se não estiverem na sessão.
 */
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

// Carregar dados dos vídeos (sessão ou banco de dados)
$videos = getSessionData('videos', 'fetchVideos');

// Captura o ID do vídeo via GET (ex.: visualizar.php?video=123)
$idvideo = isset($_GET['video']) ? $_GET['video'] : 0;

// Procura o vídeo correspondente no array de vídeos
$videoToView = null;
foreach ($videos as $video) {
    if ($video['id'] == $idvideo) {
        $videoToView = $video;
        break;
    }
}

// Caso o vídeo não seja encontrado, exibe uma mensagem
if (!$videoToView) {
    echo "<div class='container py-5'><h3>Vídeo não encontrado.</h3></div>";
    exit;
}

/**
 * Função para transformar a URL do YouTube para o formato embed.
 */
function transformarParaEmbedYouTube($url) {
    if (strpos($url, "youtube.com/watch?v=") !== false) {
        $videoID = explode("v=", $url)[1];
        $videoID = explode("&", $videoID)[0];
    } elseif (strpos($url, "youtu.be/") !== false) {
        $videoID = explode("youtu.be/", $url)[1];
        $videoID = explode("?", $videoID)[0];
    } else {
        $videoID = "";
    }
    return "https://www.youtube.com/embed/" . $videoID . "?rel=0&showinfo=0&autoplay=1";
}

/**
 * Função para transformar a URL do Vimeo para o formato embed.
 */
function transformarParaEmbedVimeo($url) {
    $videoID = explode("vimeo.com/", $url)[1];
    $videoID = explode("?", $videoID)[0];
    return "https://player.vimeo.com/video/" . $videoID . "?autoplay=1";
}

// Verifica se há link externo
if (!empty($videoToView['vidLinkExterno'])) {
    $videoUrl = htmlspecialchars($videoToView['vidLinkExterno']);
    $videoType = 'externo';

    // Verifica se o link é do YouTube ou Vimeo e transforma para embed se necessário
    if (strpos($videoUrl, "youtube.com") !== false || strpos($videoUrl, "youtu.be") !== false) {
        $videoUrl = transformarParaEmbedYouTube($videoUrl);
    } elseif (strpos($videoUrl, "vimeo.com") !== false) {
        $videoUrl = transformarParaEmbedVimeo($videoUrl);
    }
} else {
    // Caso não haja link externo, carrega o arquivo de vídeo local
    $videoUrl = "vendor/uploads/videos/arquivo/" . htmlspecialchars($videoToView['vidLink']);
    $videoType = 'local';
}
?>

<!-- Conteúdo da página de visualização -->
<section class="container py-5 mt-5">
    <h3 class="fw-bold mb-4 text-center"><?= htmlspecialchars($videoToView['vidTitulo']); ?></h3>

    <!-- Player do vídeo -->
    <div class="ratio ratio-16x9 mb-4">
        <?php if ($videoType === 'externo'): ?>
            <iframe src="<?= $videoUrl ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        <?php else: ?>
            <video controls autoplay class="w-100">
                <source src="<?= $videoUrl ?>" type="video/mp4">
                Seu navegador não suporta o elemento de vídeo.
            </video>
        <?php endif; ?>
    </div>

    <!-- Detalhes do vídeo -->
    <div class="mb-3">
        <strong>Resumo:</strong>
        <p><?= htmlspecialchars($videoToView['vidResumo']); ?></p>
    </div>
    <div class="mb-3">
        <strong>Descrição:</strong>
        <p><?= htmlspecialchars($videoToView['vidDesc']); ?></p>
    </div>
    <div class="mb-3">
        <strong>Produtor:</strong>
        <span><?= htmlspecialchars($videoToView['vidProdutor']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Formato:</strong>
        <span><?= htmlspecialchars($videoToView['vidFormato']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Setor:</strong>
        <span><?= htmlspecialchars($videoToView['vidSetor']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Categoria:</strong>
        <span><?= htmlspecialchars($videoToView['vidCat']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Assunto:</strong>
        <span><?= htmlspecialchars($videoToView['vidAssunto']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Tipo:</strong>
        <span><?= htmlspecialchars($videoToView['vidTipo']); ?></span>
    </div>
    <div class="mb-3">
        <strong>Situação:</strong>
        <span><?= htmlspecialchars($videoToView['vidSituacao']); ?></span>
    </div>
</section>


<?php include 'app/views/parts/barra.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;

        // Verifica o tema salvo no localStorage
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }

        // Alterna o tema
        themeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");
            const isDarkMode = body.classList.contains("dark-mode");
            localStorage.setItem("theme", isDarkMode ? "dark" : "light");
            themeToggle.innerHTML = isDarkMode ?
                '<i class="fas fa-moon"></i>' :
                '<i class="fas fa-sun"></i>';
        });
    });
</script>