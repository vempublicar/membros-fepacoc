<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar nova capa -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddCapa">
            <i class="fa fa-plus"></i> Adicionar Capa
        </button>
        <h3 class="text-center">Gerenciar Capas</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>Nome</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($capas)): ?>
                    <?php foreach ($capas as $capa): ?>
                        <tr>
                            <td>
                                <?php if (!empty($capa['capaMobile'])): ?>
                                    <img src="vendor/uploads/capas/mobile/<?= htmlspecialchars($capa['capaMobile']) ?>"
                                        alt="<?= htmlspecialchars($capa['nome']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="uploads/capas/mobile/default.png"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($capa['nome']) ?></td>
                            <td>
                                <?php if (!empty($capa['link'])): ?>
                                    <a href="<?= htmlspecialchars($capa['link']) ?>" target="_blank">Ver</a>
                                <?php else: ?>
                                    Nenhum
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if ($capa['status'] === 'ativo'): ?>
                                    <i class="fa fa-check-circle text-success"></i>
                                <?php else: ?>
                                    <i class="fa fa-times-circle text-danger"></i>
                                <?php endif; ?>
                            </td>

                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                    style="cursor: pointer;"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAddCapa"
                                    data-id="<?= $capa['id'] ?>"
                                    data-nome="<?= htmlspecialchars($capa['nome']) ?>"
                                    data-link="<?= htmlspecialchars($capa['link'] ?? '') ?>"
                                    data-imagemdesktop="<?= htmlspecialchars($capa['imagem_desktop'] ?? '') ?>"
                                    data-imagemmobile="<?= htmlspecialchars($capa['imagem_mobile'] ?? '') ?>"
                                    data-status="<?= htmlspecialchars($capa['status']) ?>"
                                    onclick="editarCapa(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="capas">
                                    <input type="hidden" name="id" value="<?= $capa['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir esta capa?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma capa cadastrada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Offcanvas para adicionar/editar capa -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCapa" aria-labelledby="offcanvasAddCapaLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddCapaLabel">Adicionar Capa</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formCapa" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create" id="formActionCap">
            <input type="hidden" name="tabela" value="capas">
            <input type="hidden" name="id" id="capaId">

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="link" class="form-label">Link</label>
                    <input type="url" class="form-control" id="link" name="link" placeholder="https://">
                </div>

                <div class="col-6 mb-3">
                    <label for="capaDesktop" class="form-label">Imagem Desktop</label>
                    <input type="file" class="form-control" id="capaDesktop" name="capaDesktop" accept="image/*">
                </div>

                <div class="col-6 mb-3">
                    <label for="capaMobile" class="form-label">Imagem Mobile</label>
                    <input type="file" class="form-control" id="capaMobile" name="capaMobile" accept="image/*">
                </div>

                <div class="col-12 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
function editarCapa(element) {
    document.getElementById("offcanvasAddCapaLabel").textContent = "Editar Capa";
    document.getElementById("formActionCap").value = "update";
    document.getElementById("capaId").value = element.getAttribute("data-id");
    document.getElementById("nome").value = element.getAttribute("data-nome");
    document.getElementById("link").value = element.getAttribute("data-link");
    document.getElementById("status").value = element.getAttribute("data-status");

    let imgDesktop = element.getAttribute("data-imagemdesktop");
    let imgMobile = element.getAttribute("data-imagemmobile");

    document.getElementById("imagemDesktop").parentNode.querySelector("img")?.remove();
    document.getElementById("imagemMobile").parentNode.querySelector("img")?.remove();

    if (imgDesktop) {
        let previewDesktop = document.createElement("img");
        previewDesktop.src = "uploads/capas/" + imgDesktop;
        previewDesktop.style = "width: 100px; height: auto; margin-top: 10px; border-radius: 5px;";
        document.getElementById("imagemDesktop").parentNode.appendChild(previewDesktop);
    }

    if (imgMobile) {
        let previewMobile = document.createElement("img");
        previewMobile.src = "uploads/capas/" + imgMobile;
        previewMobile.style = "width: 100px; height: auto; margin-top: 10px; border-radius: 5px;";
        document.getElementById("imagemMobile").parentNode.appendChild(previewMobile);
    }
}

function resetForm() {
    document.getElementById("offcanvasAddCapaLabel").textContent = "Adicionar Capa";
    document.getElementById("formCapa").reset();
    document.getElementById("formActionCap").value = "create";
    document.getElementById("capaId").value = "";
    document.getElementById("imagemDesktop").parentNode.querySelector("img")?.remove();
    document.getElementById("imagemMobile").parentNode.querySelector("img")?.remove();
}
</script>
