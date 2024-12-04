<?php include "app/views/parts/head.php";
?>
<body class="bg-dark">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card w-100 shadow" style="max-width: 400px; background-color: #242e36; border-radius: 20px;">
      <div class="card-body position-relative p-5">
      <img src="vendor/img/elemento.png" alt="Elemento Decorativo" style="position: absolute; right: 95%; top: 50%; transform: translateY(-50%); width: 150px; height: auto; border-radius: 20px;">
        <div class="text-center mb-4">
          <img src="vendor/img/logo-branco.png" alt="FEPACOC Logo" style="width: 150px; height: auto;">
        </div>
        <form action="app/functions/login-verificar.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label text-white">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label text-white">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <?php if(isset($_GET['msg']) && base64_decode($_GET['msg'], true)) { ?>
                    <div class="form-text text-center text-warning"><?= base64_decode($_GET['msg']) ?></div>
                <?php } ?>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-info">Entrar</button>
          </div>
        </form>
        <div class="mt-3 text-center">
          <a href="forgot-password.html" class="text-white">Esqueceu a senha?</a>
        </div>
        <div class="mt-2 text-center">
          <a href="register" class="text-white">Criar uma nova conta</a>
        </div>
      </div>
    </div>
  </div>
</body>
