<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Função para buscar os dados apenas se não estiverem na sessão
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

$assuntos = getSessionData('assuntos', 'fetchAssunto');

// Pegando a categoria da URL
$categoriaSelecionada = isset($_GET['a']) ? urldecode($_GET['a']) : '';

// Filtrando os assuntos pela categoria
$assuntosFiltrados = array_filter($assuntos, function ($assunto) use ($categoriaSelecionada) {
    return isset($assunto['categoria']) && $assunto['categoria'] === $categoriaSelecionada;
});
?>

<div id="assuntoContainer" class="container mb-6">
    <section class="portfolio py-5 mt-5">
        <div class="grid p-0 clearfix row row-cols-1 row-cols-lg-2 row-cols-xl-3" id="assuntoGrid">
            <?php if (!empty($assuntosFiltrados)): ?>
                <?php foreach ($assuntosFiltrados as $assunto): ?>
                    <div class="col mb-4">
                        <a href="videos&assunto=<?= urlencode($assunto['assunto']) ?>" class="text-decoration-none">
                            <div class="card h-100 shadow-sm">
                                <?php 
                                // Define a imagem de capa: se existir uma imagem definida, usa-a; senão, utiliza uma imagem padrão.
                                $imgSrc = !empty($assunto['assCapa'])
                                    ? "vendor/uploads/assunto/" . htmlspecialchars($assunto['assCapa'])
                                    : "vendor/uploads/assunto/default.png";
                                ?>
                                <img src="<?= $imgSrc ?>"
                                     class="card-img-top"
                                     alt="Capa do Assunto"
                                     loading="lazy">
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhum assunto encontrado para esta categoria.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>


