<?php
session_start();
include "app/views/parts/head.php";

?>

<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card w-100 shadow" style="max-width: 400px; background-color: #242e36; border-radius: 20px;">
            <div class="card-body bg-dark position-relative p-5">
                <img src="vendor/img/elemento.png" alt="Elemento Decorativo" style="position: absolute; right: 95%; top: 50%; transform: translateY(-50%); width: 150px; height: auto; border-radius: 20px;">
                <div class="text-center mb-4">
                    <img src="vendor/img/logo-branco.png" alt="FEPACOC Logo" style="width: 150px; height: auto;">
                </div>
                <form action="app/functions/push/recover-password.php" method="post" id="passwordRecoveryForm">
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <?php if (isset($_GET['msg']) && base64_decode($_GET['msg'], true)) { ?>
                            <div class="form-text text-center text-warning">!*<?= base64_decode($_GET['msg']) ?></div>
                        <?php } else { ?>
                            <div class="form-text text-center text-secondary">Insira o email cadastrado para recuperar sua senha.</div>
                        <?php } ?>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-info" id="submitBtn" disabled>Recuperar Senha</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="login" class="text-white">Voltar para Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (necessário para os plugins JavaScript do Bootstrap e máscaras) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Enable submit button only if email field is filled
            $('#passwordRecoveryForm input').on('keyup change', function() {
                let valid = true;
                $('#passwordRecoveryForm input[required]').each(function() {
                    if ($(this).val() === '') {
                        valid = false;
                    }
                });
                $('#submitBtn').prop('disabled', !valid);
            });
        });
    </script>
</body>
