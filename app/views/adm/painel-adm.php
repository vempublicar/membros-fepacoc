<?php
include "app/functions/data/busca-dados.php";

$videos = fetchVideos();
$produtos = fetchProdutos();
$materiais = fetchMateriais();
$leads = fetchLeads();
$categorias = fetchCategorias();
$ferramentas = fetchFerramentas();
?>
<head>
    <?php include_once "app/views/parts/head.php"; ?>
    <title class="mt-6">Área Administrativa - FEPACOC</title>
</head>

<body>
    <?php // include_once "app/views/parts/header.php"; ?>

    <div class="container-fluid">
        <header class="mb-4">
            <h1 class="text-center">Área Administrativa - FEPACOC</h1>
        </header>

        <div class="row">
            <!-- Menu lateral para navegação -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#categorias">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#videos">Gerenciar Vídeos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#materiais">Gerenciar Materiais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#produtos">Gerenciar Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#aulas">Gerenciar Aulas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ferramentas">Ferramentas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#leads">Lista Leads</a>
                        </li>
                    </ul>
                    <a href="painel" onclick="logout()" class="btn btn-danger w-100" style=" bottom: 0;">Sair</a>
                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main class="col-md-10 ml-sm-auto col-lg-10 px-4">
                <section id="dashboard" class="content-section">
                    <h2>Dashboard</h2>
                    <p>Bem-vindo à sua área administrativa. Use os menus à esquerda para navegar.</p>
                </section>
                <section id="videos" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/videos.php" ?>
                </section>
                <section id="materiais" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/materiais.php" ?>
                </section>
                <section id="produtos" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/produtos.php" ?>
                </section>
                <section id="aulas" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/aulas.php" ?>
                </section>
                <section id="leads" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/leads.php" ?>
                </section>
                <section id="categorias" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/categorias.php" ?>
                </section>
                <section id="ferramentas" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/ferramentas.php" ?>
                </section>
            </main>
        </div>
        
    </div>

    <!-- Offcanvas para o formulário -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="videoOffcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasLabel">Inserir</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="app/functions/push/crud-video.php" id="addVideoForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="videoId">
                <div class="mb-3">
                    <label for="videoForm" class="form-label">Formato</label>
                    <select class="form-control" id="videoForm" name="form" required>
                        <option value="Video Curto" selected>Video Curto</option>
                        <option value="Produto">Produto</option>
                        <option value="Material">Material</option>
                        <option value="Aula">Aula</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="videoTitle" class="form-label">Título do Vídeo</label>
                    <input type="text" class="form-control" id="videoTitle" name="videoTitle" required>
                </div>
                <div class="mb-3">
                    <label for="videoLink" class="form-label">Link do Vídeo</label>
                    <input type="text" class="form-control" id="videoLink" name="videoLink" required>
                </div>
                <div class="mb-3">
                    <label for="videoCover" class="form-label">Capa do Vídeo</label>
                    <input type="file" class="form-control" id="videoCover" name="videoCover" accept="image/*">
                    <img id="videoCoverPreview" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                    <label for="videoSector" class="form-label">Setor</label>
                    <input type="text" class="form-control" id="videoSector" name="videoSector" required>
                </div>
                <div class="mb-3">
                    <label for="videoCategory" class="form-label">Categoria</label>
                    <select class="form-control" id="videoCategory" name="videoCategory">
                        <option>Financeiro</option>
                        <option>Estrutura</option>
                        <option>Produto</option>
                        <option>Anúncio</option>
                        <option>Cliente</option>
                        <option>Operacional</option>
                        <option>Consistência</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="videoType" class="form-label">Tipo</label>
                    <select class="form-control" id="videoType" name="videoType">
                        <option>Pago</option>
                        <option>Gratuito</option>
                        <option>Destaque</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="videoShort" class="form-label">Short</label>
                    <select class="form-control" id="videoShort" name="videoShort">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="stauts" name="status">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="videoDesc" class="form-label">Descrição</label>
                    <textarea class="form-control" id="videoDesc" name="videoDesc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
    <!-- Modal para exibir o vídeo -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Vídeo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="videoIframe" src="" width="100%" height="400" frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="accessModal" tabindex="-1" aria-labelledby="accessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessModalLabel">Validação de Acesso</h5>
                </div>
                <div class="modal-body">
                    <form id="accessForm" method="POST">
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Digite a senha para acessar</label>
                            <input type="password" class="form-control" id="adminPassword" name="adminPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Validar</button>
                    </form>
                    <div id="errorFeedback" class="text-danger mt-2" style="display: none;">Senha inválida. Tente novamente.</div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accessModal = new bootstrap.Modal(document.getElementById('accessModal'), {
                backdrop: 'static',
                keyboard: false
            });
            const token = localStorage.getItem('adminAccessToken');

            if (token) {
                // Verifica o token no servidor
                validateToken(token, accessModal);
            } else {
                // Exibe o modal se não houver token
                accessModal.show();
            }

            // Valida a senha e salva o token
            document.getElementById('accessForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const password = document.getElementById('adminPassword').value;

                fetch('app/functions/validate-access.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            password: password
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Salva o token no localStorage
                            localStorage.setItem('adminAccessToken', data.token);
                            accessModal.hide();
                        } else {
                            document.getElementById('errorFeedback').style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            });
        });

        // Função para validar o token no servidor
        function validateToken(token, accessModal) {
            fetch('app/functions/validate-token.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        token: token
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') {
                        // Token inválido: Exibe o modal para senha
                        localStorage.removeItem('adminAccessToken'); // Remove token inválido
                        accessModal.show();
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    accessModal.show();
                });
        }
        function logout() {
            localStorage.removeItem('adminAccessToken');
            location.reload(); // Recarrega a página
        }
    </script>
    <script>
        $(document).ready(function() {
            // Função para mostrar a seção com base no fragmento da URL
            function showSectionFromHash() {
                var hash = window.location.hash; // Pega o fragmento da URL
                if (hash) {
                    $('.content-section').hide(); // Esconde todas as seções
                    $(hash).show(); // Mostra a seção com o id correspondente ao fragmento
                    $('.nav-link').removeClass('active'); // Remove a classe 'active' de todos os links
                    $('a[href="' + hash + '"]').addClass('active'); // Adiciona a classe 'active' ao link correspondente
                } else {
                    // Se não houver hash, mostra a seção padrão
                    $('.content-section').first().show();
                    $('.nav-link').first().addClass('active');
                }
            }

            // Chamada inicial para mostrar a seção quando a página carrega
            showSectionFromHash();

            // Evento de clique para os links do menu
            $('.nav-link').click(function(e) {
                e.preventDefault();
                var targetId = $(this).attr('href');
                window.location.hash = targetId; // Atualiza o hash na URL
                showSectionFromHash(); // Atualiza a visibilidade da seção
            });

            // Evento para lidar com mudanças no hash (quando o usuário utiliza o botão de voltar do navegador)
            $(window).on('hashchange', function() {
                showSectionFromHash();
            });
        });
    </script>
    <script>
        document.getElementById('videoCover').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('videoCoverPreview');
                output.src = reader.result;
                output.style.display = 'block'; // Mostra a imagem
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                var output = document.getElementById('videoCoverPreview');
                output.src = '';
                output.style.display = 'none'; // Esconde a imagem se não houver arquivo
            }
        });

        function openVideoModal(link, title, internalVideo = null) {
            let embedLink;

            // Vimeo
            if (link && link.includes('vimeo.com')) {
                const videoId = link.split('/').pop().split('?')[0]; // Extrai o ID do vídeo
                embedLink = `https://player.vimeo.com/video/${videoId}`;

                // YouTube
            } else if (link && (link.includes('youtube.com') || link.includes('youtu.be'))) {
                let videoId;
                if (link.includes('youtube.com')) {
                    const urlParams = new URLSearchParams(new URL(link).search);
                    videoId = urlParams.get('v'); // Extrai o parâmetro 'v'
                } else {
                    videoId = link.split('/').pop(); // Extrai o ID do vídeo de um link curto
                }
                embedLink = `https://www.youtube.com/embed/${videoId}`;

                // Armazenamento interno
            } else if (internalVideo) {
                embedLink = `vendor/videos/play/${internalVideo}`;

                // Link genérico
            } else if (link) {
                embedLink = link; // Usa o link diretamente como iframe genérico

                // Fallback
            } else {
                embedLink = ''; // Fallback vazio se nada estiver disponível
            }

            // Configurar o título do modal
            const modalTitle = document.getElementById('videoModalLabel');
            modalTitle.textContent = title;

            // Configurar o iframe com o link do vídeo
            const videoIframe = document.getElementById('videoIframe');
            videoIframe.src = embedLink;

            // Abrir o modal
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            videoModal.show();
        }

        // Limpar o iframe ao fechar o modal
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            const videoIframe = document.getElementById('videoIframe');
            videoIframe.src = '';
        });

        // Limpar o iframe ao fechar o modal
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            const videoIframe = document.getElementById('videoIframe');
            videoIframe.src = '';
        });

        // Limpar o iframe ao fechar o modal
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            const videoIframe = document.getElementById('videoIframe');
            videoIframe.src = '';
        });

        // Limpar o iframe ao fechar o modal para evitar reprodução contínua
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            const videoIframe = document.getElementById('videoIframe');
            videoIframe.src = '';
        });



        document.addEventListener('DOMContentLoaded', () => {
            // Função para abrir o modal e preencher os dados
            window.openPromoteModal = function(lead) {
                // Preenche os campos do formulário com os dados do lead
                document.getElementById('leadId').value = lead.id;
                document.getElementById('leadName').value = lead.nome;
                document.getElementById('leadEmail').value = lead.email;
                document.getElementById('leadPhone').value = lead.fone;
                document.getElementById('leadAccess').value = lead.acesso;
                document.getElementById('leadType').value = lead.tipo || 'Gratuito'; // Preenche ou define como "Gratuito" por padrão
                document.getElementById('leadDados').value = lead.dados || '';

                // Define o valor padrão do campo "action"
                document.getElementById('action').value = 'update';

                // Abre o modal (usando Bootstrap)
                const promoteModal = new bootstrap.Modal(document.getElementById('promoteModal'));
                promoteModal.show();
            };

            document.querySelectorAll('#promoteForm button[type="submit"]').forEach(button => {
                button.addEventListener('click', function(event) {
                    // Impede o comportamento padrão do botão temporariamente
                    event.preventDefault();

                    // Altere o valor do campo oculto "action" com base no botão clicado
                    const form = document.getElementById('promoteForm');
                    const action = this.getAttribute('data-action');
                    document.getElementById('action').value = action;

                    // Submete o formulário
                    form.submit();
                });
            });

        });
    </script>

</body>

</html>