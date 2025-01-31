<?php
session_start();

// Verifica se o usuário está autenticado
if (isset($_SESSION['loggedIn'])) {
    header('Location: ../inicio/inicio.php');
    exit();
}

// Verifica se o formulário de login foi enviado
if (isset($_POST['login'])) {

    include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

    // Checa a conexão com banco de dados
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $username = $connection->real_escape_string($_POST['username']);
    $senha = $_POST['password']; // Obtém a senha

    // Consulta SQL para selecionar o usuário
    $query = "SELECT senha FROM funcionario WHERE login_funcionario = ?";
    $stmt = $connection->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }

    //executa a consulta
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    //obtém os dados do usuario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['senha'];

        //Login
        if (password_verify($senha, $hashed_password)) {
            $_SESSION['loggedIn'] = '1';
            $_SESSION['username'] = $username;
            exit('success');
        } else {
            exit('Senha incorreta!');
        }
    } else {
        exit('Usuário não encontrado!');
    }

    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/index.css">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="login-box">
        <center>
            <img src="../../assets/imagens/logoSM.png" alt="Logotipo"
                style="width: 150px; height: 80px; padding-bottom:30px;">
        </center>
        <form id="loginForm">
            <div class="user-box">
                <input type="text" id="username" name="username" required>
                <label for="username">Login:</label>
            </div>
            <div class="user-box">
                <input type="password" id="password" name="password" required>
                <div id="icones" onclick="showHide()">
                    <img src="../../assets/imagens/show.png" alt="Mostrar Senha" style="width: 20px; height: 20px;">
                </div>
                <label for="password">Senha:</label>
            </div>
            <center>
                <div style="padding-bottom:20px;">
                <a href="esqueceu_senha.php" style="text-decoration:none; color:black;">Esqueceu a senha?</a>
                </div>
                <input type="button" value="Entrar" id="login">
            </center>
        </form>
    </div>



    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../../js/index.js"></script>
</body>

</html>