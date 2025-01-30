<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include_once "app/functions/data/busca-dados.php";



?>

<div class="container mt-5">
    <div class="row">
        <h2 class="mb-3 mt-5">Minha Conta
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#companyModal">
                Adicionar Dados Profissionais
            </button>
        </h2>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4>Dados Pessoais</h4>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                    <p><strong>Conta:</strong> <?= htmlspecialchars($user['tipo']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h4>Dados Profissionais</h4>
                    <?php if (!empty($dadosProfissionais)): ?>
                        <p><strong>Empresa:</strong> <?= htmlspecialchars($dadosProfissionais['empresa'] ?? 'N/A'); ?></p>
                        <p><strong>CNPJ:</strong> <?= htmlspecialchars($dadosProfissionais['cnpj'] ?? 'N/A'); ?></p>
                        <p><strong>Setor:</strong> <?= htmlspecialchars($dadosProfissionais['setor'] ?? 'N/A'); ?></p>
                        <p><strong>Cidade:</strong> <?= htmlspecialchars($dadosProfissionais['cidade'] ?? 'N/A'); ?></p>
                        <p><strong>Estado:</strong> <?= htmlspecialchars($dadosProfissionais['estado'] ?? 'N/A'); ?></p>
                        <p><strong>Faturamento:</strong> <?= htmlspecialchars($dadosProfissionais['faturamento'] ?? 'N/A'); ?></p>
                        <p><strong>Necessidades:</strong> 
                            <?= isset($dadosProfissionais['necessidade']) && is_array($dadosProfissionais['necessidade']) 
                                ? htmlspecialchars(implode(', ', $dadosProfissionais['necessidade'])) 
                                : 'N/A'; ?>
                        </p>
                    <?php else: ?>
                        <p>Você ainda não adicionou dados profissionais.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="companyForm" method="POST" action="app/functions/push/save_lead.php">
                <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                <input type="hidden" name="tipo" value="Empresa">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Adicionar Dados Profissionais</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <!-- Nome Completo e Empresa -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">Empresa</small>
                                <input class="form-control" type="text" name="empresa" placeholder="Nome da Empresa">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">CNPJ</small>
                                <input class="form-control" type="text" name="cnpj" id="cnpj" placeholder="00.000.000/0000-00">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <small>Diga qual seu setor e ramo. Fale um pouco sobre o que precisa melhorar na sua empresa.</small>
                                <textarea class="form-control text-secondary" name="setor" rows="3" placeholder="Ex: Setor de Varejo, Ramo Vendas de Roupas. Minha dificuldade é no marketing..."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Telefone e Email -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">E-mail Comercial</small>
                                <input class="form-control" type="email" name="emailPro" required placeholder="Digite seu e-mail">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">WhatsApp Comercial</small>
                                <input class="form-control" type="text" name="phone" id="phone" placeholder="Digite seu telefone">
                            </div>
                        </div>
                    </div>
                    <!-- CEP, Cidade e Estado -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <small for="cep" class="form-label">CEP</small>
                                <input class="form-control" type="text" name="cep" id="cep" required placeholder="Digite seu CEP" onblur="buscarCEP()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <small for="cidade" class="form-label">Cidade</small>
                                <input class="form-control" type="text" name="cidade" id="cidade" readonly placeholder="Cidade">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <small for="estado" class="form-label">Estado</small>
                                <input class="form-control" type="text" name="estado" id="estado" readonly placeholder="Estado">
                            </div>
                        </div>
                    </div>
                    <!-- Faturamento e Prioridade -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">Faturamento</small>
                                <select class="form-select" name="faturamento">
                                    <option value="10 à 20mil">Entre 10 mil e 20 mil/mês</option>
                                    <option value="20 à 50mil">Entre 20 mil e 50 mil/mês</option>
                                    <option value="50 à 100mil">Entre 50 mil e 100 mil/mês</option>
                                    <option value="100 à 500mil">Entre 100 mil e 500 mil/mês</option>
                                    <option value="+ de 500mil">Mais de 500 mil/mês</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="form-label">Prioridade</small>
                                <select class="form-select" name="prioridade">
                                    <option value="Aumentar Faturamento">Aumentar Faturamento</option>
                                    <option value="Melhorar Margem de Lucro">Melhorar a Margem de Lucro</option>
                                    <option value="Organizar Processos">Organizar Processos</option>
                                    <option value="Atrair Novos Clientes">Atrair Novos Clientes</option>
                                    <option value="Aprimorar Marketing">Aprimorar Marketing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Necessidades -->
                    <div class="mb-3">
                        <small>Quais soluções do Fepacoc despertam mais interesse em você neste momento?</small>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Consultoria de Gestão">
                                    <label class="form-check-label">Consultoria de Gestão</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Treinamento e Aulas">
                                    <label class="form-check-label">Treinamento e Aulas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Financeiro e Ativos">
                                    <label class="form-check-label">Financeiro e Ativos</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Estrutura e Funcionários">
                                    <label class="form-check-label">Estrutura e Funcionários</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Produtos e Precificação">
                                    <label class="form-check-label">Produtos e Precificação</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necessidade[]" value="Anúncios e Marketing">
                                    <label class="form-check-label">Anúncios e Marketing</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>

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

<script>
    function buscarCEP() {
        const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao consultar o CEP.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.erro) {
                        // Preenche os campos de cidade e estado
                        document.getElementById('cidade').value = data.localidade || '';
                        document.getElementById('estado').value = data.uf || '';
                    } else {
                        alert("CEP não encontrado.");
                        limparCamposCEP(); // Limpa os campos em caso de erro
                    }
                })
                .catch(error => {
                    console.error('Erro ao consultar o CEP:', error);
                    alert("Erro ao consultar o CEP.");
                    limparCamposCEP(); // Limpa os campos em caso de erro
                });
        } else {
            alert("CEP inválido. Certifique-se de digitar 8 números.");
            limparCamposCEP(); // Limpa os campos em caso de erro
        }
    }

    // Função para limpar os campos de cidade e estado
    function limparCamposCEP() {
        document.getElementById('cidade').value = '';
        document.getElementById('estado').value = '';
    }

    // Aplicar máscara ao campo de CEP
    document.getElementById('cep').addEventListener('input', function(e) {
        e.target.value = e.target.value
            .replace(/\D/g, '') // Remove tudo que não for número
            .replace(/(\d{5})(\d)/, '$1-$2') // Adiciona o traço
            .slice(0, 9); // Limita a 9 caracteres
    });
    document.getElementById('cnpj').addEventListener('input', function(e) {
        e.target.value = e.target.value
            .replace(/\D/g, '') // Remove tudo que não for número
            .replace(/^(\d{2})(\d)/, '$1.$2') // Primeiro ponto
            .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3') // Segundo ponto
            .replace(/\.(\d{3})(\d)/, '.$1/$2') // Barra
            .replace(/(\d{4})(\d)/, '$1-$2') // Traço
            .slice(0, 18); // Limita ao tamanho do CNPJ
    });

    // Máscara para Telefone
    document.getElementById('phone').addEventListener('input', function(e) {
        e.target.value = e.target.value
            .replace(/\D/g, '')
            .replace(/^(\d{2})(\d)/g, '($1) $2')
            .replace(/(\d{5})(\d)/, '$1-$2')
            .slice(0, 15);
    });
</script>