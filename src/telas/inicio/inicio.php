<?php

session_start();
if (!isset($_SESSION['loggedIn'])) {
    header('Location: ./telas/login/index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .card-custom {
            width: 260px;
            margin: 10px;
        }
    </style>

</head>

<body>

<?php
include_once('../../componentes/header.php');
include_once('../../componentes/navbar.php');
?>


    <div class="container">
        <div class="row justify-content-center cards-row" style="padding-top:25px;">
            <div class="card card-custom card-estoque">
                <img class="card-img-top" src="../../assets/imagens/estoque.png" alt="Gerenciar Estoque">
                <div class="card-body">
                    <h5 class="card-title">Gerenciar Estoque</h5>
                    <a href="../estoque/estoque.php" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>

            <div class="card card-custom card-insumo">
                <img class="card-img-top" src="../../assets/imagens/cadastro.png" alt="Cadastrar Insumo">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Insumo</h5>
                    <a href="../cadastro/cadastro.php" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>

            <div class="card card-custom card-relatorios">
                <img class="card-img-top" src="../../assets/imagens/relatorio.png" alt="Relatórios">
                <div class="card-body">
                    <h5 class="card-title">Relatórios</h5>
                    <a href="../relatorio/relatorios.php" class="btn btn-primary">Abrir</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>