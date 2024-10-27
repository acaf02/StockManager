<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../styles/gerenciar.css">
    <title>Dashboard</title>
    <?php include "../../componentes/headers.php";

    ?>
</head>

<body>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

    // Define consulta SQL com base na pesquisa
    $pesquisar = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';
    $sql = "SELECT * FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "") . " ORDER BY cod_insumo ASC";
    $result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));

    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    include_once('modals/adicionar.php');
    include_once('modals/retirar.php');
    include_once('modals/editar.php');
    ?>

    <div class="container" style="padding:20px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../estoque/estoque.php" class="btn btn-dark">Visualizar</a>
            <a href="../cadastro/cadastro.php" class="btn btn-dark mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>
            <div class="position-relative" style="width: 300px;">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar" id="pesquisar"
                       value="<?php echo htmlspecialchars($pesquisar); ?>" style="padding-left: 35px;">
                <i class="fa-sharp fa-solid fa-magnifying-glass position-absolute"
                   style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
            </div>
            <i class="fa fa-sliders mx-2" style="font-size:30px; padding:6px;"></i>
        </div>

        <!-- Tabela de insumos -->
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

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><a href="../visualizar/visualizar.php?cod_insumo=<?php echo $row['cod_insumo']; ?>"
                                    class="text-decoration" style="color: black;">
                                    <?php echo htmlspecialchars($row['produto']); ?>
                                </a></td>
                            <td><?php echo htmlspecialchars($row['peso'] . ' ' . $row['unidade']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
                            <td>
                                <!-- Botão para abrir o modal de adicionar insumos -->
                                <a href="javascript:void(0)" class="open-modal-adicionar"
                                    data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                    <i class="fa-regular fa-square-plus" style="color: green; font-size:20px;"></i>
                                </a>
                            </td>
                            <td>
                                <!-- Botão para abrir o modal de retirar insumos -->
                                <a href="javascript:void(0)" class="open-modal-retirar"
                                    data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                    <i class="fa-regular fa-square-minus" style="color: red; font-size:20px;"></i>
                                </a>
                            </td>
                            

                        </tr>


                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum insumo encontrado</td></tr>";
                }


                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/gerenciar.js"></script>
    <script src="../../js/abrir-modal-editar.js"></script>
    <script src="../../js/pesquisa_gerenciar.js"></script>


</body>

</html>