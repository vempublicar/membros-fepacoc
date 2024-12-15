<?php include "app/views/parts/head.php";
?>

<body class="bg-dark">
  <div class=" vh-100 p-0 d-flex align-items-center fundo-difuso-login">
    <div class="row w-100 h-100 m-0 content">
      <!-- Coluna da imagem decorativa -->
      <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
        <!-- <h1 class="text-white" >Área de Membros Exclusiva</h1> -->
      </div>
      <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="card w-100 shadow" style="max-width: 400px; background-color:rgba(45, 52, 57, 0.0); border-radius: 30px; ">
          <div class="card-body  position-relative p-5" style="background-color:rgba(36, 39, 41, 0.8); border-radius: 30px;">
            <div class="text-center mb-4">
              <img src="vendor/img/logo-branco.png" alt="FEPACOC Logo" style="width: 150px; height: auto;">
            </div>
            <form action="app/functions/login-verificar.php" method="post">
              <div class="mb-3">
                <label for="email" class="form-label text-secondary">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label text-secondary">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <?php if (isset($_GET['msg']) && base64_decode($_GET['msg'], true)) { ?>
                  <div class="form-text text-center text-warning"><?= base64_decode($_GET['msg']) ?></div>
                <?php } ?>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-info text-secondary">Entrar</button>
              </div>
            </form>
            <div class="mt-3 text-center">
              <a href="esqueci-senha" class="text-secondary">Esqueceu a senha?</a>
            </div>
            <div class="mt-2 text-center">
              <a href="register" class="text-white">Criar uma nova conta</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>