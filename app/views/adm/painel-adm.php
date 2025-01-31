<?php
include "app/functions/data/busca-dados.php";

$videos = fetchVideos();
$produtos = fetchProdutos();
$materiais = fetchMateriais();
$leads = fetchLeads();
$categorias = fetchCategorias();
$ferramentas = fetchFerramentas();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php // include_once "app/views/parts/head.php"; ?>
    <title>Área Administrativa - FEPACOC</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/painel-style.css">

</head>

<body id="body-pd">
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
    

    <div class="d-flex">
        <div id="sidebar" style="height: 100%;" class="bg-dark d-flex flex-column flex-shrink-0 p-3 bg-light sidebar d-none d-md-flex">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 text-dark text-decoration-none">
                <span class="fs-4">FEPACOC</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#dashboard" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li><a href="#categorias" class="nav-link text-dark"><i class="bi bi-list me-2"></i> Categorias</a></li>
                <li><a href="#videos" class="nav-link text-dark"><i class="bi bi-play-btn me-2"></i> Vídeos</a></li>
                <li><a href="#materiais" class="nav-link text-dark"><i class="bi bi-folder me-2"></i> Materiais</a></li>
                <li><a href="#produtos" class="nav-link text-dark"><i class="bi bi-box me-2"></i> Produtos</a></li>
                <li><a href="#ferramentas" class="nav-link text-dark"><i class="bi bi-tools me-2"></i> Ferramentas</a></li>
                <li><a href="#capas" class="nav-link text-dark"><i class="bi bi-image me-2"></i> Capas</a></li>
                <li><a href="#leads" class="nav-link text-dark"><i class="bi bi-people me-2"></i> Leads</a></li>
            </ul>
            <hr>
            <a href="#" class="nav-link text-dark" onclick="logout()">
                <i class="bi bi-box-arrow-right me-2"></i> Sair
            </a>
        </div>
        <div id="sidebarMobile" class="d-flex flex-column flex-shrink-0 bg-light mobile-sidebar d-md-none">
            <a href="#" class="d-block p-3 link-dark text-decoration-none" title="Menu">
                <i class="bi bi-list" id="mobileMenuToggle"></i>
            </a>
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                <li class="nav-item">
                    <a href="#dashboard" class="nav-link active py-3 border-bottom" title="Dashboard">
                        <i class="bi bi-house-door"></i>
                    </a>
                </li>
                <li><a href="#categorias" class="nav-link py-3 border-bottom" title="Categorias"><i class="bi bi-list"></i></a></li>
                <li><a href="#videos" class="nav-link py-3 border-bottom" title="Vídeos"><i class="bi bi-play-btn"></i></a></li>
                <li><a href="#materiais" class="nav-link py-3 border-bottom" title="Materiais"><i class="bi bi-folder"></i></a></li>
                <li><a href="#produtos" class="nav-link py-3 border-bottom" title="Produtos"><i class="bi bi-box"></i></a></li>
                <li><a href="#ferramentas" class="nav-link py-3 border-bottom" title="Ferramentas"><i class="bi bi-tools"></i></a></li>
                <li><a href="#capas" class="nav-link py-3 border-bottom" title="Capas"><i class="bi bi-image"></i></a></li>
                <li><a href="#leads" class="nav-link py-3 border-bottom" title="Leads"><i class="bi bi-people"></i></a></li>
            </ul>
        </div>

        <!-- Área de Trabalho -->
        <main id="mainContent" class="container-fluid p-4">
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
            <section id="leads" class="content-section" style="display: none;">
                <?php include "app/views/adm/content/leads.php" ?>
            </section>
            <section id="ferramentas" class="content-section" style="display: none;">
                <?php include "app/views/adm/content/ferramentas.php" ?>
            </section>
            <section id="capas" class="content-section" style="display: none;">
                <?php include "app/views/adm/content/capas.php" ?>
            </section>
            <section id="categorias" class="content-section" style="display: none;">
                <?php include "app/views/adm/content/categorias.php" ?>
            </section>
        </main>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        document.addEventListener("DOMContentLoaded", function () {
   

    function showSectionFromHash() {
        var hash = window.location.hash || "#dashboard";
        document.querySelectorAll(".content-section").forEach(el => el.style.display = "none");
        document.querySelector(hash).style.display = "block";
        document.querySelectorAll(".nav-link").forEach(el => el.classList.remove("active"));
        document.querySelector(`a[href="${hash}"]`).classList.add("active");
    }

    showSectionFromHash();

    document.querySelectorAll(".nav-link").forEach(el => {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.hash = this.getAttribute("href");
            showSectionFromHash();
        });
    });

    window.addEventListener("hashchange", showSectionFromHash);
});
    </script>
</body>
</html>
