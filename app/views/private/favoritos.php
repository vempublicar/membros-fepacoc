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

<?php include_once "app/views/parts/footer.php"; ?>
