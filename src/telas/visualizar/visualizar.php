<?php
include "../../db/db_connection.php";

// Verifica se o código do insumo foi passado na URL
if (!empty($_GET['cod_insumo'])) {
    $cod_insumo = $_GET['cod_insumo'];

    $sql = "SELECT * FROM insumo WHERE cod_insumo = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $cod_insumo); // use "i" se for um inteiro
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se o insumo existe
    if ($row = mysqli_fetch_assoc($result)) {
        $produto = htmlspecialchars($row['produto']);
        $peso = htmlspecialchars($row['peso']);
        $unidade = htmlspecialchars($row['unidade']);
        $quantidade = htmlspecialchars($row['quantidade']);
        $estoque_min = htmlspecialchars($row['estoque_min']);
        $estoque_medio = htmlspecialchars($row['estoque_medio']);
    } else {
        echo "Insumo não encontrado.";
        exit;
    }
} else {
    echo "Nenhum insumo foi selecionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/visualizar.css">
    <title>Visualizar</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php
    include_once('../../componentes/header.php');
    ?>

    <div class="container" style="padding-top: 110px;">
        <div class="text-center mb-4">
            <h3 style="text-align: center;">Visualização de Insumo</h3>
            <p class="text-muted">Visualização dos detalhes do produto abaixo.</p>
        </div>

        <div class="container d-flex justify-content-center" style="background-color= #ACB2AD">
            <form style="width:50vw; min-width:300px;" id="formulario-insumo">
                <div class="row mb-3">
                    <div class="mb-3">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" id="produto" name="produto"
                            value="<?php echo $produto; ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Peso</label>
                        <input type="number" class="form-control" id="peso" name="peso" value="<?php echo $peso; ?>"
                            readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Unidade</label>
                        <select class="form-control" id="unidade" name="unidade" disabled>
                            <option value="">Selecione</option>
                            <option value="kg" <?php if ($unidade == 'kg')
                                echo 'selected'; ?>>kg</option>
                            <option value="g" <?php if ($unidade == 'g')
                                echo 'selected'; ?>>g</option>
                            <option value="L" <?php if ($unidade == 'L')
                                echo 'selected'; ?>>L</option>
                            <option value="mL" <?php if ($unidade == 'mL')
                                echo 'selected'; ?>>mL</option>
                            <option value="ton" <?php if ($unidade == 'ton')
                                echo 'selected'; ?>>ton</option>
                            <option value="un" <?php if ($unidade == 'un')
                                echo 'selected'; ?>>un</option>
                            <option value="m" <?php if ($unidade == 'm')
                                echo 'selected'; ?>>m</option>
                            <option value="cm" <?php if ($unidade == 'cm')
                                echo 'selected'; ?>>cm</option>
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade"
                            value="<?php echo $quantidade; ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col mb-3">
                        <label class="form-label">Estoque Mínimo</label>
                        <input type="number" class="form-control" id="estoque_min" name="estoque_min"
                            value="<?php echo $estoque_min; ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Estoque Médio</label>
                        <input type="number" class="form-control" id="estoque_medio" name="estoque_medio"
                            value="<?php echo $estoque_medio; ?>" readonly>
                    </div>
                </div>
                <div style="text-align: right;">

                    <a href="deletar.php?cod_insumo=<?php echo $row['cod_insumo']; ?>"
                        class="btn btn-danger">Excluir</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   

</html>