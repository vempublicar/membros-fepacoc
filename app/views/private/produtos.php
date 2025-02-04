<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Função para normalizar strings (remover acentos, espaços extras e converter para minúsculas)
function normalizarTexto($texto) {
    $texto = trim($texto); // Remove espaços extras
    $texto = strtolower($texto); // Converte para minúsculas
    $texto = preg_replace('/\s+/', ' ', $texto); // Remove espaços duplicados
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); // Remove acentos
    return $texto;
}


// Função para buscar os dados apenas se não estiverem na sessão
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

$produtos = getSessionData('produtos', 'fetchProdutos');

// Pegando a categoria da URL e normalizando
$categoriaSelecionada = isset($_GET['categoria']) ? urldecode($_GET['categoria']) : '';
$categoriaSelecionada = normalizarTexto($categoriaSelecionada);

// Filtrando os produtos pela categoria normalizada
$produtosFiltrados = array_filter($produtos, function ($produto) use ($categoriaSelecionada) {
    if (!isset($produto['proCategoria'])) return false;
    return normalizarTexto($produto['proCategoria']) === $categoriaSelecionada || empty($categoriaSelecionada);
});
?>
<section class="portfolio py-5 mt-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Produtos <?= !empty($_GET['categoria']) ? 'em ' . htmlspecialchars($_GET['categoria'], ENT_QUOTES, 'UTF-8') : '' ?></h3>

    
        <div class="row" data-aos="fade-up">
            <?php if (!empty($produtosFiltrados)): ?>
                <?php foreach ($produtosFiltrados as $produto): ?>
                    <div class="col-6 col-lg-3 mb-4">
                        <div class="card shadow-sm rounded-4 border-0">
                            <a href="#" onclick="abrirProduto(
                                '<?= htmlspecialchars($produto['proNome']); ?>', 
                                '<?= $produto['proCapa']; ?>',
                                '<?= number_format($produto['proPreco'], 2, ',', '.'); ?>',
                                '<?= htmlspecialchars($produto['proSobre']); ?>',
                                '<?= $produto['proPagina']; ?>'
                            )">
                                <img src="vendor/uploads/produtos/<?= $produto['proCapa']; ?>" 
                                     class="card-img-top rounded-top-4" 
                                     alt="<?= htmlspecialchars($produto['proNome']); ?>">
                            </a>
                            <div class="card-body text-center text-dark">
                                <h5><?= htmlspecialchars($produto['proNome']); ?></h5>
                                <button class="btn btn-outline-secondary btn-sm" >
                                    <i class="fas fa-info-circle"></i> Detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhum produto encontrado nesta categoria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Offcanvas para Exibir os Detalhes do Produto -->
<div class="offcanvas offcanvas-end text-dark" tabindex="-1" id="productOffcanvas2" aria-labelledby="productOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="productOffcanvasLabel">Detalhes do Produto</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body text-dark">
        <img id="productOffcanvasImage" src="" class="img-fluid rounded-4 mb-3" alt="">
        <p class="text-primary fw-bold" id="productOffcanvasPrice"></p>
        <p id="productOffcanvasDescription"></p>
        <a id="productOffcanvasLink" href="#" class="btn btn-primary w-100" target="_blank">Abrir Página</a>
    </div>
</div>


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

<script>
    function abrirProduto(nome, imagem, preco, descricao, link) {
        document.getElementById('productOffcanvasLabel').innerText = nome;
        document.getElementById('productOffcanvasImage').src = 'vendor/uploads/produtos/' + imagem;
        document.getElementById('productOffcanvasPrice').innerText = 'R$ ' + preco;
        document.getElementById('productOffcanvasDescription').innerText = descricao;
        document.getElementById('productOffcanvasLink').href = link;

        var offcanvas = new bootstrap.Offcanvas(document.getElementById('productOffcanvas2'));
        offcanvas.show();
    }
</script>