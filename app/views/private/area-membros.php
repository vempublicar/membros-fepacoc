<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";

$videos = [
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "vendor/videos/teste.mp4", "tipo" => "exclusivo"], 
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "vendor/videos/teste.mp4", "tipo" => "gratuito"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "vendor/videos/teste.mp4", "tipo" => "gratuito"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "vendor/videos/teste.mp4", "tipo" => "exclusivo"],
];
$videosAulas = [
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_1"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_2"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_3"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_4"],
];
$listaProdutos = [
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_1"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_2"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_3"],
];
$materialApoio = [
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_1"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_2"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_3"],
    ["capa" => "vendor/images/illustration-2.jpg", "url" => "https://www.youtube.com/embed/VIDEO_ID_4"],
];
?>
<section class="py-5 mt-3">
    <div class="container">
        <div class="rounded-4 p-5"
            style="background-image: url(vendor/images/section-banner.png); background-size: cover ; background-repeat: no-repeat; background-position: center;">
            <div class="row">
                <div class="col-md-4">
                    <div class="h-100 bg-black text-white p-4 rounded-4">
                        <h3>
                            References
                        </h3>
                        <div class="py-4">
                            <p class="text-light-emphasis">
                                1998 - 2004
                            </p>
                            <h5>
                                Dr. Stephen H. King
                            </h5>
                            <p class="text-light-emphasis">
                                Harvard School of Science and management
                            </p>
                        </div>
                        <p class="text-light-emphasis">
                            2004 - 2006
                        </p>
                        <h5>
                            Dr. David Howard
                        </h5>
                        <p class="text-light-emphasis">
                            Harvard School of Science and management
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row justify-content-center">

    <div id="filters" class="button-group d-flex flex-wrap gap-3 justify-content-center py-5" data-aos="fade-up">
        <a href="#" class="btn btn-primary text-decoration-none text-uppercase"
            data-filter=".illustrations">Sobre Fepacoc</a>
        <a href="#" class="btn btn-primary text-decoration-none text-uppercase" data-filter=".branding">Entregáveis</a>
        <a href="#" class="btn btn-primary text-decoration-none text-uppercase" data-filter=".branding">Planos e Preços</a>
        <a href="#" class="btn btn-primary text-decoration-none text-uppercase is-checked"
            data-filter=".photography">Área Exclusiva</a>
    </div>
</div>
<section class="portfolio py-5">
    <div class="container">
        <div class="justify-content-center">

            <div class="text-center">
                <h3 class="display-6 mb-5">
                    Vídeos curtos
                </h3>
            </div>
            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($videos as $video): ?>
                    <div class="col mb-4 portfolio-item photography">
                    <?php if ($video['tipo'] === 'exclusivo'): ?>
                                <i class="fas fa-crown exclusive-icon position-absolute ms-2" title="Conteúdo Exclusivo" ></i>
                            <?php endif; ?>
                            <a href="#" class="video-link" data-video-url="<?= $video['url']; ?>">
                            <img src="<?= $video['capa']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="videos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver todos vídeos
                </a>
            </div>
        </div>
    </div>
</section>
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
                <?php foreach ($videosAulas as $video): ?>
                    <div class="col mb-4 portfolio-item photography">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $video['url']; ?>">
                            <img src="<?= $video['capa']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="videos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
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
                <?php foreach ($listaProdutos as $video): ?>
                    <div class="col mb-4 portfolio-item photography">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $video['url']; ?>">
                            <img src="<?= $video['capa']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="videos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver todos vídeos
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
                <?php foreach ($videosAulas as $video): ?>
                    <div class="col mb-4 portfolio-item photography">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $video['url']; ?>">
                            <img src="<?= $video['capa']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center p-3">
                <a href="videos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver mais
                </a>
            </div>
        </div>
    </div>
</section>



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
</script>
</body>

</html>