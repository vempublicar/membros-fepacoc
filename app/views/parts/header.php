<header id="top" class="position-sticky top-0 start-0" style="z-index: 999;">
    <nav class="navbar navbar-expand-lg bg-dark fixed-top shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="painel">
                    <img src="vendor/img/logo_escuro.png" class="img-fluid" style="height: 22px;" id="logo" alt="Logo">
                </a>
            </div>

            <!-- Botão de Toggle para Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links do Menu Centralizados -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="painel">Painel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="entregaveis">Entregáveis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ferramentas">Ferramentas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicos">Serviços</a>
                    </li>
                </ul>
            </div>

            <!-- Perfil e Configurações -->
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a href="#" id="profileDropdown" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="vendor/images/post-thumb-1.jpg" alt="User Profile" class="rounded-circle" width="40" height="40">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item text-black" href="painel">Início</a></li>
                        <li><a class="dropdown-item text-black" href="minha-conta">Conta</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-black" href="#" id="themeToggle">Tema: <span id="themeLabel">Light</span></a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-black" href="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>