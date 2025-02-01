<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";
if (isset($_SESSION['user_dados'])) {
    $userDados = json_decode($_SESSION['user_dados'], true);
    $email = $userDados['user']['email'];  // Acessa o email do usuário logado

    // Busca os dados do usuário com base no email
    $usuarios = fetchLeads();
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] == $email) {
            $user = $usuario;
            break;
        }
    }
} else {
    echo "Usuário não logado.";
    header('Location: login');
    // exit;
}
$videos = fetchVideos();
$produtos = fetchProdutos();
$materiais = fetchMateriais();
$capas = fetchCapas();
// print_r($materiais);
?>
<section class="top-banner mt-5">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php foreach ($capas as $index => $banner): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <picture>
                        <!-- Versão para mobile -->
                        <source media="(max-width: 768px)" srcset="vendor/uploads/capas/mobile/<?= htmlspecialchars($banner['capaMobile']) ?>">
                        <!-- Versão para desktops e tablets maiores -->
                        <img src="vendor/uploads/capas/desktop/<?= htmlspecialchars($banner['capaDesktop']) ?>" class="d-block w-100 vh-100 object-fit-cover" alt="Capa do vídeo">
                    </picture>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles do carrossel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</section>


<section class="portfolio py-5">
    <div class="container">
        <div class="justify-content-center">

            <div class="text-center">
                <h3 class="display-6 mb-5">
                    Vídeos Curtos
                </h3>
            </div>
            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($videos as $video): ?>
                    <?php if ($video['form'] === 'Video Curto'): ?>
                        <div class="col mb-4 portfolio-item photography">
                            <?php if ($video['type'] === 'Pago'): ?>
                                <i class="fas fa-crown exclusive-icon position-absolute ms-2" title="Conteúdo Exclusivo"></i>
                            <?php endif; ?>
                            <a href="#" class="video-link" data-video-url="vendor/videos/play/<?= $video['link']; ?>" onclick="trackUserAction('<?= $video['title']; ?>', <?= $user['email'] ?>)">
                                <img src="vendor/img/videos/capas/<?= $video['cover']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                            </a>
                            <button class="btn btn-icon float-end" onclick="openModal('<?= $video['id']; ?>')">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>

                    <?php endif; ?>
                <?php endforeach;  ?>
            </div>

            <div class="text-center p-3">
                <a href="videos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver todos vídeos
                </a>
            </div>
        </div>
    </div>
</section>
<?php // print_r($_SESSION['user_dados']); 
?>
<section class="p-5 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="d-flex gap-2 align-items-start">
                    <div class="icon">
                        <svg class="text-primary monitor" width="50" height="50">
                            <use xlink:href="#monitor"></use>
                        </svg>
                    </div>
                    <div class="text-md-start">
                        <h5>
                            UI/UX Design
                        </h5>
                        <p class="postf">
                            At in proin consequat ut cursus venenatis sapien.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex gap-2 align-items-start">
                    <div class="icon">
                        <svg class="text-primary notes" width="50" height="50">
                            <use xlink:href="#notes"></use>
                        </svg>
                    </div>
                    <div class="text-md-start">
                        <h5>
                            Illustration
                        </h5>
                        <p class="postf">
                            At in proin consequat ut cursus venenatis sapien.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex gap-2 align-items-start">
                    <div class="icon">
                        <svg class="text-primary laptop" width="50" height="50">
                            <use xlink:href="#laptop"></use>
                        </svg>
                    </div>
                    <div class="text-md-start">
                        <h5>
                            Graphic Design
                        </h5>
                        <p class="postf">
                            At in proin consequat ut cursus venenatis sapien.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="portfolio py-5">
    <div class="container">
        <div class="justify-content-center ">
            <div class="text-center">
                <h3 class="display-6 mb-5">
                    Últimas Aulas
                </h3>
            </div>
            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($videos as $video): ?>
                    <?php if ($video['form'] === 'Aula'): ?>
                        <div class="col mb-4 portfolio-item photography">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $video['link']; ?>">
                                <img src="vendor/img/aulas/capas/<?= $video['cover']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo" onclick="trackUserAction('<?= $video['title']; ?>', <?= $user['email'] ?>)" >
                            </a>
                            <button class="btn btn-icon float-end" onclick="openModal('<?= $video['id']; ?>')">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="aulas" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver mais
                </a>
            </div>
        </div>
    </div>
</section>

<section class="p-5 bg-yellow py-5">
    <div class="container">
        <div class="text-center">
            <h3 class="display-6 mb-5">
                Produtos para sua empresa
            </h3>
        </div>
        <div class="justify-content-center">

            <div class="grid p-0 clearfix row row-cols-1 row-cols-lg-3 " data-aos="fade-up">
                <?php foreach ($produtos as $produto): ?>
                    <?php if ($produto['type'] === 'Destaque'): ?>
                        <div class="col mb-4 portfolio-item photography">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $produto['link']; ?>" onclick="trackUserAction('<?= $video['title']; ?>', <?= $user['email'] ?>)" >
                                <img src="vendor/img/produtos/capas/<?= $produto['cover']; ?>" class="img-fluid rounded-4" alt="Capa do Produto">
                            </a>
                            <button class="btn btn-icon float-end" onclick="openModal('<?= $produto['id']; ?>')">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="produtos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver Produtos
                </a>
            </div>
        </div>
    </div>
</section>

<section class="portfolio py-5">
    <div class="container">
        <div class="justify-content-center ">
            <div class="text-center">
                <h3 class="display-6 mb-5">
                    Materiais de Apoio
                </h3>
            </div>

            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($materiais as $material): ?>
                    <?php if ($material['type'] === 'Gratuito'): ?>
                        <div class="col mb-4 portfolio-item photography">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $material['link']; ?>" onclick="trackUserAction('<?= $video['title']; ?>', <?= $user['email'] ?>)" >
                                <img src="vendor/img/materiais/capas/<?= $material['cover']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                            </a>
                            <button class="btn btn-icon float-end" onclick="openModal('<?= $material['id']; ?>')">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="material" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver mais
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Rodapé -->
 <?php include "app/views/parts/footer.php" ?>
<!-- Modal do Bootstrap para vídeos -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Vídeo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Avaliação -->
<div class="modal" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Avaliar Vídeo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="ratingForm" action="app/functions/push/avalia-aula.php" method="POST">
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Seu Comentário</label>
                        <textarea class="form-control" id="reviewText" name="reviewText" rows="5" required></textarea>
                    </div>
                    <label for="reviewText" class="form-label">Avalie o conteúdo</label>
                    <div class="star-rating">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="">
                    <p id="rating-value" class="mt-2"></p>
                    <input type="hidden" id="videoId" name="videoId">
                    <!-- Campo oculto para o email do usuário -->
                    <input type="hidden" name="userEmail" value="<?php echo $user['email']; ?>">
                    <!-- Campo oculto para a data atual no formato brasileiro -->
                    <input type="hidden" name="currentDate" value="<?php echo date('d/m/Y'); ?>">
                    <button type="submit" class="btn btn-primary float-end">Enviar Avaliação</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="videoLightbox" class="video-lightbox d-none">
    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" id="closeLightbox" aria-label="Close"></button>
    <div class="video-container">
        <video id="videoPlayer" controls class="rounded-4 video-element">
            <source src="" type="video/mp4">
            Seu navegador não suporta o elemento de vídeo.
        </video>
    </div>
</div>
<script>
    // Script para atualizar o URL do vídeo quando o modal for aberto
    var videoModal = document.getElementById('videoModal');
    videoModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Botão que disparou o modal
        var videoUrl = button.getAttribute('data-video-url'); // Extrair o URL do vídeo do atributo data-video-url
        var videoFrame = document.getElementById('videoFrame');
        videoFrame.src = videoUrl; // Definir o src do iframe para o vídeo
    });

    // Script para parar o vídeo quando o modal for fechado
    videoModal.addEventListener('hidden.bs.modal', function() {
        var videoFrame = document.getElementById('videoFrame');
        videoFrame.src = ''; // Limpar o src do iframe
    });
</script>
<!-- Bootstrap JavaScript Libraries -->
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
    function openModal(videoId) {
        // Define o valor do id do vídeo no campo oculto
        document.getElementById('videoId').value = videoId;

        // Abre o modal
        $('#ratingModal').modal('show');
    }
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".star-rating .star");
        const ratingInput = document.getElementById("rating-input");

        stars.forEach((star, index) => {
            star.addEventListener("click", function() {
                // Define o valor no input oculto
                ratingInput.value = index + 1;

                // Atualiza as classes das estrelas
                stars.forEach((s, i) => {
                    s.classList.toggle("active", i <= index);
                });
            });
        });
    });

    // Adicione um ouvinte de evento para o formulário de envio, se necessário
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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoLinks = document.querySelectorAll('.video-link');
        const videoLightbox = document.getElementById('videoLightbox');
        const videoPlayer = document.getElementById('videoPlayer');
        const closeLightbox = document.getElementById('closeLightbox');

        // Abrir o lightbox do vídeo
        videoLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const videoUrl = link.getAttribute('data-video-url');
                videoPlayer.querySelector('source').setAttribute('src', videoUrl);
                videoPlayer.load();
                videoLightbox.classList.remove('d-none');
            });
        });

        // Fechar o lightbox do vídeo
        closeLightbox.addEventListener('click', function() {
            videoLightbox.classList.add('d-none');
            videoPlayer.pause();
            videoPlayer.currentTime = 0;
        });

        // Fechar lightbox ao clicar fora do vídeo
        videoLightbox.addEventListener('click', function(event) {
            if (event.target === videoLightbox) {
                videoLightbox.classList.add('d-none');
                videoPlayer.pause();
                videoPlayer.currentTime = 0;
            }
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
</body>

</html>