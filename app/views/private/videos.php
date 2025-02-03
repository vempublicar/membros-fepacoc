<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

$videos = fetchVideos(); 
$assuntos = fetchAssunto(); 

// Pegando o assunto da URL
$assuntoSelecionado = isset($_GET['a']) ? urldecode($_GET['a']) : '';

// Filtrando os vídeos pelo assunto da URL
$videosFiltrados = array_filter($videos, function ($video) use ($assuntoSelecionado) {
    return isset($video['vidAssunto']) && $video['vidAssunto'] === $assuntoSelecionado;
});

// Definição da paginação
$videosPorPagina = 12;
$totalVideos = count($videosFiltrados);
$totalPaginas = ceil($totalVideos / $videosPorPagina);
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $videosPorPagina;

// Paginar os vídeos filtrados
$videosPagina = array_slice($videosFiltrados, $inicio, $videosPorPagina);

print_r($videos);
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4"><?= htmlspecialchars($assuntoSelecionado) ?></h3>

        <div class="row">
            <div class="col-lg-12">
                <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" id="videoGrid">
                    <?php if (!empty($videosPagina)): ?>
                        <?php foreach ($videosPagina as $video): ?>
                            <div class="col mb-4 portfolio-item">
                                <a href="#" data-bs-toggle="modal" 
                                   data-bs-target="#videoModal" 
                                   data-video-url="vendor/videos/play/<?= htmlspecialchars($video['vidLink']); ?>" 
                                   onclick="trackUserAction('<?= htmlspecialchars($video['vidTitulo']); ?>', '<?= htmlspecialchars($user['email'] ?? ''); ?>')">
                                    <img src="vendor/videos/capas/<?= htmlspecialchars($video['vidCapa']); ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                    <div class="mt-2">
                                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($video['vidTitulo']); ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($video['vidCat']); ?> - <?= htmlspecialchars($video['vidSetor']); ?></small>
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

                <!-- Paginação -->
                <?php if ($totalPaginas > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            <?php if ($paginaAtual > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="videos&a=<?= urlencode($assuntoSelecionado) ?>&pagina=<?= $paginaAtual - 1; ?>" aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?= $i == $paginaAtual ? 'active' : ''; ?>">
                                    <a class="page-link" href="videos&a=<?= urlencode($assuntoSelecionado) ?>&pagina=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($paginaAtual < $totalPaginas): ?>
                                <li class="page-item">
                                    <a class="page-link" href="videos&a=<?= urlencode($assuntoSelecionado) ?>&pagina=<?= $paginaAtual + 1; ?>" aria-label="Próximo">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
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
