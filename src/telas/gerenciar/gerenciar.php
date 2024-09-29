<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gerenciar.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   

</head>

<body>

<?php
include_once('../../componentes/header.php');
include_once('../../componentes/navbar.php');
?>

<div class="container" style="padding:20px;">
        <?php
        // Verifica se há uma mensagem para exibir
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ' . $msg . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        ?>
       
       <div class="container">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../estoque/estoque.php" class="btn btn-dark" style="padding: 10px;">Visualizar</a>
            <a href="../cadastro/cadastro.php" class="btn btn-dark mx-2" style="padding: 10px;">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>
            <div class="search-container" style="padding: 5px;">
                <input type="text" placeholder="Pesquisar..." class="form-control search-input">
            </div>
            <button class="btn btn-dark search-button" ">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            <i class="fa fa-sliders mx-2" style="font-size:30px; padding:6px;"></i>
        </div>
    </div>
        <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Peso/Unidade</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Entrada</th>
                    <th scope="col">Saída</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                include "../../db/db_connection.php";

                // Query para selecionar todos os registros
                $sql = "SELECT * FROM `insumo`";
                $result = mysqli_query($connection, $sql);

                // Loop para exibir os dados em uma tabela
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['produto'] ?></td>
                        <td><?php echo $row['peso'] . '' . $row['unidade']; ?></td>
                        <td><?php echo $row['quantidade'] ?></td>
                        <td><a><i class="fa-regular fa-square-plus" style="color: green; font-size:20px; padding-top: 4px;"></i></a></td>
                        <td><a><i class="fa-regular fa-square-minus" style="color: red; font-size:20px; padding-top: 4px;"></i></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
  
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>