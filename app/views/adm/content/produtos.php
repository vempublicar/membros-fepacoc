<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo vídeo -->
        <button class="btn btn-primary mb-3" style="float: left;" onclick="openOffcanvas()">
            <i class="fa fa-plus"></i> Adicionar Produtos
        </button>
        <h3 class="text-center">Lista de Produtos</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Miniatura</th>
                    <th>Link</th>
                    <th>Título</th>
                    <th>Setor</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Short</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <?php // if ($produto['form'] == 'Produto'): ?>
                            <tr>
                                <!-- Miniatura -->
                                <td>
                                    <?php if (!empty($produto['cover'])): ?>
                                        <img src="vendor/img/produtos/capas/<?= htmlspecialchars($produto['cover']) ?>"
                                            alt="<?= htmlspecialchars($produto['title']) ?>"
                                            style="width: 50px; height: auto; border-radius: 5px;">
                                    <?php else: ?>
                                        <img src="path/to/default-thumbnail.jpg"
                                            alt="Miniatura padrão"
                                            style="width: 50px; height: auto; border-radius: 5px;">
                                    <?php endif; ?>
                                </td>

                                <!-- Ícone para abrir o vídeo -->
                                <td class="text-center">
                                    <?php if (!empty($produto['link'])): ?>
                                        <i class="fa fa-play-circle text-primary"
                                            style="cursor: pointer;"
                                            title="Abrir Vídeo"
                                            onclick="openVideoModal('<?= htmlspecialchars($produto['link']) ?>', '<?= htmlspecialchars($video['title']) ?>')">
                                        </i>
                                    <?php elseif (!empty($produto['internal_name'])): ?>
                                        <i class="fa fa-play-circle text-primary"
                                            style="cursor: pointer;"
                                            title="Abrir Vídeo Interno"
                                            onclick="openVideoModal(null, '<?= htmlspecialchars($produto['title']) ?>', '<?= htmlspecialchars($video['internal_name']) ?>')">
                                        </i>
                                    <?php else: ?>
                                        <i class="fa fa-ban text-muted" title="Sem link disponível"></i>
                                    <?php endif; ?>
                                </td>

                                <!-- Outras informações -->
                                <td><?= htmlspecialchars($produto['title']) ?></td>
                                <td><?= htmlspecialchars($produto['sector']) ?></td>
                                <td><?= htmlspecialchars($produto['category']) ?></td>
                                <td><?= htmlspecialchars($produto['type']) ?></td>
                                <td><?= htmlspecialchars($produto['short']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($produto['status']) && $produto['status'] === 'ativo'): ?>
                                        <i class="fa fa-eye text-primary"></i>
                                    <?php else: ?>
                                        <i class="fa fa-eye-slash text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fa fa-edit text-primary me-2"
                                        style="cursor: pointer;"
                                        onclick="editVideo(<?= htmlspecialchars(json_encode($produto)) ?>)"></i>
                                    <i class="fa fa-trash text-danger"
                                        style="cursor: pointer;"
                                        onclick="deleteVideo(<?= $produto['id'] ?>)"></i>
                                </td>
                            </tr>
                        <?php // endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Nenhum vídeo curto cadastrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>