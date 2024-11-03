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
    <?php include "../../componentes/headers.php"; ?>
</head>

<body>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

    // Define consulta SQL com base na pesquisa
    $pesquisar = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';


    $limit = 10;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "") . " ORDER BY cod_insumo ASC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));

    // Get total number of items for pagination
    $total_sql = "SELECT COUNT(*) as total FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "");
    $total_result = mysqli_query($connection, $total_sql);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_items = $total_row['total'];
    $total_pages = ceil($total_items / $limit);

    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    include_once('modals/adicionar.php');
    include_once('modals/retirar.php');
    include_once('modals/editar.php');
    ?>

    <div class="container my-4">
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

        <!-- Tabela de insumos estilizada -->
        <table class="table table-hover table-custom text-center">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Peso/Unidade</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Entrada</th>
                    <th scope="col">Saída</th>
                    <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><a href="../visualizar/visualizar.php?cod_insumo=<?php echo $row['cod_insumo']; ?>">
                                    <?php echo htmlspecialchars($row['produto']); ?>
                                </a></td>
                            <td><?php echo htmlspecialchars($row['peso'] . ' ' . $row['unidade']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
                            <td>
                                <a href="javascript:void(0)" class="open-modal-adicionar"
                                    data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                    <i class="fa-regular fa-square-plus" style="color: green; font-size:20px;"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="open-modal-retirar"
                                    data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                    <i class="fa-regular fa-square-minus" style="color: red; font-size:20px;"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="open-modal-editar"
                                    data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                    <i class="fa-regular fa-pen-to-square" style="font-size:20px;"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum insumo encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?pesquisar=<?php echo urlencode($pesquisar); ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/gerenciar.js"></script>
    <script src="../../js/abrir-modal-editar.js"></script>
    <script src="../../js/pesquisa_gerenciar.js"></script>

</body>

</html>