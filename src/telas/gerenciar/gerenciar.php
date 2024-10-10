<?php
include "../../db/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantidade'], $_POST['cod_insumo'])) {
    $quantidade = (int) $_POST['quantidade'];
    $cod_insumo = (int) $_POST['cod_insumo'];

    if ($quantidade > 0) {
        $query = "UPDATE insumo SET quantidade = quantidade + ? WHERE cod_insumo = ?";
        $stmt = $connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ii', $quantidade, $cod_insumo);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Quantidade atualizada com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar a quantidade.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Quantidade inválida.']);
    }

    $connection->close();
    exit();
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gerenciar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <?php
    include_once('../../componentes/header.php');
    include_once('../../componentes/navbar.php');
    ?>

    <div class="container" style="padding:20px;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="../estoque/estoque.php" class="btn btn-dark">Visualizar</a>
            <a href="../cadastro/cadastro.php" class="btn btn-dark mx-2">
                <i class="fa-solid fa-circle-plus"></i> Cadastrar
            </a>
            <div class="search-container">
                <input type="text" class="form-control" placeholder="Pesquisar...">
            </div>
            <button class="btn btn-dark">
                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
            </button>
            <i class="fa fa-sliders mx-2" style="font-size:30px; padding:6px;"></i>
        </div>


        <!-- Modal para adicionar insumos -->
        <div id="modalAdicionarInsumo" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicione Insumos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" id="adicionaInsumo" name="adicionaInsumo"
                            placeholder="0">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-success" onclick="adicionar()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para retirar insumos -->
        <div id="modalRetirarInsumo" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Retire Insumos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" id="retireInsumo" name="retireInsumo"
                            placeholder="0">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-success" onclick="retirar()">Salvar</button>
                    </div>
                </div>
            </div>
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
                $sql = "SELECT * FROM `insumo`";
                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['produto'] ?></td>
                        <td><?php echo $row['peso'] . ' ' . $row['unidade']; ?></td>
                        <td><?php echo $row['quantidade'] ?></td>
                        <td>
                            <a href="#" class="open-modal-adicionar" data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                <i class="fa-regular fa-square-plus"
                                    style="color: green; font-size:20px; padding-top: 4px;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="open-modal-retirar" data-cod_insumo="<?php echo $row['cod_insumo']; ?>">
                                <i class="fa-regular fa-square-minus"
                                    style="color: red; font-size:20px; padding-top: 4px;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="gerenciar.js"></script>

</body>

</html>