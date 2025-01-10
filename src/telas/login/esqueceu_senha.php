<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Variáveis de controle para exibir a mensagem de sucesso ou erro
$mensagem = '';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verifica se o e-mail não está vazio
    if (empty($email)) {
        $mensagem = "O campo de e-mail está vazio.";
    } else {
        // Consulta para verificar se o e-mail existe no banco de dados
        $query = "SELECT * FROM funcionario WHERE email = '$email'";
        $r = mysqli_query($connection, $query);

        if (mysqli_num_rows($r) > 0) {
            // Gera um token seguro para a redefinição de senha
            $token = bin2hex(random_bytes(32)); // Gera um token de 64 caracteres

            // Insere o token no banco de dados
            $insert_query = "INSERT INTO esqueceu_senha (email, token) VALUES ('$email', '" . hash('sha256', $token) . "')";
            $res = mysqli_query($connection, $insert_query);

            if ($res) {
                // Criando instância do PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configuração do servidor SMTP
                    $mail->isSMTP();  // Define que estamos usando SMTP
                    $mail->Host = 'smtp.gmail.com';  // Usando o servidor SMTP do Gmail
                    $mail->SMTPAuth = true;  // Ativa autenticação SMTP
                    $mail->Username = 'anacarol.farias11@gmail.com';  // Seu e-mail do Gmail
                    $mail->Password = 'gynaefjniclkgnly';  // Senha do e-mail (ou senha de aplicativo)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usando SSL
                    $mail->Port = 465; // Porta SSL 

                    // Remetente
                    $mail->setFrom('no-reply@stockmanager.com', 'Redefinição de Senha');
                    $mail->addAddress($email);  // E-mail do destinatário
                    $mail->addReplyTo('no-reply@stockmanager.com', 'Redefinição de Senha');
                    $mail->Subject = 'Redefinir Senha';

                    // Conteúdo do e-mail
                    $mail->isHTML(true);

                    // Corpo do e-mail
                    $mail->Body = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .content {
        padding: 20px;
    }
    .content p {
        font-size: 16px;
        line-height: 1.6;
    }
    .button {
        display: inline-block;
        padding: 15px 30px;
        background-color: black;
        color: white !important;
        text-decoration: none; 
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
        transition: background-color 0.3s ease, color 0.3s ease; 
    }
    .button:hover {
        background-color: #1aa153;
        color: white;
    }
    .footer {
        background-color: #f4f4f9;
        text-align: center;
        padding: 10px;
        font-size: 14px;
        }
</style>
</head>
<body>
    <div class='container'>
        <!-- Conteúdo do E-mail -->
        <div class='content'>
            <p>Olá,</p>
            <p>Recebemos uma solicitação para redefinir sua senha. Para continuar, clique no botão abaixo:</p>
            <center>
            <p><a href='http://localhost:84/SM/src/telas/login/reset.php?token=$token' class='button' style='text-decoration: none;'>Redefinir Senha</a></p>
            </center>
            <p>Se você não fez essa solicitação, pode ignorar este e-mail.</p>
        </div>
        
        <!-- Rodapé -->
        <div class='footer'>
            <p>Se você tiver algum problema, entre em contato conosco.</p>
        </div>
    </div>
</body>
</html>
";

                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => true,
                            'verify_peer_name' => true,
                            'allow_self_signed' => false,
                            'cafile' => 'C:/xampp/apache/bin/cacert.pem',
                        ]
                    ];

                    // Envia o e-mail
                    $mail->send();
                    $mensagem = 'Link de redefinição de senha enviado para seu e-mail.';
                } catch (Exception $e) {
                    $mensagem = "Erro ao enviar o e-mail. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $mensagem = "Erro ao gerar o token. Tente novamente.";
            }
        } else {
            $mensagem = "Usuário não encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../../styles/reset.css">
    <script>
        // Função para mostrar o alerta com a mensagem do PHP
        window.onload = function () {
            var mensagem = '<?php echo $mensagem; ?>';
            if (mensagem) {
                alert(mensagem);
            }
        }

        // Função para enviar o formulário quando o botão for clicado
        function enviarFormulario() {
            document.getElementById('esqueceuSenha').submit(); // Envia o formulário
        }
    </script>
</head>

<body>
    <div class="login-box">
        <center>
            <div class="logo">
                <a href="index.php">
                    <img src="../../assets/imagens/logoSM.png" alt="Logo" style="width: 150px; height: 50px;">
                </a>
            </div>
        </center>
        <form id="esqueceuSenha" method="POST">
            <h4 style="padding-bottom: 10px; text-align: center; ">Redefinir Senha</h4>
            <p style="padding-bottom: 20px; justify-content: space-between;"> Insira o e-mail associado à sua conta para
                redefinir sua senha. Você
                receberá um link para criar uma nova senha.</p>

            <div class="user-box">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>

            <center>
                <input type="button" value="Solicitar" id="esquecer-senha" onclick="enviarFormulario()">
            </center>
        </form>
    </div>
</body>

</html>