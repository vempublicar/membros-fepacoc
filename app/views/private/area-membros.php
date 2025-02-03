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
$leads = fetchLeads();
$categorias = fetchCategorias();
$ferramentas = fetchFerramentas();
$capas = fetchCapas();
$assuntos = fetchAssunto();
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
                        <img src="vendor/uploads/capas/desktop/<?= htmlspecialchars($banner['capaDesktop']) ?>" 
                            class="d-block w-100 object-fit-cover" 
                            alt="Capa do vídeo"
                            style="max-height: 450px; height: 100%; object-fit: cover;">
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

<!-- CATEGORIAS -->
<section class="portfolio">
    <div class="container">
        <div class="justify-content-center">

            <div class="text-center">
                <h4 class="display-6">Categorias</h4>
            </div>

            <!-- Carrossel Swiper -->
            <div class="swiper mySwiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php 
                        $count = 0;
                        foreach ($categorias as $categoria): 
                            if ($categoria['catStatus'] === 'ativo' && $count < 8): 
                                $count++;
                    ?>
                    <div class="swiper-slide">
                        <a href="https://members.fepacoc.com.br/categoria&a=<?= $categoria['catNome']; ?>" 
                            onclick="trackUserAction('<?= $categoria['catNome']; ?>', '<?= $user['email'] ?>')">
                            <img src="vendor/uploads/categorias/<?= $categoria['catCapa']; ?>" class="img-fluid rounded-4" alt="Capa da categoria">
                        </a>
                    </div>
                    <?php 
                            endif;
                        endforeach;  
                    ?>
                </div>

                <!-- Controles do Carrossel -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="text-center p-1">
                <a href="videos" class="btn btn-link btn-lg mt-3 text-uppercase text-decoration-none">
                    Mais categorias
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ASSUNTO -->
<section class="portfolio">
    <div class="container">
        <div class="justify-content-center">

            <div class="text-center">
                <h4 class="display-6">Assuntos</h4>
            </div>

            <!-- Carrossel Swiper para Assuntos -->
            <div class="swiper mySwiperAssunto" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php 
                        $count = 0;
                        foreach ($assuntos as $item): 
                            if ($count < 8): 
                                $count++;
                    ?>
                    <div class="swiper-slide">
                        <a href="https://members.fepacoc.com.br/assunto&a=<?= urlencode($item['assunto']); ?>" 
                            onclick="trackUserAction('<?= $item['assunto']; ?>', '<?= $user['email'] ?>')">
                            <img src="vendor/uploads/assunto/<?= $item['assCapa']; ?>" class="img-fluid rounded-4" alt="<?= $item['assunto']; ?>">
                        </a>
                        <div class="text-center mt-2">
                            <strong><?= htmlspecialchars($item['assunto']); ?></strong>
                        </div>
                    </div>
                    <?php 
                            endif;
                        endforeach;  
                    ?>
                </div>

                <!-- Controles do Carrossel -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="text-center p-3">
                <a href="assuntos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver todos
                </a>
            </div>

        </div>
    </div>
</section>

<!-- PRODUTOS -->
<section class="p-5 bg-yellow py-5">
    <div class="container">
        <div class="text-center">
            <h3 class="display-6 mb-5">Produtos para sua empresa</h3>
        </div>
        <div class="justify-content-center">
            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-4" data-aos="fade-up">
                <?php 
                    $count = 0;
                    foreach ($produtos as $produto): 
                        if ($produto['type'] === 'Destaque' && $count < 4): 
                            $count++;
                ?>
                        <div class="col mb-4">
                            <div class="card shadow-sm rounded-4 border-0">
                                <a href="#" onclick="openOffcanvas(
                                    '<?= htmlspecialchars($produto['proNome']); ?>', 
                                    '<?= $produto['proCapa']; ?>',
                                    '<?= number_format($produto['proPreco'], 2, ',', '.'); ?>',
                                    '<?= htmlspecialchars($produto['proSobre']); ?>',
                                    '<?= $produto['proPagina']; ?>'
                                    )">
                                    <img src="vendor/img/produtos/capas/<?= $produto['proCapa']; ?>" 
                                         class="card-img-top rounded-top-4" 
                                         alt="<?= htmlspecialchars($produto['proNome']); ?>">
                                </a>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($produto['proNome']); ?></h5>
                                    <p class="card-text fw-bold text-primary">R$ <?= number_format($produto['proPreco'], 2, ',', '.'); ?></p>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="openOffcanvas(
                                        '<?= htmlspecialchars($produto['proNome']); ?>', 
                                        '<?= $produto['proCapa']; ?>',
                                        '<?= number_format($produto['proPreco'], 2, ',', '.'); ?>',
                                        '<?= htmlspecialchars($produto['proSobre']); ?>',
                                        '<?= $produto['proPagina']; ?>'
                                    )">
                                        <i class="fas fa-info-circle"></i> Detalhes
                                    </button>
                                </div>
                            </div>
                        </div>
                <?php 
                        endif;
                    endforeach;  
                ?>
            </div>

            <div class="text-center p-3">
                <a href="produtos" class="btn btn-outline-secondary btn-lg mt-3 text-uppercase text-decoration-none">
                    Ver Produtos
                </a>
            </div>

        </div>
    </div>
</section>

<?php print_r($ferramentas); ?>
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


 <div class="offcanvas offcanvas-end" tabindex="-1" id="productOffcanvas" aria-labelledby="offcanvasTitle">
    <div class="offcanvas-header">
        <h5 id="offcanvasTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <img id="offcanvasImage" src="" class="img-fluid rounded-4 mb-3" alt="">
        <p class="text-primary fw-bold" id="offcanvasPrice"></p>
        <p id="offcanvasDescription"></p>
        <a id="offcanvasLink" href="#" class="btn btn-primary w-100" target="_blank">Abrir Página</a>
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
<script>
    var swiperAssunto = new Swiper(".mySwiperAssunto", {
        slidesPerView: 2, // Para mobile
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 }, // Tablets
            1024: { slidesPerView: 4 }, // Desktop
        }
    });

    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 2, // Para mobile
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 }, // Tablets
            1024: { slidesPerView: 4 }, // Desktop
        }
    });
</script>
</body>

</html>