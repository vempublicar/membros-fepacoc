<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Ícones -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="vendor/css/projeto.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="z-depth-0 white">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo blue-text text-darken-3">Minha Área</a>
        </div>
    </nav>

    <!-- Formulário de Cadastro -->
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card z-depth-3">
                    <div class="card-content">
                        <h5 class="card-title center">Crie sua conta</h5>
                        <div class="form-container">
                            <form>
                                <!-- Nome Completo -->
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="nome_completo" type="text" class="validate" required>
                                    <label for="nome_completo">Nome Completo</label>
                                </div>
                                <!-- Email -->
                                <div class="input-field">
                                    <i class="material-icons prefix">email</i>
                                    <input id="email" type="email" class="validate" required>
                                    <label for="email">E-mail</label>
                                    <span class="helper-text">Usaremos este e-mail para notificações.</span>
                                </div>
                                <!-- Senha -->
                                <div class="input-field">
                                    <i class="material-icons prefix">lock</i>
                                    <input id="senha" type="password" class="validate" required>
                                    <label for="senha">Senha</label>
                                    <span class="helper-text">Use pelo menos 8 caracteres, incluindo números.</span>
                                </div>
                                <!-- Confirmar Senha -->
                                <div class="input-field">
                                    <i class="material-icons prefix">lock_outline</i>
                                    <input id="confirma_senha" type="password" class="validate" required>
                                    <label for="confirma_senha">Confirme sua Senha</label>
                                </div>
                                <!-- Botão de Cadastro -->
                                <div class="center">
                                    <button type="submit" class="btn btn-custom waves-effect waves-light">
                                        Criar Conta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Rodapé -->
                <footer>
                    <p>© 2024 Minha Área. Todos os direitos reservados.</p>
                </footer>
            </div>
        </div>
    </div>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
