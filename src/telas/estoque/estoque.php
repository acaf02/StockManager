<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Define consulta SQL com base na pesquisa
$pesquisa = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';
$sql = "SELECT * FROM insumo " . ($pesquisa ? "WHERE produto LIKE '%$pesquisa%'" : "") . " ORDER BY cod_insumo ASC";
$result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));
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

    <div class="container" style="padding:20px;">
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

            <i class="fa fa-sliders mx-2" style="font-size:30px; padding:6px;"></i>
        </div>

        <table class="table table-hover text-center">
            <thead class="table-dark">
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
                        echo '<tr>
                                <td><a href="../visualizar/visualizar.php?cod_insumo=' . $row['cod_insumo'] . '" class="text-decoration" style="color: black;">
                                    ' . htmlspecialchars($row['produto']) . '</a></td>
                                <td>' . htmlspecialchars($row['peso'] . ' ' . $row['unidade']) . '</td>
                                <td>' . htmlspecialchars($row['quantidade']) . '</td>
                              </tr>';
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum insumo encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/pesquisa_estoque.js"></script>

</body>

</html>