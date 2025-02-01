<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo assunto -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddAssunto">
            <i class="fa fa-plus"></i> Adicionar Assunto
        </button>
        <h3 class="text-center">Assuntos</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Assunto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($assuntos)): ?>
                    <?php foreach ($assuntos as $assunto): ?>
                        <tr>
                            <td><?= htmlspecialchars($assunto['categoria']) ?></td>
                            <td><?= htmlspecialchars($assunto['assunto']) ?></td>
                            <td>
                                <?php if (!empty($assunto['assCapa'])): ?>
                                    <img src="vendor/uploads/assuntos/<?= htmlspecialchars($assunto['assCapa']) ?>"
                                        alt="<?= htmlspecialchars($assunto['assunto']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/assuntos/default.png"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                data-id="<?= $assunto['id'] ?>"
                                data-categoria="<?= htmlspecialchars($assunto['categoria']) ?>"
                                data-assunto="<?= htmlspecialchars($assunto['assunto']) ?>"
                                onclick="editAssunto(this)"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Nenhum assunto cadastrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Offcanvas para adicionar/editar Assunto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddAssunto" aria-labelledby="offcanvasAddAssuntoLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddAssuntoLabel">Adicionar Novo Assunto</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formAssunto" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <!-- Campos Ocultos -->
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="assunto">
            <input type="hidden" name="id" id="assuntoId">

            <!-- Seleção da Categoria -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="">Selecione uma Categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= htmlspecialchars($categoria['catNome']) ?>"><?= htmlspecialchars($categoria['catNome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campo Assunto -->
            <div class="mb-3">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control" id="assunto" name="assunto" required>
            </div>

            <!-- Upload de Imagem -->
            <div class="mb-3">
                <label for="assCapa" class="form-label">Capa do Assunto</label>
                <input type="file" class="form-control" id="assCapa" name="assCapa" accept="image/*">
            </div>

            <!-- Botão de Envio -->
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
function editAssunto(element) {
    document.getElementById("offcanvasAddAssuntoLabel").textContent = "Editar Assunto";
    document.getElementById("formAction").value = "update";
    document.getElementById("assuntoId").value = element.getAttribute("data-id");
    document.getElementById("categoria").value = element.getAttribute("data-categoria");
    document.getElementById("assunto").value = element.getAttribute("data-assunto");

    // **Abrindo o Offcanvas via JavaScript**
    var offcanvasElement = new bootstrap.Offcanvas(document.getElementById('offcanvasAddAssunto'));
    offcanvasElement.show();
}

function resetForm() {
    document.getElementById("offcanvasAddAssuntoLabel").textContent = "Adicionar Novo Assunto";
    document.getElementById("formAssunto").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("assuntoId").value = "";
}
</script>
