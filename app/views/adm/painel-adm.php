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
    
    <style>
        :root {
            --header-height: 3rem;
            --nav-width: 68px;
            --first-color: #182433;
            --first-color-light: #AFA5D9;
            --white-color: #F7F6FB;
            --body-font: 'Nunito', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100;
        }

        *,::before,::after {
            box-sizing: border-box;
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s;
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: .5s;
        }

        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .header_img {
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .header_img img {
            width: 40px;
        }

        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed);
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .nav_logo, .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem;
        }

        .nav_logo {
            margin-bottom: 2rem;
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color);
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700;
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s;
        }

        .nav_link:hover {
            color: var(--white-color);
        }

        .nav_icon {
            font-size: 1.25rem;
        }

        .show {
            left: 0;
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem);
        }

        .active {
            color: var(--white-color);
        }

        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color);
        }

        .height-100 {
            height: 100vh;
        }

        @media screen and (min-width: 768px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem);
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
            }

            .header_img {
                width: 40px;
                height: 40px;
            }

            .header_img img {
                width: 45px;
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0;
            }

            .show {
                width: calc(var(--nav-width) + 156px);
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px);
            }
        }
    </style>
</head>

<body id="body-pd">
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
    const toggle = document.getElementById('header-toggle'),
          nav = document.getElementById('nav-bar'),
          bodypd = document.getElementById('body-pd'),
          headerpd = document.getElementById('header'),
          mainContent = document.querySelector('main'); 

    toggle.addEventListener('click', () => {
        nav.classList.toggle('show');
        toggle.classList.toggle('bx-x');

        // Ajuste de espaçamento do main
        if (nav.classList.contains('show')) {
            mainContent.style.marginLeft = "250px"; // Expande
        } else {
            mainContent.style.marginLeft = "68px"; // Recolhe
        }
    });

    function showSectionFromHash() {
        var hash = window.location.hash || "#dashboard";
        document.querySelectorAll('.content-section').forEach(el => el.style.display = 'none');
        if (document.querySelector(hash)) {
            document.querySelector(hash).style.display = 'block';
        }
        document.querySelectorAll('.nav_link').forEach(el => el.classList.remove('active'));
        const activeLink = document.querySelector(`a[href="${hash}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
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
