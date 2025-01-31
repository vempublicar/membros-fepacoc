<div class="row">
    <div class="col-sm-12">
        <!-- Botão para adicionar novo vídeo -->
        <button class="btn btn-primary mb-3" style="float: left;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddVideo">
            <i class="fa fa-plus"></i> Adicionar Vídeo
        </button>
        <h3 class="text-center">Gerenciar Vídeos</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Capa</th>
                    <th>Título</th>
                    <th>Resumo</th>
                    <th>Categoria</th>
                    <th>Produtor</th>
                    <th>Formato</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <td>
                                <?php if (!empty($video['vidCapa'])): ?>
                                    <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($video['vidCapa']) ?>"
                                        alt="<?= htmlspecialchars($video['vidTitulo']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/videos/capa/default.png"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($video['vidTitulo']) ?></td>
                            <td><?= htmlspecialchars($video['vidResumo']) ?></td>
                            <td><?= htmlspecialchars($video['vidCat']) ?></td>
                            <td><?= htmlspecialchars($video['vidProdutor']) ?></td>
                            <td><?= htmlspecialchars($video['vidFormato']) ?></td>
                            <td><?= htmlspecialchars($video['vidTipo']) ?></td>

                            <td class="text-center">
                                <?php if ($video['vidStatus'] === 'ativo'): ?>
                                    <i class="fa fa-check-circle text-success"></i>
                                <?php else: ?>
                                    <i class="fa fa-times-circle text-danger"></i>
                                <?php endif; ?>
                            </td>

                            <td>
                                <i class="fa fa-edit text-primary me-2"
                                    style="cursor: pointer;"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAddVideo"
                                    data-id="<?= $video['id'] ?>"
                                    data-vidtitulo="<?= htmlspecialchars($video['vidTitulo']) ?>"
                                    data-vidresumo="<?= htmlspecialchars($video['vidResumo']) ?>"
                                    data-vidprodutor="<?= htmlspecialchars($video['vidProdutor']) ?>"
                                    data-vidformato="<?= htmlspecialchars($video['vidFormato']) ?>"
                                    data-vidsetor="<?= htmlspecialchars($video['vidSetor']) ?>"
                                    data-vidcat="<?= htmlspecialchars($video['vidCat']) ?>"
                                    data-vidtipo="<?= htmlspecialchars($video['vidTipo']) ?>"
                                    data-viddesc="<?= htmlspecialchars($video['vidDesc']) ?>"
                                    data-vidstatus="<?= htmlspecialchars($video['vidStatus']) ?>"
                                    data-vidsituacao="<?= htmlspecialchars($video['vidSituacao']) ?>"
                                    data-vidformulario="<?= htmlspecialchars($video['vidFormulario'] ?? '') ?>"
                                    data-vidlinkexterno="<?= htmlspecialchars($video['vidLinkExterno'] ?? '') ?>"
                                    data-vidcapa="<?= htmlspecialchars($video['vidCapa'] ?? '') ?>"
                                    data-vidlink="<?= htmlspecialchars($video['vidLink'] ?? '') ?>"
                                    onclick="editarVideo(this)"></i>

                                <form action="app/functions/push/crud.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="tabela" value="videos">
                                    <input type="hidden" name="id" value="<?= $video['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" onclick="return confirm('Tem certeza que deseja excluir este vídeo?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Nenhum vídeo cadastrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Offcanvas para adicionar/editar vídeo -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddVideo" aria-labelledby="offcanvasAddVideoLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAddVideoLabel">Adicionar Vídeo</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formVideo" action="app/functions/push/crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create" id="formAction">
            <input type="hidden" name="tabela" value="videos">
            <input type="hidden" name="id" id="videoId">

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="vidTitulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="vidTitulo" name="vidTitulo" required>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidCat" class="form-label">Categoria</label>
                    <select class="form-select" id="vidCat" name="vidCat" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['catNome']) ?>"><?= htmlspecialchars($categoria['catNome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidSetor" class="form-label">Setor</label>
                    <input type="text" class="form-control" id="vidSetor" name="vidSetor" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="vidResumo" class="form-label">Resumo</label>
                    <textarea class="form-control" id="vidResumo" name="vidResumo" rows="2" required></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label for="vidDesc" class="form-label">Descrição</label>
                    <textarea class="form-control" id="vidDesc" name="vidDesc" rows="3"></textarea>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidProdutor" class="form-label">Produtor</label>
                    <select class="form-select" id="vidProdutor" name="vidProdutor" required>
                        <option value="">Selecione</option>
                        <option value="Não informado">Não informado</option>
                        <?php foreach ($produtores as $produtor): ?>
                            <option value="<?= htmlspecialchars($produtor['nome']) ?>"><?= htmlspecialchars($produtor['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidFormato" class="form-label">Formato</label>
                    <select class="form-select" id="vidFormato" name="vidFormato" required>
                        <option value="retrato">Retrato</option>
                        <option value="paisagem">Paisagem</option>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidStatus" class="form-label">Status</label>
                    <select class="form-select" id="vidStatus" name="vidStatus" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="vidTipo" class="form-label">Tipo</label>
                    <select class="form-select" id="vidTipo" name="vidTipo" required>
                        <option value="Aula">Aula</option>
                        <option value="Estratégia">Estratégia</option>
                        <option value="Aplicação">Aplicação</option>
                        <option value="Dica">Dica</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="vidSituacao" class="form-label">Liberado ao Usuário</label>
                    <select class="form-select" id="vidSituacao" name="vidSituacao" required>
                        <option value="Bronze">Bronze</option>
                        <option value="Prata">Prata</option>
                        <option value="Ouro">Ouro</option>
                        <option value="Diamante">Diamante</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="vidFormulario" class="form-label">Link do Formulário</label>
                    <input type="url" class="form-control" id="vidFormulario" name="vidFormulario" placeholder="https://">
                </div>
            </div>

            <!-- Upload de arquivos -->
            <div class="mb-3">
                <label for="vidCapa" class="form-label">Capa</label>
                <input type="file" class="form-control" id="vidCapa" name="vidCapa" accept="image/*">
            </div>
            <div class="col-12 mb-3">
                    <label for="vidLinkExterno" class="form-label">Link Externo do Vídeo</label>
                    <input type="url" class="form-control" id="vidLinkExterno" name="vidLinkExterno" placeholder="https://">
            </div>
            <div class="mb-3">
                <label for="vidLink" class="form-label">Vídeo (MP4)</label>
                <input type="file" class="form-control" id="vidLink" name="vidLink" accept="video/mp4">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
function editarVideo(element) {
    document.getElementById("offcanvasAddVideoLabel").textContent = "Editar Vídeo";
    document.getElementById("formAction").value = "update";
    document.getElementById("videoId").value = element.getAttribute("data-id");
    document.getElementById("vidTitulo").value = element.getAttribute("data-vidtitulo");
    document.getElementById("vidResumo").value = element.getAttribute("data-vidresumo");
    document.getElementById("vidDesc").value = element.getAttribute("data-viddesc");
    document.getElementById("vidSetor").value = element.getAttribute("data-vidsetor");
    document.getElementById("vidFormulario").value = element.getAttribute("data-vidformulario");
    document.getElementById("vidLinkExterno").value = element.getAttribute("data-vidlinkexterno");
    document.getElementById("vidCat").value = element.getAttribute("data-vidcat");
    document.getElementById("vidProdutor").value = element.getAttribute("data-vidprodutor");
    document.getElementById("vidFormato").value = element.getAttribute("data-vidformato");
    document.getElementById("vidTipo").value = element.getAttribute("data-vidtipo");
    document.getElementById("vidSituacao").value = element.getAttribute("data-vidsituacao");
    document.getElementById("vidStatus").value = element.getAttribute("data-vidstatus");

    // Exibir pré-visualização da capa se existir
    let capaAtual = element.getAttribute("data-vidcapa");
    document.getElementById("vidCapa").parentNode.querySelector("img")?.remove();
    if (capaAtual) {
        let capaPreview = document.createElement("img");
        capaPreview.src = "vendor/uploads/videos/" + capaAtual;
        capaPreview.style = "width: 100px; height: auto; margin-top: 10px; border-radius: 5px;";
        document.getElementById("vidCapa").parentNode.appendChild(capaPreview);
    }
}

function resetForm() {
    document.getElementById("offcanvasAddVideoLabel").textContent = "Adicionar Vídeo";
    document.getElementById("formVideo").reset();
    document.getElementById("formAction").value = "create";
    document.getElementById("videoId").value = "";
    document.getElementById("vidCapa").parentNode.querySelector("img")?.remove();
}
</script>

