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
    <header class="header" id="header">
        <div class="header_toggle"> 
            <i class='bx bx-menu' id="header-toggle"></i> 
        </div>
        <div class="header_img"> 
            <img src="https://i.imgur.com/hczKIze.jpg" alt=""> 
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="#" class="nav_logo"> 
                    <i class='bx bx-layer nav_logo-icon'></i> 
                    <span class="nav_logo-name">FEPACOC</span> 
                </a>
                <div class="nav_list">
                    <a href="#dashboard" class="nav_link active"> 
                        <i class='bx bx-grid-alt nav_icon'></i> 
                        <span class="nav_name">Dashboard</span> 
                    </a>
                    <a href="#categorias" class="nav_link"> 
                        <i class='bx bx-food-menu nav_icon'></i> 
                        <span class="nav_name">Categorias</span> 
                    </a>
                    <a href="#videos" class="nav_link"> 
                        <i class='bx bx-film nav_icon'></i> 
                        <span class="nav_name">Vídeos</span> 
                    </a>
                    <a href="#materiais" class="nav_link"> 
                        <i class='bx bx-folder nav_icon'></i> 
                        <span class="nav_name">Materiais</span> 
                    </a>
                    <a href="#produtos" class="nav_link"> 
                        <i class='bx bx-box nav_icon'></i> 
                        <span class="nav_name">Produtos</span> 
                    </a>
                    <a href="#ferramentas" class="nav_link"> 
                        <i class='bx bx-wrench nav_icon'></i> 
                        <span class="nav_name">Ferramentas</span> 
                    </a>
                    <a href="#capas" class="nav_link"> 
                        <i class='bx bx-image nav_icon'></i> 
                        <span class="nav_name">Capas</span> 
                    </a>
                    <a href="#leads" class="nav_link"> 
                        <i class='bx bx-user nav_icon'></i> 
                        <span class="nav_name">Leads</span> 
                    </a>
                </div>
                <a href="painel" onclick="logout()" class="nav_link"> 
                    <i class='bx bx-log-out nav_icon'></i> 
                    <span class="nav_name">Sair</span> 
                </a>
            </div>
        </nav>
    </div>

    <main class="col-md-12 ml-sm-auto col-lg-12 px-4">
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
            const showNavbar = (toggleId, navId, bodyId, headerId) =>{
const toggle = document.getElementById(toggleId),
nav = document.getElementById(navId),
bodypd = document.getElementById(bodyId),
headerpd = document.getElementById(headerId)

// Validate that all variables exist
if(toggle && nav && bodypd && headerpd){
toggle.addEventListener('click', ()=>{
// show navbar
nav.classList.toggle('show')
// change icon
toggle.classList.toggle('bx-x')
// add padding to body
bodypd.classList.toggle('body-pd')
// add padding to header
headerpd.classList.toggle('body-pd')
})
}
}

showNavbar('header-toggle','nav-bar','body-pd','header')

            function showSectionFromHash() {
                var hash = window.location.hash || "#dashboard";
                document.querySelectorAll('.content-section').forEach(el => el.style.display = 'none');
                document.querySelector(hash).style.display = 'block';
                document.querySelectorAll('.nav_link').forEach(el => el.classList.remove('active'));
                document.querySelector('a[href="' + hash + '"]').classList.add('active');
            }

            showSectionFromHash();
            document.querySelectorAll('.nav_link').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.location.hash = this.getAttribute('href');
                    showSectionFromHash();
                });
            });

            window.addEventListener('hashchange', showSectionFromHash);
        });
    </script>
</body>
</html>
