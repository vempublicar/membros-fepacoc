<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";

?>

<div class="container my-5 mt-5">
    <div class="row">
        <!-- Plano ESTRATÉGIA -->
        <h2 class="text-center mb-4 mt-5">Planos do FEPACOC</h2>
        <div class="row justify-content-center">
            <div class="d-flex flex-wrap gap-3 justify-content-center py-5">
                <a href="painel" class="btn btn-dark text-decoration-none text-uppercase">Inicio</a>
                <a href="entregaveis" class="btn btn-dark text-decoration-none text-uppercase">Entregáveis</a>
                <a href="planos" class="btn btn-dark text-decoration-none text-uppercase">Planos e Preços</a>
                <a href="area-exclusiva" class="btn btn-dark text-decoration-none text-uppercase is-checked">Área Exclusiva</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark ">
                <div class="card-header bg-dark">
                    <h4 class=" text-center py-4">ESTRATÉGIA</h4>
                </div>
                <div class="card-body">
                    <h2 class="card-price text-center text-secondary">R$79<span class="period">/mês</span></h2>
                    <p class="price-discount text-center text-secondary">Plano anual com desconto<br><s>De R$958,00</s> Por: R$790,00</p>
                    <ul class="list-group">
                        <li class="list-group-item text-secondary"><i class="fas fa-check"></i> Acesso a Estratégias</li>
                        <li class="list-group-item text-secondary"><i class="fas fa-check"></i> Área de Membros Exclusiva</li>
                        <li class="list-group-item text-secondary"><i class="fas fa-check"></i> Implantação do Método Fepacoc</li>
                        <li class="list-group-item text-secondary"><i class="fas fa-check"></i> Treinamentos Avançados</li>
                        <li class="list-group-item text-secondary"><i class="fas fa-check"></i> Consultoria Via WhatsApp</li>
                    </ul>
                    <a href="#" class="btn btn-dark mt-3 w-100">Contratar</a>
                </div>
            </div>
        </div>
        <!-- Plano ANÁLISE -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success">
                    <h4 class="card-title py-4 text-center">ANÁLISE</h4>
                </div>
                <div class="card-body">
                    <h2 class="card-price text-center">R$247<span class="period">/mês</span></h2>
                    <p class="price-discount text-center text-secondary">Plano anual com desconto<br><s>De R$2.964,00</s> Por: R$1.976,00</p>
                    <ul class="list-group">
                        <li class="list-group-item"><i class="fas fa-check"></i> Consultor Analista</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Acesso a Estratégias Avançadas</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Reunião Mensal Por Vídeo</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Gestão Focada na Organização</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Relatórios e OKR's</li>
                    </ul>
                    <a href="#" class="btn btn-success mt-3 w-100">Contratar</a>
                </div>
            </div>
        </div>
        <!-- Plano CRESCIMENTO -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark">
                    <h4 class="card-title text-center py-4">CRESCIMENTO</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-price text-center">R$579<span class="period">/mês</span></h3>
                    <p class="price-discount text-center text-secondary">Plano anual com desconto<br><s>De R$6.948,00</s> Por: R$5.437,00</p>
                    <ul class="list-group">
                        <li class="list-group-item"><i class="fas fa-check"></i> Consultor Analista</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Treinamentos Exclusivos</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Reunião Semanal Por Vídeo</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Gestão Focada no Crescimento</li>
                        <li class="list-group-item"><i class="fas fa-check"></i> Relatórios e OKR's</li>
                    </ul>
                    <a href="#" class="btn btn-dark mt-3 w-100">Contratar</a>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <div class="row justify-content-center">
                <h3 class="text-center mb-4 mt-5">Qual escolher?</h3>
                <p class="text-center">Assista ao vídeo para entender melhor cada um dos planos oferecidos pelo FEPACOC e escolha <br> o mais adequado para o momento da sua empresa.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <video controls width="100%" height="auto">
                        <source src="path/to/your/video.mp4" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript Libraries -->
<script src="vendor/js/jquery-1.11.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="vendor/js/plugins.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>

<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<!-- <script src="vendor/js/script.js"></script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;

        // Verifica o tema salvo no localStorage
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }

        // Alterna o tema
        themeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");
            const isDarkMode = body.classList.contains("dark-mode");
            localStorage.setItem("theme", isDarkMode ? "dark" : "light");
            themeToggle.innerHTML = isDarkMode ?
                '<i class="fas fa-moon"></i>' :
                '<i class="fas fa-sun"></i>';
        });
    });
</script>