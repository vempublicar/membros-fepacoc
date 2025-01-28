<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

$produtos = fetchProdutos();
$leads = fetchLeads();
// JSON com dados dos vídeos (capa, URL do vídeo do YouTube, título, categoria e setor)


$produtosPorPagina = 12; // Número ajustado para considerar a lógica de 13 a 25, 26 a 38, etc.
$totalProdutos = count($produtos);
$totalPaginas = ceil($totalProdutos / $produtosPorPagina);
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $produtosPorPagina;
$produtosPagina = array_slice($produtos, $inicio, $produtosPorPagina);

// print_r($videosPagina);
?>
<section class="top-banner  mt-5">
    <div class="container-fluid p-3">
        <picture>
            <!-- Versão para mobile -->
            <source media="(max-width: 768px)" style="width: 100vw" srcset="vendor/img/capa-produtos-mobile.jpg">
            <!-- Versão para desktops e tablets maiores -->
            <img src="vendor/img/capa-produtos-desk.jpg" style="width: 100vw" class="img-fluid rounded-4" alt="Capa do vídeo">
        </picture>
    </div>
    
</section>
<section class="portfolio py-5 mt-5">
    <div class="container">
    <h2 class="text-center mb-2">Produtos</h2>
    <p>Aqui você encontrará soluções pontuais que utilizam a metodologia FEPACOC para otimizar os processos e a operação da sua empresa.</p>
    <hr>
        <div class="row">
            <!--
                <div class="col-lg-3">
                    <div class="filters mb-4">
                        <h5 class="fw-bold">Filtros</h5>
                        <div class="mb-3">
                            <label for="pesquisa" class="form-label">Pesquisar</label>
                            <input type="text" id="pesquisa" class="form-control" placeholder="Digite o título do vídeo...">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select id="categoria" class="form-select">
                                <option value="">Todas</option>
                                <option value="Categoria 1">Categoria 1</option>
                                <option value="Categoria 2">Categoria 2</option>
                                <option value="Categoria 3">Categoria 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="setor" class="form-label">Setor</label>
                            <select id="setor" class="form-select">
                                <option value="">Todos</option>
                                <option value="Setor 2">Setor 2</option>
                                <option value="Setor 1">Setor 1</option>
                                <option value="Setor 3">Setor 3</option>
                            </select>
                        </div>
                    </div>
                </div>
            -->
            <div class="col-lg-12">
                <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" id="videoGrid" data-aos="fade-up">
                    <?php foreach ($produtosPagina as $produto): ?>
                        <div class="col mb-4 portfolio-item" data-categoria="<?= $produto['category']; ?>" data-setor="<?= $produto['sector']; ?>" data-titulo="<?= strtolower($produto['title']); ?>">
                        <div class="card border border-secondary bg-transparent">
                    <div class="card-body bg-transparent">
                        <a href="#" 
                                data-bs-toggle="modal" 
                                data-bs-target="#mediaModal" 
                                data-file-url="doc&file=<?= urlencode($produto['link']); ?>" 
                                onclick="trackUserAction('<?= $produto['title']; ?>', '<?= $user['email'] ?>')">
                                    <img src="vendor/img/produtos/capas/<?= $produto['cover']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                    
                                </a>
                            <div class="mt-2 text-center">
                                    <h6 class="fw-bold mb-0 "><?= $produto['title']; ?></h6>
                                    <small class="text-secondary"><?= $produto['category']; ?> - <?= $produto['sector']; ?></small><hr>
                                    <small class="text-secondary"><?= $produto['description']; ?>
                                </div>
                                </div>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Paginação -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <?php if ($paginaAtual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="produtos&pagina=<?= $paginaAtual - 1; ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= $i == $paginaAtual ? 'active' : ''; ?>">
                                <a class="page-link" href="produtos&pagina=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($paginaAtual < $totalPaginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="produtos&pagina=<?= $paginaAtual + 1; ?>" aria-label="Próximo">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Modal do Bootstrap para vídeos -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="mediaFrame" src="" frameborder="0" class="w-100 h-100"></iframe>
            </div>
        </div>
    </div>
</div>






<!-- Bootstrap JavaScript Libraries -->
<script src="vendor/js/jquery-1.11.0.min.js"></script> 

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> 
<script src="vendor/js/plugins.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>

<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<!-- <script src="vendor/js/script.js"></script> -->
 
<script>
    // Script para atualizar o URL do vídeo quando o modal for aberto
    var videoModal = document.getElementById('videoModal');
    videoModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botão que disparou o modal
        var videoUrl = button.getAttribute('data-video-url'); // Extrair o URL do vídeo do atributo data-video-url
        var videoFrame = document.getElementById('videoFrame');
        videoFrame.src = videoUrl; // Definir o src do iframe para o vídeo
    });

    // Script para parar o vídeo quando o modal for fechado
    videoModal.addEventListener('hidden.bs.modal', function () {
        var videoFrame = document.getElementById('videoFrame');
        videoFrame.src = ''; // Limpar o src do iframe
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var mediaModal = document.getElementById('mediaModal');
    var mediaGrid = document.getElementById('videoGrid');
    var mediaFrame = document.getElementById('mediaFrame');

    mediaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var mediaUrl = button.getAttribute('data-file-url');
        
        // Verifica o tipo de mídia pelo final da URL
        if (mediaUrl.endsWith('.pdf')) {
    alert(mediaUrl); // Exibe o valor de mediaUrl
    mediaFrame.src = mediaUrl;
} else {
    mediaFrame.src = mediaUrl + '?autoplay=1';
}
    });

    mediaModal.addEventListener('hidden.bs.modal', function () {
        mediaFrame.src = ''; // Limpa o iframe ao fechar
    });

    document.getElementById('categoria').addEventListener('change', filtrarVideos);
    document.getElementById('setor').addEventListener('change', filtrarVideos);
    document.getElementById('pesquisa').addEventListener('input', filtrarVideos);

    function filtrarVideos() {
        var categoria = document.getElementById('categoria').value;
        var setor = document.getElementById('setor').value;
        var pesquisa = document.getElementById('pesquisa').value.toLowerCase();
        var videos = document.querySelectorAll('#videoGrid .portfolio-item');

        videos.forEach(function (video) {
            var videoCategoria = video.getAttribute('data-categoria');
            var videoSetor = video.getAttribute('data-setor');
            var videoTitulo = video.getAttribute('data-titulo');

            if ((categoria === '' || categoria === videoCategoria) &&
                (setor === '' || setor === videoSetor) &&
                (pesquisa === '' || videoTitulo.includes(pesquisa))) {
                video.style.display = 'block';
            } else {
                video.style.display = 'none';
            }
        });
    }
});
</script>
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



    function trackUserAction(title, email) {
        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0]; // Formato: YYYY-MM-DD
        const formattedTime = date.toTimeString().split(' ')[0]; // Formato: HH:MM:SS

        // Dados a serem enviados
        const data = {
            title: title,
            email: email,
            date: formattedDate,
            time: formattedTime,
        };

        
        // Enviar via AJAX
        fetch('app/functions/push/track.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                console.log(result); // Log do sucesso ou erro
            })
            .catch(error => {
                console.error('Erro ao registrar a ação:', error);
            });
    }
</script>