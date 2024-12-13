<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../styles/gerenciar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Dashboard</title>

</head>

<body>

    <?php

    include_once('../../componentes/header.php');
    include_once('../../componentes/paginacao_pesquisa.php');
    include_once('modals/adicionar.php');
    include_once('modals/retirar.php');
    include_once('modals/editar.php');
    ?>

    <div class="container my-4" style="padding-top:65px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../estoque/estoque.php" class="btn visualizar">Visualizar</a>
            <a href="../cadastro/cadastro.php" class="btn cadastrar mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>
            <div class="position-relative" style="width: 300px;">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar" id="pesquisar"
                    value="<?php echo htmlspecialchars($pesquisar); ?>" style="padding-left: 35px;">
                <i class="fa-sharp fa-solid fa-magnifying-glass position-absolute"
                    style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
            </div>
            <?php include('../../componentes/filtro.php'); ?>
        </div>

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
                        // Carrega a quantidade mínima e média do banco de dados
                        $cod_insumo = $row['cod_insumo'];
                        $query_min_med_quantity = "SELECT estoque_min, estoque_medio FROM insumo WHERE cod_insumo = '$cod_insumo'";
                        $result_min = mysqli_query($connection, $query_min_med_quantity);
                        $min_med_quantity = $result_min ? mysqli_fetch_assoc($result_min) : ['estoque_min' => 0, 'estoque_medio' => 0];
                        $min_quantity = $min_med_quantity['estoque_min'];
                        $med_quantity = $min_med_quantity['estoque_medio'];
                        ?>
                        <tr>
                            <td><a href="../visualizar/visualizar.php?cod_insumo=<?php echo $row['cod_insumo']; ?>">
                                    <?php echo htmlspecialchars($row['produto']); ?>
                                </a></td>
                            <td><?php echo htmlspecialchars($row['peso'] . ' ' . $row['unidade']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($row['quantidade']); ?>
                                <?php
                                // Adiciona ícone se a quantidade for menor ou igual à mínima, se não adiciona o icone se a quantidade for manor ou igual a média
                                if ($row['quantidade'] <= $min_quantity) {
                                    echo ' <i class="fa fa-exclamation-triangle" style="color: red; font-size:20px;"></i>';
                                } else if ($row['quantidade'] <= $med_quantity) {
                                    echo ' <i class="fa fa-exclamation-triangle" style="color: orange; font-size:20px;"></i>';
                                }
                                ?>
                            </td>
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

        <nav aria-label="Page navigation">
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

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/gerenciar.js"></script>
    <script src="../../js/abrir-modal-editar.js"></script>
    <script src="../../js/pesquisa_gerenciar.js"></script>

</body>

</html>