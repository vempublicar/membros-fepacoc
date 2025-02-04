<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";


function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

$favoritos = getSessionData('capas', 'fetchFavoritos');
$assuntos = getSessionData('assuntos', 'fetchAssunto');
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Seus Favoritos</h3>

        <div class="row" data-aos="fade-up">
            <?php if (!empty($favoritos)): ?>
                <?php foreach ($favoritos as $favorito): ?>
                    <div class="col-6 col-lg-3 mb-4">
                        <a href="videos&assunto=<?= urlencode($favorito['vidAssunto']); ?>">
                            <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($favorito['vidCapa']); ?>" 
                                 class="img-fluid rounded-4 w-100" 
                                 alt="<?= htmlspecialchars($favorito['vidTitulo']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhum vídeo favorito encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

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
