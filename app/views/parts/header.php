<header id="top" class="position-sticky top-0 start-0" style="z-index: 999;">
    <nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Logo e Texto "Membros" -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="painel">
                    <img src="vendor/img/logo_escuro.png" class="img-fluid" style="height: 26px;" id="logo" alt="Logo">
                </a>
                <span class="ms-0  text-dark">Membros</span>
            </div>

            <!-- Ícones de Redes Sociais -->
            <div class="d-none d-lg-flex align-items-center gap-3">
                <a href="#" class="text-decoration-none">
                    <svg class="skype" width="24" height="24">
                        <use xlink:href="#skype"></use>
                    </svg>
                </a>
                <!-- Adicione mais ícones aqui -->
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Botão de Alternância de Tema -->
                <a href="painel" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i>
                </a>
                <button id="themeToggle" class="btn btn-outline-secondary">
                    <i class="fas fa-sun"></i>
                </button>

                <!-- Foto de Perfil com Dropdown -->
                <div class="dropdown">
                    <a href="#" id="profileDropdown" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="vendor/images/post-thumb-1.jpg" alt="User Profile" class="rounded-circle" width="40" height="40">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item text-black" href="painel">Início</a></li>
                        <li><a class="dropdown-item text-black" href="minha-conta">Conta</a></li>
                        <!-- <li><a class="dropdown-item" href="minha-assinatura">Assinatura</a></li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-black" href="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
