<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";

?>

<div class="container my-5 mt-5">
    <div class="row">
        <!-- Plano ESTRATÉGIA -->
        <h2 class="text-center mb-4 mt-5">Planos do FEPACOC</h2>
        
        <div class="col-md-4">
            <div class="card bg-dark">
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

<?php include 'app/views/parts/footer.php' ?>
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