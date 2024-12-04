<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
$pasta = dirname(__DIR__, 3); // Caminho até o diretório da raiz do projeto
$dotenv = Dotenv\Dotenv::createImmutable($pasta); // Não precisa passar o nome do arquivo se for .env
$dotenv->load();
function enviarEmail($para, $assunto, $mensagemHTML, $mensagemTexto = '', $de = 'noreply@fepacoc.com.br', $nomeDe = 'Fepacoc Members') {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST'); // Servidor SMTP
        $mail->Username   = getenv('SMTP_USER'); // Usuário SMTP
        $mail->Password   = getenv('SMTP_PASSWORD'); // Senha SMTP
        $mail->Port       = (int)getenv('SMTP_PORT'); // Porta SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Tipo de Criptografia
        $mail->SMTPAuth   = true; // Ativar autenticação SMTP

        // Definir o remetente
        $mail->setFrom($de, $nomeDe);

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
        error_log("Erro ao enviar email: {$mail->ErrorInfo}", 3, __DIR__ . '/logs/email_errors.log');
        return "Erro ao enviar email: {$mail->ErrorInfo}";
    }
}

function enviarLinkCadastroSenha($destinatario, $nome, $senhaCadastrada) {
    // Assunto do email
    $assunto = "Área de Membros - Fepacoc!";

    // Corpo do email
    $mensagemHTML = "
        <h1>Olá $nome, que felicidade ter você aqui!</h1>
        <p>Estamos entusiasmados em lhe ajudar com o crescimento da sua empresa! Na sua Área de Membros, você se aprofunda em uma variedade de vídeos, serviços e recursos valiosos para ajudar ativamente na gestão da sua empresa.</p>
        <hr><p>Sua senha de acesso é: <strong>$senhaCadastrada</strong></p><hr>
        <i>Para acessar a Área de Membros, informe o email cadastrado e a senha destacada acima.</i>
        <p><a href='https://members.fepacoc.com.br/login' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;'>Acessar Área de Membros</a></p>
        <p>Agradecemos seu cadastro e acreditamos que o método Fepacoc pode transformar positivamente sua empresa. Se precisar de qualquer assistência, não hesite em entrar em contato conosco pelo email: <a href='mailto:suporte@fepacoc.com.br'>suporte@fepacoc.com.br</a>.</p>
        <p>Atenciosamente, <br> Equipe Fepacoc</p>";

    // Envia o email utilizando a função de envio
    return enviarEmail($destinatario, $assunto, $mensagemHTML);
}
