<?php
session_start();
include_once "app/views/parts/head.php";
include_once "app/views/parts/header.php";
include "app/functions/data/busca-dados.php";

/**
 * Função para buscar os dados apenas se não estiverem na sessão.
 */
function getSessionData($key, $fetchFunction) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $fetchFunction();
    }
    return $_SESSION[$key];
}

// Carrega os vídeos da sessão ou do banco de dados
$videos = getSessionData('videos', 'fetchVideos');

// Obtém o ID do vídeo a ser editado (passado via GET, por exemplo: editar_video.php?video=123)
$idvideo = isset($_GET['video']) ? $_GET['video'] : 0;

// Procura o vídeo correspondente no array
$videoToEdit = null;
foreach ($videos as $video) {
    if ($video['idvideo'] == $idvideo) {
        $videoToEdit = $video;
        break;
    }
}

// Se o vídeo não for encontrado, exibe uma mensagem e interrompe a execução
if (!$videoToEdit) {
    echo "<div class='container py-5'><h3>Vídeo não encontrado.</h3></div>";
    include_once "app/views/parts/footer.php";
    exit;
}
?>

<section class="container py-5">
    <h3 class="fw-bold mb-4">Editar Vídeo: <?= htmlspecialchars($videoToEdit['vidTitulo']); ?></h3>
    <!-- Formulário para editar os dados do vídeo -->
    <form action="salvar_video.php" method="POST" enctype="multipart/form-data">
        <!-- Campo oculto com o ID do vídeo -->
        <input type="hidden" name="idvideo" value="<?= htmlspecialchars($videoToEdit['idvideo']); ?>">
        
        <!-- Título do vídeo -->
        <div class="mb-3">
            <label for="vidTitulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="vidTitulo" name="vidTitulo" value="<?= htmlspecialchars($videoToEdit['vidTitulo']); ?>" required>
        </div>
        
        <!-- Resumo do vídeo -->
        <div class="mb-3">
            <label for="vidResumo" class="form-label">Resumo</label>
            <textarea class="form-control" id="vidResumo" name="vidResumo" rows="2" required><?= htmlspecialchars($videoToEdit['vidResumo']); ?></textarea>
        </div>
        
        <!-- Descrição do vídeo -->
        <div class="mb-3">
            <label for="vidDesc" class="form-label">Descrição</label>
            <textarea class="form-control" id="vidDesc" name="vidDesc" rows="4" required><?= htmlspecialchars($videoToEdit['vidDesc']); ?></textarea>
        </div>
        
        <!-- Produtor -->
        <div class="mb-3">
            <label for="vidProdutor" class="form-label">Produtor</label>
            <input type="text" class="form-control" id="vidProdutor" name="vidProdutor" value="<?= htmlspecialchars($videoToEdit['vidProdutor']); ?>" required>
        </div>
        
        <!-- Link do vídeo (local ou externo) -->
        <div class="mb-3">
            <label for="vidLink" class="form-label">Link do Vídeo</label>
            <input type="text" class="form-control" id="vidLink" name="vidLink" value="<?= htmlspecialchars($videoToEdit['vidLink']); ?>" required>
        </div>
        
        <!-- Se houver link externo, você pode exibir um campo para ele (opcional) -->
        <div class="mb-3">
            <label for="vidLinkExterno" class="form-label">Link Externo (opcional)</label>
            <input type="text" class="form-control" id="vidLinkExterno" name="vidLinkExterno" value="<?= isset($videoToEdit['vidLinkExterno']) ? htmlspecialchars($videoToEdit['vidLinkExterno']) : ''; ?>">
        </div>
        
        <!-- Capa do vídeo -->
        <div class="mb-3">
            <label for="vidCapa" class="form-label">Capa do Vídeo</label>
            <input type="file" class="form-control" id="vidCapa" name="vidCapa">
            <?php if (!empty($videoToEdit['vidCapa'])): ?>
                <div class="mt-2">
                    <img src="vendor/uploads/videos/capa/<?= htmlspecialchars($videoToEdit['vidCapa']); ?>" alt="Capa do vídeo" class="img-fluid rounded" style="max-width: 200px;">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Outros campos que você deseje editar podem ser adicionados aqui -->
        
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</section>

<?php include_once "app/views/parts/footer.php"; ?>
