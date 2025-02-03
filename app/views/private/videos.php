<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Função para normalizar strings (remover acentos, espaços extras e converter para minúsculas)
function normalizarTexto($texto) {
    $texto = trim($texto); // Remove espaços extras
    $texto = strtolower($texto); // Converte para minúsculas
    $texto = preg_replace('/\s+/', ' ', $texto); // Remove espaços duplicados
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); // Remove acentos
    return $texto;
}

$videos = fetchVideos();

// Pegando o assunto da URL e normalizando
$assuntoSelecionado = isset($_GET['assunto']) ? urldecode($_GET['assunto']) : '';
$assuntoSelecionado = normalizarTexto($assuntoSelecionado);

// Filtrando os vídeos pelo assunto normalizado
$videosFiltrados = array_filter($videos, function ($video) use ($assuntoSelecionado) {
    if (!isset($video['vidAssunto'])) return false;
    return normalizarTexto($video['vidAssunto']) === $assuntoSelecionado;
});
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Vídeos sobre <?= htmlspecialchars(ucwords($assuntoSelecionado)) ?></h3>

        <div class="row">
            <div class="col-lg-12">
                <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" id="videoGrid">
                    <?php if (!empty($videosFiltrados)): ?>
                        <?php foreach ($videosFiltrados as $video): ?>
                            <?php
                                // Definir a URL do vídeo (externo ou local)
                                $videoUrl = !empty($video['vidLinkExterno']) 
                                    ? htmlspecialchars($video['vidLinkExterno']) 
                                    : "vendor/uploads/videos/arquivo/" . htmlspecialchars($video['vidLink']);
                            ?>
                            <div class="col mb-4 portfolio-item">
                                <a href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#videoModal" 
                                   data-video-url="<?= $videoUrl ?>" 
                                   data-video-type="<?= empty($video['vidLinkExterno']) ? 'local' : 'externo' ?>"
                                   onclick="trackUserAction('<?= htmlspecialchars($video['vidTitulo']); ?>', '<?= htmlspecialchars($user['email'] ?? ''); ?>')">
                                    
                                    <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($video['vidCapa']); ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                    
                                    <div class="mt-2">
                                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($video['vidTitulo']); ?></h6>
                                        <small class="text-muted"><?= $videoUrl; ?> - <?= htmlspecialchars($video['vidSetor']); ?></small>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p class="text-muted">Nenhum vídeo encontrado para este assunto.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para exibição do vídeo -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Vídeo</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var videoModal = document.getElementById('videoModal');

        videoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var videoUrl = button.getAttribute('data-video-url');
            var videoFrame = document.getElementById('videoFrame');
            videoFrame.src = videoUrl;
        });

        videoModal.addEventListener('hidden.bs.modal', function () {
            var videoFrame = document.getElementById('videoFrame');
            videoFrame.src = '';
        });
    });

    function trackUserAction(title, email) {
        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0];
        const formattedTime = date.toTimeString().split(' ')[0];

        const data = {
            title: title,
            email: email,
            date: formattedDate,
            time: formattedTime,
        };

        fetch('app/functions/push/track.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);
            })
            .catch(error => {
                console.error('Erro ao registrar a ação:', error);
            });
    }
</script>
