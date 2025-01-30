<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo produto -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddProduct">
            <i class="fa fa-plus"></i> Adicionar Produto
        </button>
        <h3 class="text-center">Gerenciar Produtos</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <?php if (!empty($produto['proCapa'])): ?>
                                    <img src="vendor/uploads/produtos/<?= htmlspecialchars($produto['proCapa']) ?>"
                                        alt="<?= htmlspecialchars($produto['proNome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/produtos/default.jpg"
                                        alt="Imagem padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($produto['proNome']) ?></td>
                            <td><?= htmlspecialchars($produto['proCategoria']) ?></td>
                            <td>R$ <?= number_format($produto['proPreco'], 2, ',', '.') ?></td>

                            <td class="text-center">
                                <?php if ($produto['proStatus'] === 'ativo'): ?>
                                    <i class="fa fa-check-circle text-success"></i>
                                <?php else: ?>
                                    <i class="fa fa-times-circle text-danger"></i>
                                <?php endif; ?>
                            </td>

                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                    style="cursor: pointer;"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAddProduct"
                                    data-id="<?= $produto['id'] ?>"
                                    data-pronome="<?= htmlspecialchars($produto['proNome']) ?>"
                                    data-propagina="<?= htmlspecialchars($produto['proPagina']) ?>"
                                    data-propreco="<?= htmlspecialchars($produto['proPreco']) ?>"
                                    data-prosobre="<?= htmlspecialchars($produto['proSobre']) ?>"
                                    data-procategoria="<?= htmlspecialchars($produto['proCategoria']) ?>"
                                    data-prostatus="<?= $produto['proStatus'] ?>"
                                    data-procapa="<?= htmlspecialchars($produto['proCapa'] ?? '') ?>"
                                    onclick="editarProduto(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="produtos">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir este produto?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhum produto cadastrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
    </div>
</div>

<!-- Offcanvas para adicionar/editar produto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddProduct" aria-labelledby="offcanvasAddProductLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddProductLabel">Adicionar Produto</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formProduct" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="produtos">
            <input type="hidden" name="id" id="productId">

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="proNome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="proNome" name="proNome" required>
                </div>

                <div class="col-6 mb-3">
                    <label for="proCategoria" class="form-label">Categoria</label>
                    <select class="form-select" id="proCategoria" name="proCategoria" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['proCat']) ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="proPreco" class="form-label">Preço</label>
                    <input type="text" class="form-control" id="proPreco" name="proPreco" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="proSobre" class="form-label">Descrição</label>
                    <textarea class="form-control" id="proSobre" name="proSobre" rows="3"></textarea>
                </div>

                <div class="col-6 mb-3">
                    <label for="proStatus" class="form-label">Status</label>
                    <select class="form-select" id="proStatus" name="proStatus" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="proCapa" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="proCapa" name="proCapa" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
function editarProduto(element) {
    document.getElementById("offcanvasAddProductLabel").textContent = "Editar Produto";
    document.getElementById("formAction").value = "update";
    document.getElementById("productId").value = element.getAttribute("data-id");
    document.getElementById("proNome").value = element.getAttribute("data-pronome");
    document.getElementById("proPreco").value = element.getAttribute("data-propreco");
    document.getElementById("proSobre").value = element.getAttribute("data-prosobre");
    document.getElementById("proCategoria").value = element.getAttribute("data-procategoria");
    document.getElementById("proStatus").value = element.getAttribute("data-prostatus");
}

function resetForm() {
    document.getElementById("offcanvasAddProductLabel").textContent = "Adicionar Produto";
    document.getElementById("formProduct").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("productId").value = "";
}
</script>
