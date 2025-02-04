<?php
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

// Função para buscar os dados apenas se não estiverem na sessão
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

$assuntos = getSessionData('assuntos', 'fetchAssunto');
$categorias = getSessionData('categorias', 'fetchCategorias');

if (isset($_GET['a'])) {
    $categoriaSelecionada = urldecode($_GET['a']);
    $assuntosFiltrados = array_filter($assuntos, function ($assunto) use ($categoriaSelecionada) {
        return isset($assunto['categoria']) && $assunto['categoria'] === $categoriaSelecionada;
    });



?>

<div id="assuntoContainer" class="container mb-6">
    <section class="portfolio py-5 mt-5">
        <div class="grid p-0 clearfix row row-cols-1 row-cols-lg-2 row-cols-xl-3" id="assuntoGrid">
            <?php if (!empty($assuntosFiltrados)): ?>
                <?php foreach ($assuntosFiltrados as $assunto): ?>
                    <div class="col mb-4">
                        <a href="videos&assunto=<?= urlencode($assunto['assunto'])?>&categoria=<?= $_GET['a'] ?>" class="text-decoration-none">
                            <div class="card h-100 shadow-sm">
                                <?php 
                                // Define a imagem de capa: se existir uma imagem definida, usa-a; senão, utiliza uma imagem padrão.
                                $imgSrc = !empty($assunto['assCapa'])
                                    ? "vendor/uploads/assunto/" . htmlspecialchars($assunto['assCapa'])
                                    : "vendor/uploads/assunto/default.png";
                                ?>
                                <img src="<?= $imgSrc ?>"
                                     class="card-img-top"
                                     alt="Capa do Assunto"
                                     loading="lazy">
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Nenhum assunto encontrado para esta categoria.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php

} else {
    
?>
<div id="categoriaContainer" class="container mb-6">
    <section class="portfolio py-5 mt-5">
                <div class="row">
                    <div class="col text-start">
                        <p class="text-uppercase text-secondary">Todas Categorias 
                        </p>
                    </div>
                </div>     
                    <div class="grid p-0 clearfix row row-cols-1 row-cols-lg-2 row-cols-xl-4" >
                        <?php 
                            foreach ($categorias as $categoria): 
                                if ($categoria['catStatus'] === 'ativo'): 
                        ?>
                        <div class="col mb-4">
                            <a href="https://members.fepacoc.com.br/categoria&a=<?= $categoria['catNome']; ?>" 
                                onclick="trackUserAction('<?= $categoria['catNome']; ?>', '<?= $user['email'] ?>')">
                                <img src="vendor/uploads/categorias/<?= $categoria['catCapa']; ?>" class="img-fluid rounded-4" alt="Capa da categoria">
                            </a>
                        </div>
                        <?php 
                                endif;
                            endforeach;  
                        ?>
                    </div>

    </section>
</div>
<?php 
    
}
include 'app/views/parts/barra.php';
?>
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
