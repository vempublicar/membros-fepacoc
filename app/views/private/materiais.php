<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

$materiais = fetchMateriais();
$leads = fetchLeads();

// Configuração de paginação
$materiaisPorPagina = 12;
$totalMateriais = count($materiais);
$totalPaginas = ceil($totalMateriais / $materiaisPorPagina);
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $materiaisPorPagina;
$materiaisPagina = array_slice($materiais, $inicio, $materiaisPorPagina);
?>

<section class="portfolio py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="filters mb-4">
                    <h5 class="fw-bold">Filtros</h5>
                    <div class="mb-3">
                        <label for="pesquisa" class="form-label">Pesquisar</label>
                        <input type="text" id="pesquisa" class="form-control" placeholder="Digite o título do material...">
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select id="categoria" class="form-select">
                            <option value="">Todas</option>
                            <option value="Categoria 1">Categoria 1</option>
                            <option value="Categoria 2">Categoria 2</option>
                            <option value="Categoria 3">Categoria 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" id="videoGrid" data-aos="fade-up">
                    <?php foreach ($materiaisPagina as $material): ?>
                        <div class="col mb-4 portfolio-item" 
                            data-categoria="<?= htmlspecialchars($material['matCat']); ?>" 
                            data-titulo="<?= strtolower(htmlspecialchars($material['matNome'])); ?>">

                            <a href="#" 
                               data-bs-toggle="modal" 
                               data-bs-target="#videoModal" 
                               data-video-url="vendor/img/materiais/play/<?= htmlspecialchars($material['matLink']); ?>" 
                               onclick="trackUserAction('<?= htmlspecialchars($material['matNome']); ?>', '<?= htmlspecialchars($user['email'] ?? ''); ?>')">
                                <img src="vendor/img/materiais/capas/<?= htmlspecialchars($material['matCover']); ?>" class="img-fluid rounded-4" alt="Capa do material">
                                <div class="mt-2">
                                    <h6 class="fw-bold mb-0"><?= htmlspecialchars($material['matNome']); ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($material['matCat']); ?></small>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Paginação -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <?php if ($paginaAtual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="videos&pagina=<?= $paginaAtual - 1; ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= $i == $paginaAtual ? 'active' : ''; ?>">
                                <a class="page-link" href="videos&pagina=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($paginaAtual < $totalPaginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="videos&pagina=<?= $paginaAtual + 1; ?>" aria-label="Próximo">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Modal para exibição do material -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var videoModal = document.getElementById('videoModal');

        videoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var videoUrl = button.getAttribute('data-video-url');
            var videoFrame = document.getElementById('videoFrame');
            videoFrame.src = videoUrl;
        });

        videoModal.addEventListener('hidden.bs.modal', function () {
            var videoFrame = document.getElementById('videoFrame');
            videoFrame.src = '';
        });

        document.getElementById('categoria').addEventListener('change', filtrarMateriais);
        document.getElementById('pesquisa').addEventListener('input', filtrarMateriais);

        function filtrarMateriais() {
            var categoria = document.getElementById('categoria').value.toLowerCase();
            var pesquisa = document.getElementById('pesquisa').value.toLowerCase();
            var materiais = document.querySelectorAll('#videoGrid .portfolio-item');

            materiais.forEach(function (material) {
                var materialCategoria = material.getAttribute('data-categoria').toLowerCase();
                var materialTitulo = material.getAttribute('data-titulo').toLowerCase();

                if ((categoria === '' || materialCategoria === categoria) &&
                    (pesquisa === '' || materialTitulo.includes(pesquisa))) {
                    material.style.display = 'block';
                } else {
                    material.style.display = 'none';
                }
            });
        }
    });

    function trackUserAction(title, email) {
        const date = new Date();
        const formattedDate = date.toISOString().split('T')[0];
        const formattedTime = date.toTimeString().split(' ')[0];

        const data = {
            title: title,
            email: email,
            date: formattedDate,
            time: formattedTime,
        };

        fetch('app/functions/push/track.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);
            })
            .catch(error => {
                console.error('Erro ao registrar a ação:', error);
            });
    }
</script>
