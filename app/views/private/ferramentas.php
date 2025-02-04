<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Pegando as ferramentas do banco de dados
$ferramentas = fetchFerramentas();
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Ferramentas</h3>

        <div class="row" data-aos="fade-up">
            <?php if (!empty($ferramentas)): ?>
                <?php foreach ($ferramentas as $ferramenta): ?>
                    <div class="col-6 col-lg-3 mb-4">
                        <a href="<?= htmlspecialchars($ferramenta['ferLink']); ?>" target="_blank">
                            <img src="vendor/uploads/ferramentas/capa/<?= htmlspecialchars($ferramenta['ferCapa']); ?>" 
                                 class="img-fluid rounded-4 w-100" 
                                 alt="<?= htmlspecialchars($ferramenta['ferNome']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhuma ferramenta encontrada.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include_once "app/views/parts/footer.php"; ?>
