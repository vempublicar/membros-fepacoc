
<?php
if(isset($_GET['video']) && isset($_GET['assunto'])){
    $home     = 'videos&assunto='.$_GET['assunto']; 
}elseif(isset($_GET['categoria']) && isset($_GET['assunto'])){
    $home     = 'categoria&a='.$_GET['categoria']; 
}else{
    $home     = 'painel'; 
}
$favorito = ''; 
$material = ''; 
$busca    = '/buscar'; 
$idvideo  = ''; 
?>

<!-- Barra fixa no rodapé para mobile -->
<nav class="navbar navbar-dark bg-dark fixed-bottom d-md-none border-top">
    <div class="container-fluid justify-content-around">
      <!-- Botão Home -->
      <a href="<?= !empty($home) ? $home : '#' ?>" class="nav-link text-center <?= !empty($home) ? 'active' : '' ?>">
        <i class="fas fa-arrow-left fa-lg <?= !empty($home) ? 'text-white' : 'text-secondary' ?>"></i>
      </a>
      
      <!-- Botão Favoritar -->
      <a href="#" class="nav-link text-center <?= !empty($favorito) ? 'active' : '' ?>"
         <?= !empty($favorito) ? "onclick=\"addfavorito('{$favorito}', '{$idvideo}')\"" : "" ?>>
        <i class="fas fa-star fa-lg <?= !empty($favorito) ? 'text-white' : 'text-secondary' ?>"></i>
      </a>
      
      <!-- Botão Material Apoio -->
      <a href="#" class="nav-link text-center <?= !empty($material) ? 'active' : '' ?>"
         <?= !empty($material) ? "onclick=\"baixarconteudo('{$material}')\"" : "" ?>>
        <i class="fas fa-book fa-lg <?= !empty($material) ? 'text-white' : 'text-secondary' ?>"></i>
      </a>
      
      <!-- Botão Pesquisa (sempre ativo) -->
      <a href="<?= $busca ?>" class="nav-link text-center active">
        <i class="fas fa-search fa-lg text-white"></i>
      </a>
    </div>
  </nav>
  <script>
    function addfavorito(favorito, idvideo) {
      // Exemplo de função para adicionar favorito
      alert('Adicionando favorito: ' + favorito + ' para o vídeo ' + idvideo);
      // Sua lógica aqui...
    }

    function baixarconteudo(material) {
      // Exemplo de função para baixar material de apoio
      alert('Baixando conteúdo: ' + material);
      // Sua lógica aqui...
    }
  </script>
