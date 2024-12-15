<?php
session_start();
include "app/views/parts/head.php";
?>

<body class="bg-dark">
    <div class=" vh-100 p-0 d-flex align-items-center fundo-difuso">
        <div class="row w-100 h-100 m-0 content">
            <!-- Coluna da imagem decorativa -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <!-- <h1 class="text-white" >Área de Membros Exclusiva</h1> -->
            </div>

            <!-- Coluna do formulário -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card w-100 shadow" style="max-width: 400px; background-color:rgba(45, 52, 57, 0.0); border-radius: 30px; ">
                    <div class="card-body  position-relative p-5" style="background-color:rgba(36, 39, 41, 0.8); border-radius: 30px;">
                        <div class="text-center mb-4">
                            <!-- Logotipo -->
                            <img src="vendor/img/logo-branco.png" alt="FEPACOC Logo" style="width: 150px; height: auto;">
                        </div>
                        <form action="app/functions/register-users.php" method="post" id="registrationForm">
                            <div class="mb-3">
                                <label for="name" class="form-label text-white">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email</label>
                                <input type="email" class="form-control" id="email" name="email-username" required>
                                <?php if (isset($_GET['msg']) && base64_decode($_GET['msg'], true)) { ?>
                                    <div class="form-text text-center text-warning">!*<?= base64_decode($_GET['msg']) ?></div>
                                <?php } else { ?>
                                    <div class="form-text text-center text-secondary">Uma senha será enviada para o seu email após o cadastro.</div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp" class="form-label text-white">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" required
                                    pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" placeholder="(00) 00000-0000">
                            </div>
                            <input type="hidden" id="password" name="password" value="<?php echo bin2hex(random_bytes(4)); ?>">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-info" id="submitBtn" disabled>Registrar</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="login" class="text-white">Já possui uma conta? Entrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Máscara -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#whatsapp').mask('(00) 00000-0000');

            // Enable submit button only if all fields are filled
            $('#registrationForm input').on('keyup change', function() {
                let valid = true;
                $('#registrationForm input[required]').each(function() {
                    if ($(this).val() === '') {
                        valid = false;
                    }
                });
                $('#submitBtn').prop('disabled', !valid);
            });
        });
    </script>
</body>