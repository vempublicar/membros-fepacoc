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
    <?php include_once "app/views/parts/head.php"; ?>
    <title>Área Administrativa - FEPACOC</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menu lateral com opção de recolher -->
            <nav id="sidebar" class="bg-dark text-white d-flex flex-column  position-fixed">
                <div class="p-3">
                    <button id="toggleMenu" class="btn btn-outline-light w-100 mb-3">
                        <i class="bi bi-list"></i>
                    </button>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#dashboard">
                                <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#categorias">
                                <i class="bi bi-card-list me-2"></i> <span class="menu-text">Categorias</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#videos">
                                <i class="bi bi-film me-2"></i> <span class="menu-text">Vídeos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#materiais">
                                <i class="bi bi-folder me-2"></i> <span class="menu-text">Materiais</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#produtos">
                                <i class="bi bi-box-seam me-2"></i> <span class="menu-text">Produtos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#ferramentas">
                                <i class="bi bi-wrench me-2"></i> <span class="menu-text">Ferramentas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#leads">
                                <i class="bi bi-people me-2"></i> <span class="menu-text">Leads</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="#capas">
                                <i class="bi bi-image me-2"></i> <span class="menu-text">Capas</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <a href="painel" onclick="logout()" class="btn btn-danger w-100">Sair</a>
                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main id="main-content" class="col-md-10 offset-md-2 col-lg-10 offset-lg-2 px-4">
                <header class="mb-4">
                    <h1 class="text-center">Área Administrativa - FEPACOC</h1>
                </header>

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
                <section id="capas" class="content-section" style="display: none;">
                    <?php include "app/views/adm/content/capas.php" ?>
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

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleMenu = document.getElementById('toggleMenu');
            const menuTextElements = document.querySelectorAll('.menu-text');

            let menuExpanded = true;

            toggleMenu.addEventListener('click', function () {
                if (menuExpanded) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.remove('offset-md-2', 'offset-lg-2');
                    menuTextElements.forEach(el => el.style.display = 'none');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.add('offset-md-2', 'offset-lg-2');
                    menuTextElements.forEach(el => el.style.display = 'inline');
                }
                menuExpanded = !menuExpanded;
            });

            function showSectionFromHash() {
                var hash = window.location.hash;
                if (hash) {
                    document.querySelectorAll('.content-section').forEach(el => el.style.display = 'none');
                    document.querySelector(hash).style.display = 'block';
                    document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
                    document.querySelector('a[href="' + hash + '"]').classList.add('active');
                } else {
                    document.querySelector('.content-section').style.display = 'block';
                    document.querySelector('.nav-link').classList.add('active');
                }
            }

            showSectionFromHash();
            document.querySelectorAll('.nav-link').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.location.hash = this.getAttribute('href');
                    showSectionFromHash();
                });
            });

            window.addEventListener('hashchange', showSectionFromHash);
        });

        function logout() {
            localStorage.removeItem('adminAccessToken');
            location.reload();
        }
    </script>
</body>

</html>
