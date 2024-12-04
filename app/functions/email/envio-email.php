<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
$pasta = dirname(__DIR__, 3); // Caminho até o diretório da raiz do projeto
$dotenv = Dotenv\Dotenv::createImmutable($pasta); // Não precisa passar o nome do arquivo se for .env
$dotenv->load();
function enviarEmail($para, $assunto, $mensagemHTML, $mensagemTexto = '', $de = 'vempublicar@gmail.com', $nomeDe = 'Fepacoc Members') {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = 'vempublicar@gmail.com'; 
        $mail->Password   = 'bowd vlxs evku gzub';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
       $mail->SMTPAuth   = true;
        
        // Debugging SMTP - útil para depuração (0 = off, 1 = cliente, 2 = cliente e servidor)
        $mail->SMTPDebug  = (int)getenv('SMTP_DEBUG');          // Variável de ambiente para definir o nível de depuração

        // Definir o remetente
        $mail->setFrom($de, $nomeDe);

        // Verifica se o remetente e o destinatário são diferentes
        if ($de === $para) {
            throw new Exception('O remetente e o destinatário não devem ser iguais.');
        }

        // Definir o destinatário
        $mail->addAddress($para);

        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagemHTML;

        // Define uma versão em texto simples (caso o cliente de email não suporte HTML)
        if (empty($mensagemTexto)) {
            $mensagemTexto = strip_tags($mensagemHTML);
        }
        $mail->AltBody = $mensagemTexto;

        // Envia o email
        $mail->send();
        return true; // Email enviado com sucesso
    } catch (Exception $e) {
        // Registra erro em um log para depuração
        // error_log("Erro ao enviar email: {$mail->ErrorInfo}", 3, __DIR__ . '/logs/email_errors.log');
        return "Erro ao enviar email: {$mail->ErrorInfo}";
    }
}

function enviarLinkCadastroSenha($destinatario, $nome, $senhaCadastrada) {
    // Assunto do email
    $assunto = "Cadastrado com sucesso! Fepacoc Membros";

    // Corpo do email
    $mensagemHTML = "
        <h2>Olá $nome, que bom ver você aqui!</h2>
        <p>Estamos entusiasmados em lhe ajudar com o crescimento da sua empresa!<br> Na Área de Membros do Fepacoc, você se aprofunda em uma variedade de vídeos, serviços e recursos valiosos para ajudar ativamente na sua gestão.</p>
        
        <i>Para acessar a Área de Membros, informe o email cadastrado e a senha destacada abaixo.</i>
        <hr><p>Sua senha de acesso é: <strong>$senhaCadastrada</strong></p><hr>
        
        <p><a href='https://members.fepacoc.com.br/login' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;'>Acessar Área de Membros</a></p>
        <p>Acreditamos que o método Fepacoc pode transformar positivamente sua empresa. <br> Obrigado pelo seu cadastro e precisar de qualquer assistência, não hesite em entrar em contato conosco pelo email: <a href='mailto:suporte@fepacoc.com.br'>suporte@fepacoc.com.br</a>.</p>
        <p>Atenciosamente, <br> Equipe Fepacoc</p>";

    // Envia o email utilizando a função de envio
    return enviarEmail($destinatario, $assunto, $mensagemHTML);
}
function enviarEmailGenerico($destinatario, $nome, $titulo, $texto) {
    // Assunto do email
    $assunto = $titulo;

    // Corpo do email
    $mensagemHTML = "
        <h2>Olá $nome</h2>
        <p>$texto</p>
        <p>Entrar em contato conosco pelo email: <a href='mailto:suporte@fepacoc.com.br'>suporte@fepacoc.com.br</a>.</p>
        <p>Atenciosamente, <br> Equipe Fepacoc</p>";

    // Envia o email utilizando a função de envio
    return enviarEmail($destinatario, $assunto, $mensagemHTML);
}

// $retorno = enviarLinkCadastroSenha('luishenrique.pian@gmail.com', 'Luis', '123456');

// echo $retorno;