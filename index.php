<?php
$page = $_GET['pg'] ?? '';

switch ($page) {
    case 'register':
        require 'app/views/register.php';
        break;

    case 'submit_registration':
        require 'app/submit_registration.php';
        break;

    case 'thank_you':
        require 'app/views/thank_you.php';
        break;

    case 'cadastro':
        require 'app/views/cadastro.php';
        break;

    case 'cp_a':
        include_once 'app/views/pages/cp_a.php';
        break;

    case 'setup':
        require 'database/setup.php';
        break;

    case 'login':
        require 'app/views/login.php';
        break;

        case 'logout':
            require 'app/views/logout.php';
            break;

        case 'dashboard':
            require 'app/views/private/dashboard.php';
            break;

    default:
        // Carrega uma página de campanha aleatória
        require 'app/views/login.php';
        break;
}
