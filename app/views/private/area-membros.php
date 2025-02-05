<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

if (isset($_SESSION['user_dados'])) {
    $userDados = json_decode($_SESSION['user_dados'], true);
    $email = $userDados['user']['email'];  // Email do usuário logado

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

session_start(); // Garante que a sessão esteja ativa

// Função para buscar os dados apenas se não estiverem na sessão
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

// Carregar dados da sessão ou do banco de dados
$videos = getSessionData('videos', 'fetchVideos');
$produtos = getSessionData('produtos', 'fetchProdutos');
$materiais = getSessionData('materiais', 'fetchMateriais');
$leads = getSessionData('leads', 'fetchLeads');
$categorias = getSessionData('categorias', 'fetchCategorias');
$ferramentas = getSessionData('ferramentas', 'fetchFerramentas');
$capas = getSessionData('capas', 'fetchCapas');
$assuntos = getSessionData('assuntos', 'fetchAssunto');
$favoritos = fetchFavoritos();

// Agrupar os favoritos – cada registro tem somente um valor preenchido entre as colunas: assunto, video ou ferramenta.
$favAssuntosIds = [];
$favVideosIds = [];
$favFerramentasIds = [];
foreach ($favoritos as $fav) {
    if (!empty($fav['assunto'])) {
        $favAssuntosIds[] = $fav['assunto'];
    } elseif (!empty($fav['video'])) {
        $favVideosIds[] = $fav['video'];
    } elseif (!empty($fav['ferramenta'])) {
        $favFerramentasIds[] = $fav['ferramenta'];
    }
}
$favAssuntosIds = array_unique($favAssuntosIds);
$favVideosIds = array_unique($favVideosIds);
$favFerramentasIds = array_unique($favFerramentasIds);

// Filtrar os arrays mestras com base nos valores favoritados
$favAssuntos = array_filter($assuntos, function($item) use ($favAssuntosIds) {
    return in_array($item['assunto'], $favAssuntosIds);
});
$favVideos = array_filter($videos, function($item) use ($favVideosIds) {
    return in_array($item['id'], $favVideosIds);
});
$favFerramentas = array_filter($ferramentas, function($item) use ($favFerramentasIds) {
    return in_array($item['id'], $favFerramentasIds);
});
?>
<!-- Banner -->
<section class="top-banner mt-5">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php foreach ($capas as $index => $banner): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <picture>
                        <!-- Versão para mobile -->
                        <source media="(max-width: 768px)" srcset="vendor/uploads/capas/mobile/<?= htmlspecialchars($banner['capaMobile']) ?>">
                        <!-- Versão para desktops -->
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
        <div class="col text-start">
            <p class="text-uppercase text-secondary">
                Categorias | 
                <a href="categoria" class="text-uppercase text-light text-decoration-none">Ver Todos</a>
            </p>
        </div>
    </div>
    <!-- Carrossel Swiper para Categorias -->
    <div class="swiper mySwiperCategorias" data-aos="fade-up">
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
        <!-- Controles do Carrossel com classes específicas -->
        <div class="swiper-button-prev swiper-button-prev-categorias"></div>
        <div class="swiper-button-next swiper-button-next-categorias"></div>
        <div class="swiper-pagination swiper-pagination-categorias"></div>
    </div>
</section>

<!-- PRODUTOS -->
<section class="produto p-4">
    <div class="row">
        <div class="col text-start">
            <p class="text-uppercase text-secondary">
                Produtos | 
                <a href="produtos" class="text-uppercase text-light text-decoration-none">Ver Todos</a>
            </p>
        </div>
        <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-4" data-aos="fade-up">
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
    </div>
</section>

<!-- ASSUNTOS FAVORITOS -->
<section class="portfolio p-3">
    <div class="row">
        <div class="col text-start">
            <?php if (!empty($favAssuntos)) { ?>
                <p class="text-uppercase text-secondary">
                    Assuntos Favoritos | 
                    <a href="favoritos" class="text-uppercase text-light text-decoration-none">Ver Todos</a>
                </p>
            <?php } ?>
        </div>
    </div>
    <div class="swiper mySwiperAssunto" data-aos="fade-up">
        <div class="swiper-wrapper">
            <?php 
            $count = 0;
            foreach ($favAssuntos as $item): 
                if ($count < 12): 
                    $count++;
            ?>
            <div class="swiper-slide">
                <a href="https://members.fepacoc.com.br/videos&assunto=<?= urlencode($item['assunto']); ?>" 
                   onclick="trackUserAction('<?= $item['assunto']; ?>', '<?= $user['email']; ?>')">
                    <img src="vendor/uploads/assunto/<?= $item['assCapa']; ?>" class="img-fluid rounded-4" alt="<?= $item['assunto']; ?>">
                </a>
            </div>
            <?php 
                endif;
            endforeach;  
            ?>
        </div>
        <div class="swiper-button-prev swiper-button-prev-assuntos"></div>
        <div class="swiper-button-next swiper-button-next-assuntos"></div>
        <div class="swiper-pagination swiper-pagination-assuntos"></div>
    </div>
</section>

<!-- VÍDEOS FAVORITOS -->
<section class="portfolio p-3">
    <div class="row">
        <div class="col text-start">
            <?php if (!empty($favVideos)) { ?>
                <p class="text-uppercase text-secondary">
                    Vídeos Favoritos
                </p>
            <?php } ?>
        </div>
    </div>
    <div class="swiper mySwiperVideos" data-aos="fade-up">
        <div class="swiper-wrapper">
            <?php 
            $count = 0;
            foreach ($favVideos as $item): 
                if ($count < 8): 
                    $count++;
            ?>
            <div class="swiper-slide">
                <a href="https://members.fepacoc.com.br/videos&video=<?= urlencode($item['id']); ?>" 
                   onclick="trackUserAction('<?= $item['id']; ?>', '<?= $user['email']; ?>')">
                    <img src="vendor/uploads/videos/capa/<?= $item['vidCapa']; ?>" class="img-fluid rounded-4" alt="<?= $item['titulo'] ?? 'Vídeo'; ?>">
                </a>
            </div>
            <?php 
                endif;
            endforeach;  
            ?>
        </div>
        <!-- Controles específicos para vídeos favoritos -->
        <div class="swiper-button-prev swiper-button-prev-videos"></div>
        <div class="swiper-button-next swiper-button-next-videos"></div>
        <div class="swiper-pagination swiper-pagination-videos"></div>
    </div>
</section>

<!-- FERRAMENTAS FAVORITAS -->
<section class="portfolio p-3">
    <div class="row">
        <div class="col text-start">
            <?php if (!empty($favFerramentas)) { ?>
                <p class="text-uppercase text-secondary">
                    Ferramentas Favoritas
                </p>
            <?php } ?>
        </div>
    </div>
    <div class="swiper mySwiperFerramenta" data-aos="fade-up">
        <div class="swiper-wrapper">
            <?php 
            $count = 0;
            foreach ($favFerramentas as $item): 
                if ($count < 8): 
                    $count++;
            ?>
            <div class="swiper-slide">
                <a href="https://members.fepacoc.com.br/videos&ferramenta=<?= urlencode($item['id']); ?>" 
                   onclick="trackUserAction('<?= $item['id']; ?>', '<?= $user['email']; ?>')">
                    <img src="vendor/uploads/ferramentas/<?= $item['ferCapa']; ?>" class="img-fluid rounded-4" alt="<?= $item['ferNome']; ?>">
                </a>
            </div>
            <?php 
                endif;
            endforeach;  
            ?>
        </div>
        <div class="swiper-button-prev swiper-button-prev-ferramentas"></div>
        <div class="swiper-button-next swiper-button-next-ferramentas"></div>
        <div class="swiper-pagination swiper-pagination-ferramentas"></div>
    </div>
</section>

<!-- MATERIAIS -->
<section class="portfolio p-3">
    <div class="row">
        <div class="col text-start">
            <p class="text-uppercase text-secondary">
                Materiais | 
                <a href="materiais" class="text-uppercase text-light text-decoration-none">Ver Todos</a>
            </p>
        </div>
    </div>
    <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
        <?php foreach ($materiais as $material): ?>
            <div class="col mb-4 portfolio-item photography">
                <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="<?= $material['link']; ?>" onclick="trackUserAction('<?= $material['title'] ?? 'Material'; ?>', '<?= $user['email'] ?>')">
                    <img src="vendor/uploads/materiais/capa/<?= $material['matCapa']; ?>" class="img-fluid rounded-4" alt="Capa do material">
                </a>
                <button class="btn btn-icon float-end" onclick="openModal('<?= $material['id']; ?>')">
                    <i class="fas fa-star"></i>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- FERRAMENTAS (lista completa) -->
<section class="portfolio p-3">
    <div class="row">
        <div class="col text-start">
            <p class="text-uppercase text-secondary">
                Ferramentas | 
                <a href="ferramentas" class="text-uppercase text-light text-decoration-none">Ver Todos</a>
            </p>
        </div>
    </div>
    <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" data-aos="fade-up">
        <?php foreach ($ferramentas as $ferramenta): ?>
            <?php if ($ferramenta['ferStatus'] === 'ativo'): ?>
                <div class="col mb-4 portfolio-item photography">
                    <a href="<?= $ferramenta['ferLink']; ?>" target="_blank">
                        <img src="vendor/uploads/ferramentas/<?= $ferramenta['ferCapa']; ?>" class="card-img-top rounded-top-4" alt="<?= htmlspecialchars($ferramenta['ferNome']); ?>">
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Rodapé -->
<?php include 'app/views/parts/footer.php'; ?>

<!-- Offcanvas para produtos -->
<div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="productOffcanvas" aria-labelledby="offcanvasTitle">
    <div class="offcanvas-header">
        <h5 id="offcanvasTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-dark">
        <img id="offcanvasImage" src="" class="img-fluid rounded-4 mb-3" alt="">
        <p class="text-primary fw-bold" id="offcanvasPrice"></p>
        <p id="offcanvasDescription"></p>
        <a id="offcanvasLink" href="#" class="btn btn-primary w-100" target="_blank">Abrir Página</a>
    </div>
</div>

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
            themeToggle.innerHTML = isDarkMode ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
        });
    });
</script>

<!-- Swiper Configurações -->
<script>
    // Swiper para Assuntos Favoritos
    var swiperAssunto = new Swiper(".mySwiperAssunto", {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-assuntos",
            prevEl: ".swiper-button-prev-assuntos",
        },
        pagination: {
            el: ".swiper-pagination-assuntos",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        }
    });

    // Swiper para Categorias
    var swiperCategorias = new Swiper(".mySwiperCategorias", {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-categorias",
            prevEl: ".swiper-button-prev-categorias",
        },
        pagination: {
            el: ".swiper-pagination-categorias",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        }
    });

    // Swiper para Vídeos Favoritos
    var swiperVideos = new Swiper(".mySwiperVideos", {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-videos",
            prevEl: ".swiper-button-prev-videos",
        },
        pagination: {
            el: ".swiper-pagination-videos",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 5 } // Desktop: 5 colunas
        }
    });

    // Swiper para Ferramentas Favoritas
    var swiperFerramenta = new Swiper(".mySwiperFerramenta", {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-ferramentas",
            prevEl: ".swiper-button-prev-ferramentas",
        },
        pagination: {
            el: ".swiper-pagination-ferramentas",
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 } // Ajuste conforme a necessidade (dimensões 600x600)
        }
    });
</script>

<script>
    function openOffcanvas(title, image, price, description, link) {
        document.getElementById('offcanvasTitle').innerText = title;
        document.getElementById('offcanvasImage').src = 'vendor/uploads/produtos/' + image;
        document.getElementById('offcanvasPrice').innerText = 'R$ ' + price;
        document.getElementById('offcanvasDescription').innerText = description;
        document.getElementById('offcanvasLink').href = link;

        var offcanvas = new bootstrap.Offcanvas(document.getElementById('productOffcanvas'));
        offcanvas.show();
    }
</script>
</body>
</html>
