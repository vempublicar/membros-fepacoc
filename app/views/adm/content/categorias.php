<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar nova categoria -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddCategory">
            <i class="fa fa-plus"></i> Adicionar Categoria
        </button>
        <h3 class="text-center">Categorias</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Miniatura</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <!-- Miniatura da Categoria -->
                            <td>
                                <?php if (!empty($categoria['capa'])): ?>
                                    <img src="<?= htmlspecialchars($categoria['capa']) ?>"
                                        alt="<?= htmlspecialchars($categoria['nome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="path/to/default-category-thumbnail.jpg"
                                        alt="Miniatura padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <!-- Nome da Categoria -->
                            <td><?= htmlspecialchars($categoria['nome']) ?></td>

                            <!-- Descrição da Categoria -->
                            <td><?= htmlspecialchars($categoria['descricao']) ?></td>

                            <!-- Status da Categoria -->
                            <td class="text-center">
                                <?php if (!empty($categoria['status']) && $categoria['status'] === 'ativo'): ?>
                                    <i class="fa fa-eye text-primary"></i>
                                <?php else: ?>
                                    <i class="fa fa-eye-slash text-secondary"></i>
                                <?php endif; ?>
                            </td>

                            <!-- Ações -->
                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                    style="cursor: pointer;"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAddCategory"
                                    data-id="<?= $categoria['id'] ?>"
                                    data-nome="<?= htmlspecialchars($categoria['nome']) ?>"
                                    data-descricao="<?= htmlspecialchars($categoria['descricao']) ?>"
                                    data-status="<?= $categoria['status'] ?>"
                                    data-capa="<?= htmlspecialchars($categoria['capa'] ?? '') ?>"
                                    onclick="editCategory(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="categorias">
                                    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma categoria cadastrada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Offcanvas para adicionar nova categoria -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCategory" aria-labelledby="offcanvasAddCategoryLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddCategoryLabel">Adicionar Nova Categoria</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formCategory" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <!-- Ação e Tabela (Campos Ocultos) -->
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="categorias">
            <input type="hidden" name="id" id="categoryId">

            <!-- Campo Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <!-- Campo Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>

            <!-- Campo Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <!-- Campo Capa (Upload de Imagem) -->
            <div class="mb-3">
                <label for="capa" class="form-label">Capa</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>

            <!-- Botão de Envio -->
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
<script>
function editCategory(element) {
    document.getElementById("offcanvasAddCategoryLabel").textContent = "Editar Categoria";
    document.getElementById("formAction").value = "update";
    document.getElementById("categoryId").value = element.getAttribute("data-id");
    document.getElementById("nome").value = element.getAttribute("data-nome");
    document.getElementById("descricao").value = element.getAttribute("data-descricao");
    document.getElementById("status").value = element.getAttribute("data-status");

    // Se houver uma imagem antiga, pode-se exibir
    let capa = element.getAttribute("data-capa");
    if (capa) {
        let capaInput = document.getElementById("capa");
        capaInput.setAttribute("data-placeholder", "Imagem já cadastrada");
    }
}

function resetForm() {
    document.getElementById("offcanvasAddCategoryLabel").textContent = "Adicionar Nova Categoria";
    document.getElementById("formCategory").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("categoryId").value = "";
}
</script>

