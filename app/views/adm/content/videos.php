<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo vídeo -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddVideo">
            <i class="fa fa-plus"></i> Adicionar Vídeo
        </button>
        <h3 class="text-center">Gerenciar Vídeos</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>Título</th>
                    <th>Resumo</th>
                    <th>Categoria</th>
                    <th>Produtor</th>
                    <th>Formato</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <!-- Capa do Vídeo -->
                            <td>
                                <?php if (!empty($video['capa'])): ?>
                                    <img src="vendor/uploads/videos/<?= htmlspecialchars($video['capa']) ?>"
                                        alt="<?= htmlspecialchars($video['titulo']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/videos/default.jpg"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <!-- Título -->
                            <td><?= htmlspecialchars($video['titulo']) ?></td>

                            <!-- Resumo -->
                            <td><?= htmlspecialchars($video['resumo']) ?></td>

                            <!-- Categoria -->
                            <td><?= htmlspecialchars($video['categoria']) ?></td>

                            <!-- Produtor -->
                            <td><?= htmlspecialchars($video['produtor']) ?></td>

                            <!-- Formato -->
                            <td><?= htmlspecialchars($video['formato']) ?></td>

                            <!-- Tipo -->
                            <td><?= htmlspecialchars($video['tipo']) ?></td>

                            <!-- Status -->
                            <td class="text-center">
                                <?php if ($video['status'] === 'ativo'): ?>
                                    <i class="fa fa-check-circle text-success"></i>
                                <?php else: ?>
                                    <i class="fa fa-times-circle text-danger"></i>
                                <?php endif; ?>
                            </td>

                            <!-- Ações -->
                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                    style="cursor: pointer;"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAddVideo"
                                    data-id="<?= $video['id'] ?>"
                                    data-titulo="<?= htmlspecialchars($video['titulo']) ?>"
                                    data-resumo="<?= htmlspecialchars($video['resumo']) ?>"
                                    data-produtor="<?= htmlspecialchars($video['produtor']) ?>"
                                    data-formato="<?= htmlspecialchars($video['formato']) ?>"
                                    data-setor="<?= htmlspecialchars($video['setor']) ?>"
                                    data-categoria="<?= htmlspecialchars($video['categoria']) ?>"
                                    data-tipo="<?= htmlspecialchars($video['tipo']) ?>"
                                    data-descricao="<?= htmlspecialchars($video['descricao']) ?>"
                                    data-status="<?= $video['status'] ?>"
                                    data-situacao="<?= htmlspecialchars($video['situacao']) ?>"
                                    data-formulario="<?= htmlspecialchars($video['formulario'] ?? '') ?>"
                                    data-capa="<?= htmlspecialchars($video['capa'] ?? '') ?>"
                                    data-link="<?= htmlspecialchars($video['link'] ?? '') ?>"
                                    onclick="editVideo(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="videos">
                                    <input type="hidden" name="id" value="<?= $video['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir este vídeo?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Nenhum vídeo cadastrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Offcanvas para adicionar/editar vídeo -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddVideo" aria-labelledby="offcanvasAddVideoLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddVideoLabel">Adicionar Vídeo</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formVideo" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="videos">
            <input type="hidden" name="id" id="videoId">

            <!-- Título -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <!-- Resumo -->
            <div class="mb-3">
                <label for="resumo" class="form-label">Resumo</label>
                <textarea class="form-control" id="resumo" name="resumo" rows="2" required></textarea>
            </div>

            <!-- Categoria -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="">Selecione</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= htmlspecialchars($categoria['nome']) ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Upload de Capa -->
            <div class="mb-3">
                <label for="capa" class="form-label">Capa</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>

            <!-- Upload do Vídeo -->
            <div class="mb-3">
                <label for="link" class="form-label">Vídeo</label>
                <input type="file" class="form-control" id="link" name="link" accept="video/*">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <!-- Botão de Envio -->
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
