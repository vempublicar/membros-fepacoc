<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo material -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddMaterial">
            <i class="fa fa-plus"></i> Adicionar Material
        </button>
        <h3 class="text-center">Gerenciar Materiais</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Arquivo</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($materiais)): ?>
                    <?php foreach ($materiais as $material): ?>
                        <tr>
                            <!-- Capa do Material -->
                            <td>
                                <?php if (!empty($material['capa'])): ?>
                                    <img src="vendor/uploads/materiais/<?= htmlspecialchars($material['capa']) ?>"
                                        alt="<?= htmlspecialchars($material['nome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/materiais/default.jpg"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <!-- Nome -->
                            <td><?= htmlspecialchars($material['nome']) ?></td>

                            <!-- Tipo -->
                            <td><?= htmlspecialchars($material['tipo']) ?></td>

                            <!-- Arquivo -->
                            <td>
                                <?php if (!empty($material['link'])): ?>
                                    <a href="vendor/uploads/materiais/arquivo/<?= htmlspecialchars($material['link']) ?>" target="_blank">
                                        <i class="fa fa-file-alt"></i> Download
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Sem arquivo</span>
                                <?php endif; ?>
                            </td>

                            <!-- Categoria -->
                            <td><?= htmlspecialchars($material['categoria']) ?></td>

                            <!-- Status -->
                            <td class="text-center">
                                <?php if ($material['status'] === 'ativo'): ?>
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
                                    data-bs-target="#offcanvasAddMaterial"
                                    data-id="<?= $material['id'] ?>"
                                    data-nome="<?= htmlspecialchars($material['nome']) ?>"
                                    data-tipo="<?= htmlspecialchars($material['tipo']) ?>"
                                    data-link="<?= htmlspecialchars($material['link']) ?>"
                                    data-descricao="<?= htmlspecialchars($material['descricao']) ?>"
                                    data-categoria="<?= htmlspecialchars($material['categoria']) ?>"
                                    data-status="<?= $material['status'] ?>"
                                    data-capa="<?= htmlspecialchars($material['capa'] ?? '') ?>"
                                    onclick="editMaterial(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="materiais">
                                    <input type="hidden" name="id" value="<?= $material['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir este material?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum material cadastrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Offcanvas para adicionar/editar material -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMaterial" aria-labelledby="offcanvasAddMaterialLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddMaterialLabel">Adicionar Material</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formMaterial" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <!-- Ação e Tabela (Campos Ocultos) -->
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="materiais">
            <input type="hidden" name="id" id="materialId">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <!-- Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>

            <!-- Categoria -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>

            <!-- Upload de Capa -->
            <div class="mb-3">
                <label for="capa" class="form-label">Capa</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>

            <!-- Upload de Arquivo -->
            <div class="mb-3">
                <label for="link" class="form-label">Arquivo (PDF, DOCX, MP4)</label>
                <input type="file" class="form-control" id="link" name="link" accept=".pdf,.doc,.docx,.mp4">
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

<script>
function editMaterial(element) {
    document.getElementById("offcanvasAddMaterialLabel").textContent = "Editar Material";
    document.getElementById("formAction").value = "update";
    document.getElementById("materialId").value = element.getAttribute("data-id");
    document.getElementById("nome").value = element.getAttribute("data-nome");
    document.getElementById("tipo").value = element.getAttribute("data-tipo");
    document.getElementById("descricao").value = element.getAttribute("data-descricao");
    document.getElementById("categoria").value = element.getAttribute("data-categoria");
    document.getElementById("status").value = element.getAttribute("data-status");
}

function resetForm() {
    document.getElementById("offcanvasAddMaterialLabel").textContent = "Adicionar Material";
    document.getElementById("formMaterial").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("materialId").value = "";
}
</script>
