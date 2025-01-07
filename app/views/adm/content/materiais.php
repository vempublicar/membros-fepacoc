<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo vídeo -->
        <button class="btn btn-primary mb-3" style="float: left;" onclick="openOffcanvas()">
            <i class="fa fa-plus"></i> Adicionar Materiais
        </button>
        <h3 class="text-center">Lista de Materiais</h3>
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
                <?php if (!empty($materiais)): ?>
                    <?php foreach ($materiais as $material): ?>
                        <?php if ($material['form'] == 'Serviço'): ?>
                            <tr>
                                <!-- Miniatura -->
                                <td>
                                    <?php if (!empty($material['cover'])): ?>
                                        <img src="vendor/img/materiais/capas/<?= htmlspecialchars($material['cover']) ?>"
                                            alt="<?= htmlspecialchars($material['title']) ?>"
                                            style="width: 50px; height: auto; border-radius: 5px;">
                                    <?php else: ?>
                                        <img src="path/to/default-thumbnail.jpg"
                                            alt="Miniatura padrão"
                                            style="width: 50px; height: auto; border-radius: 5px;">
                                    <?php endif; ?>
                                </td>

                                <!-- Ícone para abrir o vídeo -->
                                <td class="text-center">
                                    <?php if (!empty($material['link'])): ?>
                                        <i class="fa fa-play-circle text-primary"
                                            style="cursor: pointer;"
                                            title="Abrir Vídeo"
                                            onclick="openVideoModal('<?= htmlspecialchars($material['link']) ?>', '<?= htmlspecialchars($video['title']) ?>')">
                                        </i>
                                    <?php elseif (!empty($material['internal_name'])): ?>
                                        <i class="fa fa-play-circle text-primary"
                                            style="cursor: pointer;"
                                            title="Abrir Vídeo Interno"
                                            onclick="openVideoModal(null, '<?= htmlspecialchars($material['title']) ?>', '<?= htmlspecialchars($video['internal_name']) ?>')">
                                        </i>
                                    <?php else: ?>
                                        <i class="fa fa-ban text-muted" title="Sem link disponível"></i>
                                    <?php endif; ?>
                                </td>

                                <!-- Outras informações -->
                                <td><?= htmlspecialchars($material['title']) ?></td>
                                <td><?= htmlspecialchars($material['sector']) ?></td>
                                <td><?= htmlspecialchars($material['category']) ?></td>
                                <td><?= htmlspecialchars($material['type']) ?></td>
                                <td><?= htmlspecialchars($material['short']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($material['status']) && $material['status'] === 'ativo'): ?>
                                        <i class="fa fa-eye text-primary"></i>
                                    <?php else: ?>
                                        <i class="fa fa-eye-slash text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fa fa-edit text-primary me-2"
                                        style="cursor: pointer;"
                                        onclick="editVideo(<?= htmlspecialchars(json_encode($material)) ?>)"></i>
                                    <i class="fa fa-trash text-danger"
                                        style="cursor: pointer;"
                                        onclick="deleteVideo(<?= $material['id'] ?>)"></i>
                                </td>
                            </tr>
                        <?php endif; ?>
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