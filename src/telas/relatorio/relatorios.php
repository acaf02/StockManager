<?php

session_start();
if (!isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="relatorio.css">
    <title>Relatórios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .card-custom {
            width: 300px;
            margin: 0 20px 20px 20px;
        }
    </style>

</head>

<body>

    <?php
    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    ?>

    <h1 class="title">Relatórios</h1>

    <!-- Cards de relatorios disponiveis-->
    <div class="container">
        <div class="row justify-content-center cards-row" style="padding-top:25px;">
            <div class="card card-custom card-inventario">
                <div class="card-body">
                    <img class="card-img-top" src="../../assets/imagens/relatorio.png" alt="Relatórios">
                    <h5 class="card-title">Inventário de Estoque</h5>
                    <p class="card-text">Este relatório mostra todos os produtos disponíveis no estoque.</p>
                    <a href="usuario/usuarios.php" class="btn btn-primary">Abrir</a>
                    <a href="usuario/usuarios.php" class="btn btn-primary">Baixar</a>
                </div>
            </div>

            <div class="card card-custom card-estatisticas">
                <div class="card-body">
                    <img class="card-img-top" src="../../assets/imagens/relatorio.png" alt="Relatórios">
                    <h5 class="card-title">Estatísticas</h5>
                    <p class="card-text">Este relatório mostra quais são os itens mais e menos consumidos.</p>
                    <a href="livros/livros.php" class="btn btn-primary">Abrir</a>
                    <a href="usuario/usuarios.php" class="btn btn-primary">Baixar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>