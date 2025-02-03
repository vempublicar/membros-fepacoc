<header id="top" class="position-sticky top-0 start-0" style="z-index: 999;">
    <nav class="navbar navbar-expand-lg bg-light fixed-top shadow-sm">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            
            <!-- Logo -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="painel">
                    <img src="vendor/img/logo_escuro.png" class="img-fluid" style="height: 22px;" id="logo" alt="Logo">
                </a>
            </div>

            <!-- Menu Centralizado no Desktop -->
            <div class="d-none d-lg-block">
                <ul class="navbar-nav text-center d-flex flex-row gap-3">
                    <li class="nav-item"><a class="nav-link" href="painel">Painel</a></li>
                    <li class="nav-item"><a class="nav-link" href="sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="entregaveis">Entregáveis</a></li>
                    <li class="nav-item"><a class="nav-link" href="ferramentas">Ferramentas</a></li>
                    <li class="nav-item"><a class="nav-link" href="servicos">Serviços</a></li>
                </ul>
            </div>

            <!-- Wrapper para alinhar Menu e Perfil no mobile -->
            <div class="d-flex align-items-center gap-3 ms-auto">

                <!-- Menu como Dropdown no Mobile -->
                <div class="dropdown d-lg-none">
                    <a href="#" class="d-flex align-items-center text-decoration-none" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="vendor/img/menu_icon.png" alt="Menu" width="36" height="36">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuDropdown">
                        <li><a class="dropdown-item text-black" href="painel">Painel</a></li>
                        <li><a class="dropdown-item text-black" href="sobre">Sobre</a></li>
                        <li><a class="dropdown-item text-black" href="entregaveis">Entregáveis</a></li>
                        <li><a class="dropdown-item text-black" href="ferramentas">Ferramentas</a></li>
                        <li><a class="dropdown-item text-black" href="servicos">Serviços</a></li>
                    </ul>
                </div>

                <!-- Perfil do Usuário -->
                <div class="dropdown">
                    <a href="#" id="profileDropdown" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="vendor/images/post-thumb-1.jpg" alt="User Profile" class="rounded-circle" width="40" height="40">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item text-black" href="painel">Início</a></li>
                        <li><a class="dropdown-item text-black" href="minha-conta">Conta</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-black" href="#" id="themeToggle">Tema: <span id="themeLabel">Light</span></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-black" href="logout">Logout</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </nav>
</header>
