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
                                    onclick="editCategory(<?= htmlspecialchars(json_encode($categoria)) ?>)"></i>
                                <i class="fa fa-trash text-danger"
                                    style="cursor: pointer;"
                                    onclick="deleteCategory(<?= $categoria['id'] ?>)"></i>
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
        <!-- Exibir mensagem de sucesso/erro -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <form action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <!-- Ação e Tabela (Campos Ocultos) -->
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="tabela" value="categorias">

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


