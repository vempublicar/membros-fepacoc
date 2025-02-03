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
<section class="portfolio p-3">
            <div class="row">
                <div class="col text-start"><p class="text-uppercase text-secondary">Categorias</p></div>
                <div class="col text-end">
                    <a href="videos" class="text-uppercase text-info text-decoration-none">
                        Mais categorias
                    </a>
                </div>
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
</section>

<!-- PRODUTOS -->
<section class="portfolio p-3">
        <div class="row">
            <div class="col text-start">
                <p class="text-uppercase text-secondary">Produtos</p>
            </div>
            <div class="grid p-1 clearfix row row-cols-2 row-cols-lg-4" data-aos="fade-up">
                <?php 
                    $count = 0;
                    foreach ($produtos as $produto): 
                        if ($produto['proStatus'] === 'ativo' && $count < 4): 
                            $count++;
                ?>
                        <div class="col mb-4 portfolio-item photography">
                                <a href="#" onclick="openOffcanvas(
                                    '<?= htmlspecialchars($produto['proNome']); ?>', 
                                    '<?= $produto['proCapa']; ?>',
                                    '<?= number_format($produto['proPreco'], 2, ',', '.'); ?>',
                                    '<?= htmlspecialchars($produto['proSobre']); ?>',
                                    '<?= $produto['proPagina']; ?>'
                                    )">
                                    <img src="vendor/uploads/produtos/<?= $produto['proCapa']; ?>" 
                                         class="card-img-top rounded-top-4" 
                                         alt="<?= htmlspecialchars($produto['proNome']); ?>">
                                </a>
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
</section>

<!-- ASSUNTO -->
<section class="portfolio p-3">
            <div class="row">
                <div class="col text-start"><p class="text-uppercase text-secondary">Favoritos</p></div>                
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

</section>

<!-- MATERIAIS -->
<section class="portfolio">
            <div class="row">
                <div class="col text-start"><p class="text-uppercase text-secondary">Materiais</p></div>
                <div class="col text-end">
                    <a href="materiais" class="text-uppercase text-info text-decoration-none">
                        mais materiais
                    </a>
                </div>
            </div> 

            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($materiais as $material): ?>
                        <div class="col mb-4 portfolio-item photography">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $material['link']; ?>" onclick="trackUserAction('<?= $video['title']; ?>', <?= $user['email'] ?>)" >
                                <img src="vendor/uploads/materiais/capa/<?= $material['matCapa']; ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                            </a>
                            <button class="btn btn-icon float-end" onclick="openModal('<?= $material['id']; ?>')">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>
                <?php endforeach; ?>
            </div>

</section>

<!-- FERRAMENTAS -->
<section class="portfolio">
            <div class="row">
                <div class="col text-start"><p class="text-uppercase text-secondary">Ferramentas</p></div>
                <div class="col text-end">
                    <a href="ferramentas" class="text-uppercase text-info text-decoration-none">
                        mais ferramentas
                    </a>
                </div>
            </div> 

            <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
                <?php foreach ($ferramentas as $ferramenta): ?>
                    <?php if ($ferramenta['ferStatus'] === 'ativo'): ?>
                        <div class="col mb-4 portfolio-item photography">
                                <a href="<?= $ferramenta['ferLink']; ?>" target="_blank">
                                    <img src="vendor/uploads/ferramentas/<?= $ferramenta['ferCapa']; ?>" 
                                         class="card-img-top rounded-top-4" 
                                         alt="<?= htmlspecialchars($ferramenta['ferNome']); ?>">
                                </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
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


<!-- Bootstrap JavaScript Libraries -->
<script src="vendor/js/jquery-1.11.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> 
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="vendor/js/plugins.js"></script>
<script src="vendor/js/script.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>


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
<script>
    function openOffcanvas(title, image, price, description, link) {
        document.getElementById('offcanvasTitle').innerText = title;
        document.getElementById('offcanvasImage').src = 'vendor/img/produtos/capas/' + image;
        document.getElementById('offcanvasPrice').innerText = 'R$ ' + price;
        document.getElementById('offcanvasDescription').innerText = description;
        document.getElementById('offcanvasLink').href = link;

        var offcanvas = new bootstrap.Offcanvas(document.getElementById('productOffcanvas'));
        offcanvas.show();
    }
</script>

</body>
</html>