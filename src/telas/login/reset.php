<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Verifica se o token foi passado pela URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $hashedToken = hash('sha256', $token); // Garante que o token seja passado de forma consistente

    // Consulta para verificar se o token existe no banco de dados
    $query = "SELECT * FROM esqueceu_senha WHERE token = '$hashedToken'";
    $r = mysqli_query($connection, $query);

    // Verifica se o token é válido
    if (mysqli_num_rows($r) > 0) {
        // Token válido
        if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];

            // Verifica se as senhas coincidem
            if ($password === $confirmPassword) {
                // Se a senha não estiver vazia
                if (!empty($password)) {
                    // Criptografa a senha
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    // Atualiza a senha no banco de dados
                    $update_query = "UPDATE funcionario SET senha = '$hashedPassword' WHERE email = (SELECT email FROM esqueceu_senha WHERE token = '$hashedToken')";
                    $res = mysqli_query($connection, $update_query);

                    if ($res) {
                        echo "<script>alert('Senha atualizada com sucesso!'); window.location.href='index.php';</script>";
                    } else {
                        echo "<script>alert('Erro ao atualizar a senha. Tente novamente.');</script>";
                    }
                } else {
                    echo "<script>alert('A senha não pode estar vazia.');</script>";
                }
            } else {
                echo "<script>alert('As senhas não coincidem. Tente novamente.');</script>";
            }
        }
    } else {
        // Caso o token seja inválido
        echo "<script>alert('Token inválido.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/reset.css">
    <title>Redefinir Senha</title>
</head>
<body>

<div class="login-box">
    <center>
    <img src="../../assets/imagens/logoSM.png" alt="Logotipo"
    style="width: 150px; height: 50px;">
    </center>

    <form method="POST" id="reset-password-form">
        <h4 style="text-align: center;">Redefinir Senha</h4>
        <p>Agora, por favor, insira a nova senha que você gostaria de usar para a sua conta.</p>

        <div class="user-box">
            <input type="password" name="password" id="password" required>
            <label for="password">Nova Senha</label>
        </div>

        <div class="user-box">
            <input type="password" name="confirmPassword" id="confirmPassword" required>
            <label for="confirmPassword">Confirmar Senha</label>
        </div>

        <center>
            <input type="button" value="Atualizar Senha" id="update-password-button" onclick="submitForm()">
        </center>
    </form>
</div>

<script>
// Função para enviar o formulário e exibir alertas
function submitForm() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Verifica se as senhas coincidem
    if (password === confirmPassword) {
        if (password !== "") {
            // Submete o formulário
            document.getElementById('reset-password-form').submit();
        } else {
            alert('A senha não pode estar vazia.');
        }
    } else {
        alert('As senhas não coincidem. Tente novamente.');
    }
}
</script>

</body>
</html>
