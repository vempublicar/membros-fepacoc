<?php
$page = $_GET['pg'] ?? '';

switch ($page) {
    case 'register':
        require 'app/views/public/register.php';
        break;

    case 'painel':
        require 'app/views/private/area-membros.php';
        break;

    case 'videos':
        require 'app/views/private/videos.php';
        break;

    case 'verificar-email':
        require 'app/views/public/verifica-email.php';
        break;

    case 'email':
        include_once 'app/functions/email/envio-email.php';
        break;

    case 'setup':
        require 'database/setup.php';
        break;

    case 'login':
        require 'app/views/public/login.php';
        break;

        case 'logout':
            require 'app/views/logout.php';
            break;

        case 'dashboard':
            require 'app/views/private/dashboard.php';
            break;

    default:
        // Carrega uma página de campanha aleatória
        require 'app/views/public/login.php';
        break;
}
