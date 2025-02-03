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
<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.8) !important;
    }
    .modal-content {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    .btn-close {
        filter: invert(1);
        font-size: 1.5rem;
    }
</style>
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
                                data-bs-toggle="offcanvas" 
                                data-bs-target="#videoOffcanvas" 
                                data-video-url="<?= $videoUrl ?>" 
                                data-video-type="<?= empty($video['vidLinkExterno']) ? 'local' : 'externo' ?>"
                                data-video-titulo="<?= htmlspecialchars($video['vidTitulo']); ?>"
                                data-video-resumo="<?= htmlspecialchars($video['vidResumo']); ?>"
                                data-video-descricao="<?= htmlspecialchars($video['vidDesc']); ?>"
                                data-video-produtor="<?= htmlspecialchars($video['vidProdutor']); ?>"
                                data-video-formato="<?= htmlspecialchars($video['vidFormato']); ?>"
                                data-video-setor="<?= htmlspecialchars($video['vidSetor']); ?>"
                                data-video-categoria="<?= htmlspecialchars($video['vidCat']); ?>"
                                data-video-assunto="<?= htmlspecialchars($video['vidAssunto']); ?>"
                                data-video-tipo="<?= htmlspecialchars($video['vidTipo']); ?>"
                                data-video-situacao="<?= htmlspecialchars($video['vidSituacao']); ?>"
                                onclick="abrirVideo(this)">
                                    
                                    <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($video['vidCapa']); ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                    
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
            </div>
        </div>
    </div>
</section>
<?php include_once "app/views/parts/footer.php"; ?>
<!-- Modal para exibição do vídeo -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="videoOffcanvas" aria-labelledby="videoOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="videoOffcanvasLabel">Detalhes do Vídeo</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Player do vídeo -->
        <div class="ratio ratio-16x9 mb-3">
            <iframe id="videoPlayer" src="" frameborder="0" allowfullscreen></iframe>
        </div>

        <!-- Informações do vídeo -->
        <h4 id="videoTitulo" class="fw-bold mb-2"></h4>
        <p id="videoResumo" class="text-muted mb-2"></p>
        <p id="videoDescricao"></p>

        <div class="mb-3">
            <strong>Produtor:</strong> <span id="videoProdutor"></span>
        </div>
        <div class="mb-3">
            <strong>Formato:</strong> <span id="videoFormato"></span>
        </div>
        <div class="mb-3">
            <strong>Setor:</strong> <span id="videoSetor"></span>
        </div>
        <div class="mb-3">
            <strong>Categoria:</strong> <span id="videoCategoria"></span>
        </div>
        <div class="mb-3">
            <strong>Assunto:</strong> <span id="videoAssunto"></span>
        </div>
        <div class="mb-3">
            <strong>Tipo:</strong> <span id="videoTipo"></span>
        </div>
        <div class="mb-3">
            <strong>Situação:</strong> <span id="videoSituacao"></span>
        </div>
    </div>
</div>

<script src="vendor/js/jquery-1.11.0.min.js"></script> <!-- jquery file-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> <!--cdn link-->
<script src="vendor/js/plugins.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="vendor/js/script.js"></script>
<script>
    function abrirVideo(element) {
        var videoUrl = element.getAttribute('data-video-url');
        var videoType = element.getAttribute('data-video-type');
        var videoPlayer = document.getElementById('videoPlayer');

        // Ajusta o player conforme o tipo de vídeo
        if (videoType === 'externo') {
            videoPlayer.src = videoUrl; // Link externo (YouTube/Vimeo)
        } else {
            videoPlayer.src = "vendor/uploads/videos/arquivo/" + videoUrl; // Vídeo local
        }

        // Define os detalhes do vídeo no offcanvas
        document.getElementById('videoTitulo').textContent = element.getAttribute('data-video-titulo');
        document.getElementById('videoResumo').textContent = element.getAttribute('data-video-resumo');
        document.getElementById('videoDescricao').textContent = element.getAttribute('data-video-descricao');
        document.getElementById('videoProdutor').textContent = element.getAttribute('data-video-produtor');
        document.getElementById('videoFormato').textContent = element.getAttribute('data-video-formato');
        document.getElementById('videoSetor').textContent = element.getAttribute('data-video-setor');
        document.getElementById('videoCategoria').textContent = element.getAttribute('data-video-categoria');
        document.getElementById('videoAssunto').textContent = element.getAttribute('data-video-assunto');
        document.getElementById('videoTipo').textContent = element.getAttribute('data-video-tipo');
        document.getElementById('videoSituacao').textContent = element.getAttribute('data-video-situacao');

        var offcanvas = new bootstrap.Offcanvas(document.getElementById('videoOffcanvas'));
        offcanvas.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var videoOffcanvas = document.getElementById('videoOffcanvas');
        var videoPlayer = document.getElementById('videoPlayer');

        videoOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            videoPlayer.src = ''; // Para o vídeo ao fechar o offcanvas
        });
    });

        // Função para rastrear a ação do usuário
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

