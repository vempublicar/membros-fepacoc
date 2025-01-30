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
                                <?php if (!empty($produto['capa'])): ?>
                                    <img src="vendor/uploads/produtos/<?= htmlspecialchars($produto['capa']) ?>"
                                        alt="<?= htmlspecialchars($produto['nome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/produtos/default.jpg"
                                        alt="Imagem padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>

                            <td class="text-center">
                                <?php if ($produto['status'] === 'ativo'): ?>
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
                                    data-nome="<?= htmlspecialchars($produto['nome']) ?>"
                                    data-pagina="<?= htmlspecialchars($produto['pagina']) ?>"
                                    data-preco="<?= htmlspecialchars($produto['preco']) ?>"
                                    data-descricao="<?= htmlspecialchars($produto['descricao']) ?>"
                                    data-categoria="<?= htmlspecialchars($produto['categoria']) ?>"
                                    data-status="<?= $produto['status'] ?>"
                                    data-capa="<?= htmlspecialchars($produto['capa'] ?? '') ?>"
                                    onclick="editProduct(this)"></i>

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
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div class="col-6 mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['nome']) ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" id="preco" name="preco" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                </div>

                <div class="col-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>

            <!-- Upload de imagem -->
            <div class="mb-3">
                <label for="capa" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
function editProduct(element) {
    document.getElementById("offcanvasAddProductLabel").textContent = "Editar Produto";
    document.getElementById("formAction").value = "update";
    document.getElementById("productId").value = element.getAttribute("data-id");
    document.getElementById("nome").value = element.getAttribute("data-nome");
    document.getElementById("preco").value = element.getAttribute("data-preco");
    document.getElementById("descricao").value = element.getAttribute("data-descricao");

    // Selecionar a categoria corretamente
    let categoriaSelecionada = element.getAttribute("data-categoria");
    let selectCategoria = document.getElementById("categoria");
    Array.from(selectCategoria.options).forEach(option => {
        if (option.value === categoriaSelecionada) {
            option.selected = true;
        }
    });

    // Selecionar status corretamente
    let statusSelecionado = element.getAttribute("data-status");
    let selectStatus = document.getElementById("status");
    Array.from(selectStatus.options).forEach(option => {
        if (option.value === statusSelecionado) {
            option.selected = true;
        }
    });

    // Exibir pré-visualização da imagem se existir
    let imagemAtual = element.getAttribute("data-capa");
    let imagemContainer = document.getElementById("capa").parentNode;
    
    // Remove a imagem anterior se já existir
    let existingPreview = imagemContainer.querySelector("img");
    if (existingPreview) {
        existingPreview.remove();
    }

    if (imagemAtual) {
        let imagemPreview = document.createElement("img");
        imagemPreview.src = "vendor/uploads/produtos/" + imagemAtual;
        imagemPreview.style = "width: 100px; height: auto; margin-top: 10px; border-radius: 5px;";
        imagemContainer.appendChild(imagemPreview);
    }
}

function resetForm() {
    document.getElementById("offcanvasAddProductLabel").textContent = "Adicionar Produto";
    document.getElementById("formProduct").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("productId").value = "";
    
    // Remover imagem antiga ao resetar o formulário
    let imagemContainer = document.getElementById("capa").parentNode;
    let existingPreview = imagemContainer.querySelector("img");
    if (existingPreview) {
        existingPreview.remove();
    }
}
</script>

