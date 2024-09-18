<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclua os arquivos do PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.server.com'; // Servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'email@email.com'; // Seu email Hotmail
    $mail->Password   = 'senha'; // Sua senha Hotmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinatários
    $mail->setFrom('email@email.com', 'Sistema RUNAS - IFPR');
    $mail->addAddress('email@email.com', 'Nome do Usuário');

    // Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = 'Assunto do Email';
    $mail->Body    = 'Esta é a mensagem <b>HTML</b> do email.';
    $mail->AltBody = 'Esta é a mensagem em texto puro.';

    // Envia o email
    $mail->send();
    echo 'Email enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar email: {$mail->ErrorInfo}";
}
?>
