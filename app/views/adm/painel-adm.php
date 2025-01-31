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
</head>

<body>
    <?php include_once "app/views/parts/header.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Menu lateral -->
            <nav class="col-md-2 col-lg-2 d-md-block bg-dark text-white sidebar">
                <div class="p-3">
                    <h4 class="text-center">FEPACOC</h4>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#categorias">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#videos">Gerenciar Vídeos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#materiais">Gerenciar Materiais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#produtos">Gerenciar Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#ferramentas">Ferramentas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#leads">Lista Leads</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#capas">Capas</a>
                        </li>
                    </ul>
                    <hr>
                    <a href="painel" onclick="logout()" class="btn btn-danger w-100">Sair</a>
                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-4">
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
