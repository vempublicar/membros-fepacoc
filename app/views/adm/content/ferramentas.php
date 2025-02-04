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
                    <th>Imagem</th>
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
                            <!-- Capa -->
                            <td>
                                <?php if (!empty($ferramenta['ferCapa'])): ?>
                                    <img src="vendor/uploads/ferramentas/<?= htmlspecialchars($ferramenta['ferCapa']) ?>"
                                        alt="<?= htmlspecialchars($ferramenta['ferNome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/ferramentas/default.png"
                                        alt="Imagem Padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <!-- Nome -->
                            <td><?= htmlspecialchars($ferramenta['ferNome']) ?></td>

                            <!-- Descrição -->
                            <td><?= htmlspecialchars($ferramenta['ferDesc']) ?></td>

                            <!-- Link de Acesso -->
                            <td>
                                <a href="<?= htmlspecialchars($ferramenta['ferLink']) ?>" target="_blank">
                                    <i class="fa fa-external-link-alt"></i> Acessar
                                </a>
                            </td>

                            <!-- Categoria -->
                            <td><?= htmlspecialchars($ferramenta['ferCat']) ?></td>

                            <!-- Status -->
                            <td class="text-center">
                                <?php if ($ferramenta['ferStatus'] === 'ativo'): ?>
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
                                    data-fernome="<?= htmlspecialchars($ferramenta['ferNome']) ?>"
                                    data-ferdesc="<?= htmlspecialchars($ferramenta['ferDesc']) ?>"
                                    data-ferlink="<?= htmlspecialchars($ferramenta['ferLink']) ?>"
                                    data-fercat="<?= htmlspecialchars($ferramenta['ferCat']) ?>"
                                    data-ferstatus="<?= htmlspecialchars($ferramenta['ferStatus']) ?>"
                                    data-fercapa="<?= htmlspecialchars($ferramenta['ferCapa'] ?? '') ?>"
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
                        <td colspan="7" class="text-center">Nenhuma ferramenta cadastrada</td>
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
        <form id="formFerramenta" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <!-- Ação e Tabela (Campos Ocultos) -->
            <input type="hidden" name="action" value="create" id="formActionFer">
            <input type="hidden" name="tabela" value="ferramentas">
            <input type="hidden" name="id" id="ferramentaId">

            <!-- Upload de Capa -->
            <div class="mb-3">
                <label for="ferCapa" class="form-label">Imagem da Ferramenta</label>
                <input type="file" class="form-control" id="ferCapa" name="ferCapa" accept="image/*">
            </div>

            <!-- Nome -->
            <div class="mb-3">
                <label for="ferNome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="ferNome" name="ferNome" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="ferDesc" class="form-label">Descrição</label>
                <textarea class="form-control" id="ferDesc" name="ferDesc" rows="3" required></textarea>
            </div>

            <!-- Link de Acesso -->
            <div class="mb-3">
                <label for="ferLink" class="form-label">Link de Acesso</label>
                <input type="url" class="form-control" id="ferLink" name="ferLink" required>
            </div>

            <!-- Categoria -->
            <div class="mb-3">
                <label for="ferCat" class="form-label">Categoria</label>
                <select class="form-select" id="ferCat" name="ferCat" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['catNome']) ?>"><?= htmlspecialchars($categoria['catNome']) ?></option>
                        <?php endforeach; ?>
                    </select>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="ferStatus" class="form-label">Status</label>
                <select class="form-select" id="ferStatus" name="ferStatus" required>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <!-- Botão de Envio -->
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
<?php include 'app/views/parts/footer.php' ?>
<script>
function editFerramenta(element) {
    document.getElementById("offcanvasAddFerramentaLabel").textContent = "Editar Ferramenta";
    document.getElementById("formActionFer").value = "update";
    document.getElementById("ferramentaId").value = element.getAttribute("data-id");
    document.getElementById("ferNome").value = element.getAttribute("data-fernome");
    document.getElementById("ferDesc").value = element.getAttribute("data-ferdesc");
    document.getElementById("ferLink").value = element.getAttribute("data-ferlink");
    document.getElementById("ferCat").value = element.getAttribute("data-fercat");
    document.getElementById("ferStatus").value = element.getAttribute("data-ferstatus");
}

function resetForm() {
    document.getElementById("offcanvasAddFerramentaLabel").textContent = "Adicionar Ferramenta";
    document.getElementById("formFerramenta").reset();
    document.getElementById("formActionFer").value = "create";
    document.getElementById("ferramentaId").value = "";
}
</script>
