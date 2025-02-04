<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Pegando os materiais do banco de dados
$materiais = fetchMateriais();
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Materiais de Apoio</h3>

        <div class="row" data-aos="fade-up">
            <?php if (!empty($materiais)): ?>
                <?php foreach ($materiais as $material): ?>
                    <div class="col-6 col-lg-3 mb-4">
                        <a href="videos&assunto=<?= urlencode($material['matAssunto']); ?>">
                            <img src="vendor/uploads/materiais/capa/<?= htmlspecialchars($material['matCapa']); ?>" 
                                 class="img-fluid rounded-4 w-100" 
                                 alt="<?= htmlspecialchars($material['matTitulo']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhum material encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once "app/views/parts/footer.php"; ?>
