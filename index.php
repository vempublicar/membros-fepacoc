<?php
$page = $_GET['pg'] ?? '';

switch ($page) {
    
    case 'webhook':
        require 'app/views/public/webhook.php';
        break;

        
    case 'log-webhook':
        require 'app/views/public/log-webhook.php';
        break;

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

    case 'adm-painel':
        include_once 'app/views/adm/painel-adm.php';
        break;

    case 'minha-conta':
        require 'app/views/private/minha-conta.php';
        break;

    case 'minha-assinatura':
        require 'app/views/private/minha-assinatura.php';
        break;

        case 'area-exclusiva':
            require 'app/views/private/area-exclusiva.php';
            break;

            case 'produtos':
                require 'app/views/private/produtos.php';
                break;

                case 'material':
                    require 'app/views/private/materiais.php';
                    break;
                    
                case 'aulas':
                    require 'app/views/private/aulas.php';
                    break;
                    case 'doc':
                        require 'app/views/private/docs.php';
                        break;

    case 'sobre':
        require 'app/views/private/sobre.php';
        break;

    case 'entregaveis':
        require 'app/views/private/entregaveis.php';
        break;

        case 'ferramentas':
            require 'app/views/private/ferramentas.php';
            break;

    case 'planos':
        require 'app/views/private/planos.php';
        break;

    case 'login':
        require 'app/views/public/login.php';
        break;

    case 'esqueci-senha':
        require 'app/views/public/esqueci-senha.php';
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

?>