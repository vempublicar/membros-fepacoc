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
    /* Remove fundo preto ao fechar */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.8) !important;
    }

    /* Remove bordas e sombra do modal */
    .modal-content {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* Ajuste no botão de fechar */
    .btn-close {
        filter: invert(1); /* Deixa o botão branco */
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
                                   data-bs-toggle="modal" 
                                   data-bs-target="#videoModal" 
                                   data-video-url="<?= $videoUrl ?>" 
                                   data-video-type="<?= empty($video['vidLinkExterno']) ? 'local' : 'externo' ?>"
                                   onclick="trackUserAction('<?= htmlspecialchars($video['vidTitulo']); ?>', '<?= htmlspecialchars($user['email'] ?? ''); ?>')">
                                    
                                    <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($video['vidCapa']); ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                    
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
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Modal maior e centralizado -->
        <div class="modal-content border-0 bg-transparent"> <!-- Remove bordas e fundo padrão -->
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen" allowfullscreen></iframe>
                </div>
            </div>
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
