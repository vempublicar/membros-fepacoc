
<?php
if(isset($_GET['video']) && isset($_GET['assunto']) && isset($_GET['categoria'])){
    $home     = 'videos&assunto='.$_GET['assunto'].'&categoria='.$_GET['categoria']; 
}elseif(isset($_GET['categoria']) && isset($_GET['assunto'])){
    $home     = 'categoria&a='.$_GET['categoria']; 
}else{
    $home     = 'painel'; 
}
$favorito = ''; 
if(isset($materialDownload) && $materialDownload > ""){
  $material = 'vendor/uploads/videos/material/'.$materialDownload; 
}

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
      <button class="nav-link text-center <?= !empty($favorito) ? 'active' : '' ?>"
         <?= !empty($favorito) ? "onclick=\"addfavorito('{$favorito}', '{$idvideo}')\"" : "" ?>>
        <i class="fas fa-star fa-lg <?= !empty($favorito) ? 'text-white' : 'text-secondary' ?>"></i>
      </button>
      
      <!-- Botão Material Apoio -->
      <?php if (!empty($material)): ?>
        <a class="nav-link text-center active" href="<?= $material ?>" download>
          <i class="fas fa-book fa-lg text-white"></i>
        </a>
      <?php else: ?>
        <button class="nav-link text-center">
          <i class="fas fa-book fa-lg text-secondary"></i>
        </button>
      <?php endif; ?>
      
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
