<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/estoque.css">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <?php
    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    include_once('../../componentes/paginacao_pesquisa.php');
    include_once('../../componentes/filtro.php');
    ?>

    <div class="container my-4">
        <?php
        // Exibe mensagem de alerta, se houver
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($_GET['msg']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        ?>

        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../gerenciar/gerenciar.php" class="btn gerenciar">Gerenciar</a>
            <a href="../cadastro/cadastro.php" class="btn cadastrar mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>

            <div class="position-relative" style="width: 300px;">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar" id="pesquisar"
                    value="<?php echo htmlspecialchars($pesquisar); ?>" style="padding-left: 35px;">
                <i class="fa-sharp fa-solid fa-magnifying-glass position-absolute"
                    style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
            </div>

            <i class="fa fa-sliders filter-icon mx-2"
                style="font-size:30px; padding:6px; position: relative; display: inline-block;"
                onclick="abrirFilterPanel()" id="filterIcon"></i>

        </div>

        <table id="inventario" class="table table-hover text-center table-custom">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Peso/Unidade</th>
                    <th scope="col">Quantidade</th>
                </tr>
            </thead>
            <tbody>
    <?php
    // Exibe os dados em uma tabela
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Carrega a quantidade mínima do banco de dados
            $cod_insumo = $row['cod_insumo'];
            $query_min_quantity = "SELECT estoque_min FROM insumo WHERE cod_insumo = '$cod_insumo'";
            $result_min = mysqli_query($connection, $query_min_quantity);
            $min_quantity = $result_min ? mysqli_fetch_assoc($result_min)['estoque_min'] : 0;
            ?>
            <tr data-min-quantity="<?php echo htmlspecialchars($min_quantity); ?>">
                <td><a href="../visualizar/visualizar.php?cod_insumo=<?php echo $row['cod_insumo']; ?>">
                        <?php echo htmlspecialchars($row['produto']); ?>
                    </a></td>
                <td><?php echo htmlspecialchars($row['peso'] . ' ' . $row['unidade']); ?></td>
                <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='3'>Nenhum insumo encontrado</td></tr>";
    }
    ?>
</tbody>

        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">

                <!-- Botão de Anterior -->
                <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link"
                        href="?pesquisar=<?php echo urlencode($pesquisar); ?>&page=<?php echo $page - 1; ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Números das páginas -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?pesquisar=<?php echo urlencode($pesquisar); ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Botão de Próximo -->
                <li class="page-item <?= $page == $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link"
                        href="?pesquisar=<?php echo urlencode($pesquisar); ?>&page=<?php echo $page + 1; ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>

            </ul>
        </nav>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="../../js/pesquisa_estoque.js"></script>


</body>

</html>