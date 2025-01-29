<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar nova ferramenta -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddFerramenta">
            <i class="fa fa-plus"></i> Adicionar Ferramenta
        </button>
        <h3 class="text-center">Gerenciar Ferramentas</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Link de Acesso</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ferramentas)): ?>
                    <?php foreach ($ferramentas as $ferramenta): ?>
                        <tr>
                        <td>
                                <?php if (!empty($ferramenta['capa'])): ?>
                                    <img src="vendor/uploads/ferramentas/<?= htmlspecialchars($ferramenta['capa']) ?>"
                                        alt="<?= htmlspecialchars($ferramenta['nome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/ferramentas/default.jpg"
                                        alt="Imagem Padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>
                            <!-- Nome -->
                            <td><?= htmlspecialchars($ferramenta['nome']) ?></td>

                            <!-- Descrição -->
                            <td><?= htmlspecialchars($ferramenta['descricao']) ?></td>

                            <!-- Link de Acesso -->
                            <td>
                                <a href="<?= htmlspecialchars($ferramenta['link_acesso']) ?>" target="_blank">
                                    <i class="fa fa-external-link-alt"></i> Acessar
                                </a>
                            </td>

                            <!-- Categoria -->
                            <td><?= htmlspecialchars($ferramenta['categoria']) ?></td>

                            <!-- Status -->
                            <td class="text-center">
                                <?php if ($ferramenta['status'] === 'ativo'): ?>
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
                                    data-bs-target="#offcanvasAddFerramenta"
                                    data-id="<?= $ferramenta['id'] ?>"
                                    data-nome="<?= htmlspecialchars($ferramenta['nome']) ?>"
                                    data-descricao="<?= htmlspecialchars($ferramenta['descricao']) ?>"
                                    data-link_acesso="<?= htmlspecialchars($ferramenta['link_acesso']) ?>"
                                    data-categoria="<?= htmlspecialchars($ferramenta['categoria']) ?>"
                                    data-status="<?= $ferramenta['status'] ?>"
                                    onclick="editFerramenta(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="ferramentas">
                                    <input type="hidden" name="id" value="<?= $ferramenta['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir esta ferramenta?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma ferramenta cadastrada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Offcanvas para adicionar/editar ferramenta -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddFerramenta" aria-labelledby="offcanvasAddFerramentaLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddFerramentaLabel">Adicionar Ferramenta</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formFerramenta" action="app/functions/push/crud.php" method="POST">
            <!-- Ação e Tabela (Campos Ocultos) -->
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="ferramentas">
            <input type="hidden" name="id" id="ferramentaId">
            <div class="mb-3">
                <label for="capa" class="form-label">Imagem da Ferramenta</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>
            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>

            <!-- Link de Acesso -->
            <div class="mb-3">
                <label for="link_acesso" class="form-label">Link de Acesso</label>
                <input type="url" class="form-control" id="link_acesso" name="link_acesso" required>
            </div>

            <!-- Categoria -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
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
function editFerramenta(element) {
    document.getElementById("offcanvasAddFerramentaLabel").textContent = "Editar Ferramenta";
    document.getElementById("formAction").value = "update";
    document.getElementById("ferramentaId").value = element.getAttribute("data-id");
    document.getElementById("nome").value = element.getAttribute("data-nome");
    document.getElementById("descricao").value = element.getAttribute("data-descricao");
    document.getElementById("link_acesso").value = element.getAttribute("data-link_acesso");
    document.getElementById("categoria").value = element.getAttribute("data-categoria");
    document.getElementById("status").value = element.getAttribute("data-status");
}

function resetForm() {
    document.getElementById("offcanvasAddFerramentaLabel").textContent = "Adicionar Ferramenta";
    document.getElementById("formFerramenta").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("ferramentaId").value = "";
}
</script>
