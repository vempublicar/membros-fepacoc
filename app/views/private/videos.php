<section class="portfolio py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="filters mb-4">
                    <h5 class="fw-bold">Filtros</h5>
                    <div class="mb-3">
                        <label for="pesquisa" class="form-label">Pesquisar</label>
                        <input type="text" id="pesquisa" class="form-control" placeholder="Digite o título do vídeo...">
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
                    <div class="mb-3">
                        <label for="setor" class="form-label">Setor</label>
                        <select id="setor" class="form-select">
                            <option value="">Todos</option>
                            <option value="Setor 2">Setor 2</option>
                            <option value="Setor 1">Setor 1</option>
                            <option value="Setor 3">Setor 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="grid p-0 clearfix row row-cols-2 row-cols-lg-3 row-cols-xl-4" id="videoGrid" data-aos="fade-up">
                    <?php foreach ($videosPagina as $video): ?>
                        <div class="col mb-4 portfolio-item" 
                            data-categoria="<?= htmlspecialchars($video['vidCat']); ?>" 
                            data-setor="<?= htmlspecialchars($video['vidSetor']); ?>" 
                            data-titulo="<?= strtolower(htmlspecialchars($video['vidTitulo'])); ?>">

                            <a href="#" 
                               data-bs-toggle="modal" 
                               data-bs-target="#videoModal" 
                               data-video-url="vendor/videos/play/<?= htmlspecialchars($video['vidLink']); ?>" 
                               onclick="trackUserAction('<?= htmlspecialchars($video['vidTitulo']); ?>', '<?= htmlspecialchars($user['email'] ?? ''); ?>')">
                                <img src="vendor/videos/capas/<?= htmlspecialchars($video['vidCapa']); ?>" class="img-fluid rounded-4" alt="Capa do vídeo">
                                <div class="mt-2">
                                    <h6 class="fw-bold mb-0"><?= htmlspecialchars($video['vidTitulo']); ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($video['vidCat']); ?> - <?= htmlspecialchars($video['vidSetor']); ?></small>
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

<!-- Modal para exibição do vídeo -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Vídeo</h5>
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

        document.getElementById('categoria').addEventListener('change', filtrarVideos);
        document.getElementById('setor').addEventListener('change', filtrarVideos);
        document.getElementById('pesquisa').addEventListener('input', filtrarVideos);

        function filtrarVideos() {
            var categoria = document.getElementById('categoria').value.toLowerCase();
            var setor = document.getElementById('setor').value.toLowerCase();
            var pesquisa = document.getElementById('pesquisa').value.toLowerCase();
            var videos = document.querySelectorAll('#videoGrid .portfolio-item');

            videos.forEach(function (video) {
                var videoCategoria = video.getAttribute('data-categoria').toLowerCase();
                var videoSetor = video.getAttribute('data-setor').toLowerCase();
                var videoTitulo = video.getAttribute('data-titulo').toLowerCase();

                if ((categoria === '' || videoCategoria === categoria) &&
                    (setor === '' || videoSetor === setor) &&
                    (pesquisa === '' || videoTitulo.includes(pesquisa))) {
                    video.style.display = 'block';
                } else {
                    video.style.display = 'none';
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
