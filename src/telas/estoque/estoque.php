<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Define consulta SQL com base na pesquisa
$pesquisa = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';

$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = $page < 1 ? 1 : $page;
$offset = ($page - 1) * $limit;

// Consulta para obter os dados com limite e deslocamento
$sql = "SELECT * FROM insumo " . ($pesquisa ? "WHERE produto LIKE '%$pesquisa%'" : "") . " ORDER BY cod_insumo ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));

// Get total number of items for pagination
$total_sql = "SELECT COUNT(*) as total FROM insumo " . ($pesquisa ? "WHERE produto LIKE '%$pesquisa%'" : "");
$total_result = mysqli_query($connection, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $limit);
?>

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
            <a href="../gerenciar/gerenciar.php" class="btn btn-dark">Gerenciar</a>
            <a href="../cadastro/cadastro.php" class="btn btn-dark mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>

            <div class="position-relative" style="width: 300px;">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar" id="pesquisar"
                    value="<?php echo htmlspecialchars($pesquisa); ?>" style="padding-left: 35px;">
                <i class="fa-sharp fa-solid fa-magnifying-glass position-absolute"
                    style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
            </div>

            <!-- Ícone que alterna a visibilidade dos checkboxes -->
            <i class="fa fa-sliders filter-icon mx-2" style="font-size:30px; padding:6px;"
                onclick="toggleFilterPanel()"></i>

            <!-- Painel de filtros que aparece ao lado direito -->
            <div id="filterPanel" style="display: none;">
                <div class="form-check">
                    <input type="checkbox" id="alertaMedia" class="form-check-input">
                    <label for="alertaMedia">
                        <i class="fas fa-exclamation-triangle" style="color: orange;"></i> Alerta quantidade Média
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="alertaBaixa" class="form-check-input" checked>
                    <label for="alertaBaixa">
                        <i class="fas fa-exclamation-triangle" style="color: red;"></i> Alerta quantidade Baixa
                    </label>
                </div>
            </div>
        </div>

        <table class="table table-hover text-center table-custom">
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
                        ?>
                        <tr>
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

        <!-- Paginação -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?pesquisar=<?php echo urlencode($pesquisa); ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/pesquisa_estoque.js"></script>
    <script>
        function toggleFilterPanel() {
            const filterPanel = document.getElementById("filterPanel");
            filterPanel.style.display = filterPanel.style.display === "none" ? "block" : "none";
        }
    </script>

</body>

</html>