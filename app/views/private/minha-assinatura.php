<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include_once "app/functions/data/busca-dados.php";

?>

<div class="container my-5">
        <h2>Assinaturas Ativas</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Exemplo de Card para Trafego Pago -->
            <div class="col">
                <div class="card h-100">
                    <img src="path/to/traffic-paid.jpg" class="card-img-top" alt="Trafego Pago">
                    <div class="card-body">
                        <h5 class="card-title">Tráfego Pago</h5>
                        <p class="card-text">Serviço especializado para aumentar a visibilidade do seu negócio online através de campanhas pagas.</p>
                        <p><strong>Valor:</strong> R$ 500,00/mês</p>
                        <p><strong>Data de Cadastro:</strong> 01/01/2024</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="solicitarSuporte('Trafego Pago')">Solicitar Suporte</button>
                        <button class="btn btn-danger" onclick="solicitarCancelamento('Trafego Pago')">Solicitar Cancelamento</button>
                    </div>
                </div>
            </div>
            <!-- Exemplo de Card para Suporte Especializado -->
            <div class="col">
                <div class="card h-100">
                    <img src="path/to/support-specialized.jpg" class="card-img-top" alt="Suporte Especializado">
                    <div class="card-body">
                        <h5 class="card-title">Suporte Especializado</h5>
                        <p class="card-text">Acesso direto a suporte técnico para garantir o máximo desempenho e solução de problemas.</p>
                        <p><strong>Valor:</strong> R$ 300,00/mês</p>
                        <p><strong>Data de Cadastro:</strong> 15/01/2024</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="solicitarSuporte('Suporte Especializado')">Solicitar Suporte</button>
                        <button class="btn btn-danger" onclick="solicitarCancelamento('Suporte Especializado')">Solicitar Cancelamento</button>
                    </div>
                </div>
            </div>
            <!-- Exemplo de Card para Consultoria de Marketing -->
            <div class="col">
                <div class="card h-100">
                    <img src="path/to/marketing-consultancy.jpg" class="card-img-top" alt="Consultoria de Marketing">
                    <div class="card-body">
                        <h5 class="card-title">Consultoria de Marketing</h5>
                        <p class="card-text">Consultoria completa para estratégias de marketing digital e offline para o seu negócio.</p>
                        <p><strong>Valor:</strong> R$ 800,00/mês</p>
                        <p><strong>Data de Cadastro:</strong> 10/02/2024</p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="solicitarSuporte('Consultoria de Marketing')">Solicitar Suporte</button>
                        <button class="btn btn-danger" onclick="solicitarCancelamento('Consultoria de Marketing')">Solicitar Cancelamento</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="vendor/js/jquery-1.11.0.min.js"></script> <!-- jquery file-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> <!--cdn link-->
<script src="vendor/js/plugins.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>

<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="vendor/js/script.js"></script>

