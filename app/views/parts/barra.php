
<?php
if(isset($_GET['video']) && isset($_GET['assunto']) && isset($_GET['categoria'])){
    $home     = 'videos&assunto='.$_GET['assunto'].'&categoria='.$_GET['categoria']; 
}elseif(isset($_GET['categoria']) && isset($_GET['assunto'])){
    $home     = 'categoria&a='.$_GET['categoria']; 
}else{
    $home     = 'painel'; 
}
if(isset($_GET['video'])){
  $tipo = 'video';
  $favorito = $videoToView['id']; 
  $idUser = $_SESSION['user_id'];
} elseif(!isset($_GET['video']) && isset($_GET['assunto'])){
  $tipo = 'assunto';
  $favorito = $_GET['assunto']; 
  $idUser = $_SESSION['user_id']; 
} elseif(isset($_GET['ferramenta'])) { 
  $tipo = 'ferramenta'; 
  $favorito = $_GET['ferramenta'];  
  $idUser = $_SESSION['user_id']; 
} else { 
  $favorito = '';
}


if(isset($materialDownload) && $materialDownload > ""){
  $material = 'vendor/uploads/videos/material/'.$materialDownload; 
}

$busca    = '/buscar'; 
$idvideo  = ''; 
?>
 <div id="alertContainer" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1050;"></div>
<!-- Barra fixa no rodapé para mobile -->
<nav class="navbar navbar-dark bg-dark fixed-bottom d-md-none border-top">
    <div class="container-fluid justify-content-around">
      <!-- Botão Home -->
      <a href="<?= !empty($home) ? $home : '#' ?>" class="nav-link text-center <?= !empty($home) ? 'active' : '' ?>">
        <i class="fas fa-arrow-left fa-lg <?= !empty($home) ? 'text-white' : 'text-secondary' ?>"></i>
      </a>
      
      <!-- Botão Favoritar -->
      <button class="nav-link text-center <?= !empty($favorito) ? 'active' : '' ?>"
        <?= !empty($favorito) ? "onclick=\"addFavorito('{$favorito}', '{$tipo}')\"" : "" ?>>
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
  function addFavorito(favorito, tipo) {
    fetch('../../../functions/push/favorito.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'tipo=' + encodeURIComponent(tipo) + '&favorito=' + encodeURIComponent(favorito)
    })
    .then(response => response.json())
    .then(data => {
      // Seleciona o container de alerta
      const alertContainer = document.getElementById('alertContainer');

      // Define a classe do alerta (sucesso ou erro)
      const alertClass = data.status === 'success' ? 'alert-success' : 'alert-danger';

      // Cria o HTML do alerta utilizando os componentes do Bootstrap
      alertContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show m-3" role="alert">
          ${data.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;

      // Opcional: Remover o alerta após alguns segundos (por exemplo, 5 segundos)
      setTimeout(() => {
        const alert = bootstrap.Alert.getOrCreateInstance(document.querySelector('.alert'));
        alert.close();
      }, 5000);
    })
    .catch(error => {
      //console.error('Erro:', error);
      const alertContainer = document.getElementById('alertContainer');
      alertContainer.innerHTML = `
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
          Ocorreu um erro ao tentar salvar o favorito.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    });
  }
</script>

