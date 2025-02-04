<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

$assuntos = fetchAssunto();

// Pegando a categoria da URL
$categoriaSelecionada = isset($_GET['a']) ? urldecode($_GET['a']) : '';

// Filtrando os assuntos pela categoria
$assuntosFiltrados = array_filter($assuntos, function ($assunto) use ($categoriaSelecionada) {
    return isset($assunto['categoria']) && $assunto['categoria'] === $categoriaSelecionada;
});
?>

<div id="assuntoContainer" style="display: none;">
    <section class="portfolio py-5 mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="grid p-0 clearfix row row-cols-1 row-cols-lg-2 row-cols-xl-3" id="assuntoGrid">
                        <?php if (!empty($assuntosFiltrados)): ?>
                            <?php foreach ($assuntosFiltrados as $assunto): ?>
                                <div class="col mb-4">
                                    <a href="videos&assunto=<?= urlencode($assunto['assunto']) ?>" class="text-decoration-none">
                                        <div class="card h-100 shadow-sm">
                                            <?php if (!empty($assunto['assCapa'])): ?>
                                                <img src="vendor/uploads/assunto/<?= htmlspecialchars($assunto['assCapa']) ?>" class="card-img-top" alt="Capa do Assunto">
                                            <?php else: ?>
                                                <img src="vendor/uploads/assunto/default.png" class="card-img-top" alt="Capa Padrão">
                                            <?php endif; ?>
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
                </div>
            </div>
    </section>
    <hr>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.getElementById("assuntoContainer").style.display = "block";
            document.getElementById("footer").style.display = "block";
        }, 500);
    });
</script>

<?php  include_once "app/views/parts/footer.php"; ?>
