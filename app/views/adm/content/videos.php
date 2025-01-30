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
                                <?php if (!empty($video['capa'])): ?>
                                    <img src="vendor/uploads/videos/<?= htmlspecialchars($video['capa']) ?>"
                                        alt="<?= htmlspecialchars($video['titulo']) ?>"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php else: ?>
                                    <img src="vendor/uploads/videos/default.jpg"
                                        alt="Capa padrão"
                                        style="width: 50px; height: auto; border-radius: 5px;">
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($video['titulo']) ?></td>
                            <td><?= htmlspecialchars($video['resumo']) ?></td>
                            <td><?= htmlspecialchars($video['categoria']) ?></td>
                            <td><?= htmlspecialchars($video['produtor']) ?></td>
                            <td><?= htmlspecialchars($video['formato']) ?></td>
                            <td><?= htmlspecialchars($video['tipo']) ?></td>

                            <td class="text-center">
                                <?php if ($video['status'] === 'ativo'): ?>
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
                                    data-titulo="<?= htmlspecialchars($video['titulo']) ?>"
                                    data-resumo="<?= htmlspecialchars($video['resumo']) ?>"
                                    data-produtor="<?= htmlspecialchars($video['produtor']) ?>"
                                    data-formato="<?= htmlspecialchars($video['formato']) ?>"
                                    data-setor="<?= htmlspecialchars($video['setor']) ?>"
                                    data-categoria="<?= htmlspecialchars($video['categoria']) ?>"
                                    data-tipo="<?= htmlspecialchars($video['tipo']) ?>"
                                    data-descricao="<?= htmlspecialchars($video['descricao']) ?>"
                                    data-status="<?= $video['status'] ?>"
                                    data-situacao="<?= htmlspecialchars($video['situacao']) ?>"
                                    data-formulario="<?= htmlspecialchars($video['formulario'] ?? '') ?>"
                                    data-capa="<?= htmlspecialchars($video['capa'] ?? '') ?>"
                                    data-link="<?= htmlspecialchars($video['link'] ?? '') ?>"
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
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
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
                    <label for="setor" class="form-label">Setor</label>
                    <input type="text" class="form-control" id="setor" name="setor" required>
                </div>
                <div class="col-12 mb-3">
                    <label for="resumo" class="form-label">Resumo</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="2" required></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                </div>
                
                <div class="col-6 mb-3">
                    <label for="produtor" class="form-label">Produtor</label>
                    <select class="form-select" id="produtor" name="produtor" required>
                        <option value="">Selecione</option>
                        <option value="Não informado">Não informado</option>
                        <?php foreach ($produtores as $produtor): ?>
                            <option value="<?= htmlspecialchars($produtor['nome']) ?>"><?= htmlspecialchars($produtor['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="formato" class="form-label">Formato</label>
                    <select class="form-select" id="formato" name="formato" required>
                        <option value="retrato">Retrato</option>
                        <option value="paisagem">Paisagem</option>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="Aula">Aula</option>
                        <option value="Estratégia">Estratégia</option>
                        <option value="Aplicação">Aplicação</option>
                        <option value="Dica">Dica</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="situacao" class="form-label">Liberado ao Usuário</label>
                    <select class="form-select" id="situacao" name="situacao" required>
                        <option value="Bronze">Bronze</option>
                        <option value="Prata">Prata</option>
                        <option value="Ouro">Ouro</option>
                        <option value="Diamante">Diamante</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="formulario" class="form-label">Link do Formulário</label>
                    <input type="url" class="form-control" id="formulario" name="formulario" placeholder="https://">
                </div>
            </div>

            <!-- Upload de arquivos -->
            <div class="mb-3">
                <label for="capa" class="form-label">Capa</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="link" class="form-label">Vídeo (MP4)</label>
                <input type="file" class="form-control" id="link" name="link" accept="video/mp4">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script>
    function editarVideo(element){
        // Mudar título do Offcanvas
        document.getElementById("offcanvasAddVideoLabel").textContent = "Editar Vídeo";

        // Alterar ação do formulário para UPDATE
        document.getElementById("formAction").value = "update";
        document.getElementById("videoId").value = element.getAttribute("data-id");

        // Preencher campos do formulário com os dados existentes
        document.getElementById("titulo").value = element.getAttribute("data-titulo");
        document.getElementById("resumo").value = element.getAttribute("data-resumo");
        document.getElementById("descricao").value = element.getAttribute("data-descricao");
        document.getElementById("setor").value = element.getAttribute("data-setor");
        document.getElementById("formulario").value = element.getAttribute("data-formulario");

        // Preencher selects
        document.getElementById("categoria").value = element.getAttribute("data-categoria");
        document.getElementById("produtor").value = element.getAttribute("data-produtor");
        document.getElementById("formato").value = element.getAttribute("data-formato");
        document.getElementById("tipo").value = element.getAttribute("data-tipo");
        document.getElementById("situacao").value = element.getAttribute("data-situacao");
        document.getElementById("status").value = element.getAttribute("data-status");

        // Caso tenha uma capa já salva, exibir uma pré-visualização
        let capaAtual = element.getAttribute("data-capa");
        if (capaAtual) {
            let capaPreview = document.createElement("img");
            capaPreview.src = "vendor/uploads/videos/" + capaAtual;
            capaPreview.style = "width: 100px; height: auto; margin-top: 10px; border-radius: 5px;";
            let capaContainer = document.getElementById("capa").parentNode;
            let existingPreview = capaContainer.querySelector("img");
            if (existingPreview) {
                existingPreview.remove();
            }
            capaContainer.appendChild(capaPreview);
        }

        // Caso tenha um vídeo já salvo, exibir uma mensagem com o nome do arquivo
        let videoAtual = element.getAttribute("data-link");
        if (videoAtual) {
            let videoMsg = document.createElement("p");
            videoMsg.innerHTML = `<small>Vídeo atual: <strong>${videoAtual}</strong></small>`;
            let videoContainer = document.getElementById("link").parentNode;
            let existingMsg = videoContainer.querySelector("p");
            if (existingMsg) {
                existingMsg.remove();
            }
            videoContainer.appendChild(videoMsg);
        }
    }

    // Reset do formulário ao abrir para novo cadastro
    document.getElementById("offcanvasAddVideo").addEventListener("hidden.bs.offcanvas", function () {
        document.getElementById("offcanvasAddVideoLabel").textContent = "Adicionar Vídeo";
        document.getElementById("formVideo").reset();
        document.getElementById("formAction").value = "create";
        document.getElementById("videoId").value = "";
        document.getElementById("capa").parentNode.querySelector("img")?.remove();
        document.getElementById("link").parentNode.querySelector("p")?.remove();
    });
</script>
