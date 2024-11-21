<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Conectar ao banco de dados
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
        $query = "SELECT * FROM login WHERE email = '$email'";
        $r = mysqli_query($connection, $query);

        if (mysqli_num_rows($r) > 0) {
            // Gera um token seguro para a redefinição de senha
            $token = bin2hex(random_bytes(32)); // Gera um token de 64 caracteres

            // Define o tempo de expiração para 1 hora
            $expirationTime = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Insere o token no banco de dados com a data de expiração
            $insert_query = "INSERT INTO esqueceu_senha (email, token, expiration) VALUES ('$email', '" . hash('sha256', $token) . "', '$expirationTime')";
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
                    $mail->Password = 'rhqzbmwssomcctnf';  // Senha do e-mail (caso esteja usando autenticação em 2 etapas, use uma senha de aplicativo)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usando SSL
                    $mail->Port = 465; // Porta SSL (geralmente 465 para SSL)

                    // Configurações SSL adicionais
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => true,
                            'verify_peer_name' => true,
                            'allow_self_signed' => false,
                            'cafile' => 'C:/xampp/apache/bin/cacert.pem', // Caminho correto do cacert.pem
                        ]
                    ];

                    // Remetente
                    $mail->setFrom('no-reply@seusite.com', 'Redefinição de Senha');
                    $mail->addAddress($email);  // E-mail do destinatário
                    $mail->addReplyTo('no-reply@seusite.com', 'Redefinição de Senha');

                    // Conteúdo do e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Redefinir Senha';
                    $mail->Body    = "Clique no link abaixo para redefinir sua senha:<br><a href='http://localhost/seusite/reset.php?token=$token'>Redefinir Senha</a>";

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
    window.onload = function() {
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
            <img src="../../assets/imagens/logoSM.png" alt="Logotipo"
                style="width: 150px; height: 50px;">
        </center>
        <form id="esqueceuSenha" method="POST">
            <h4 style="padding-bottom: 10px; text-align: center; ">Redefinir Senha</h4>
            <p style="padding-bottom: 20px; justify-content: space-between;"> Insira o e-mail associado à sua conta para redefinir sua senha. Você
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
