<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href="gerenciar.css">
    <?php include "../../componentes/headers.php";

    ?>
</head>

<body>

    <?php
    include "../../db/db_connection.php";

    // Verifica se há pesquisa e cria a consulta apropriada
    if (!empty($_GET['pesquisar'])) {
        $data = $_GET['pesquisar'];
        $data = mysqli_real_escape_string($connection, $data);
        $sql = "SELECT * FROM insumo WHERE produto LIKE '%$data%' ORDER BY cod_insumo ASC";
    } else {
        $sql = "SELECT * FROM insumo ORDER BY cod_insumo ASC";
    }

    // Executar a consulta
    $result = mysqli_query($connection, $sql);

    // Verifica se a consulta foi bem-sucedida
    if (!$result) {
        die("Erro na consulta: " . mysqli_error($connection));
    }

    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    include_once('modals/adicionar.php');
    include_once('modals/retirar.php');
   
    ?>

    <div class="container" style="padding:20px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../estoque/estoque.php" class="btn btn-dark">Visualizar</a>
            <a href="../cadastro/cadastro.php" class="btn btn-dark mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>

            <!-- Formulário para pesquisa com método GET -->
            <form method="GET" action="gerenciar.php" class="d-flex align-items-center">
                <input type="search" name="pesquisar" class="form-control" placeholder="Pesquisar" id="pesquisar"
                    value="<?php echo isset($_GET['pesquisar']) ? htmlspecialchars($_GET['pesquisar']) : ''; ?>">
                <button type="submit" class="btn btn-dark" style="height: 38px;">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
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
                            <td><?php echo htmlspecialchars($row['produto']); ?></td>
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
    <script src="gerenciar.js"></script>

    <script>
        // Evento para capturar a pesquisa via Enter
        var pesquisa = document.getElementById('pesquisar');
        pesquisa.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                pesquisa.form.submit();
            }
        });


    </script>

</body>

</html>