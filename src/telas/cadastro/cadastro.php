<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Verifica se o formulário foi enviado e obtém os valores do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = $_POST['produto'] ?? null;
    $peso = $_POST['peso'] ?? null;
    $unidade = $_POST['unidade'] ?? null;
    $quantidade = $_POST['quantidade'] ?? null;
    $estoque_min = $_POST['estoque_min'] ?? null;
    $estoque_medio = $_POST['estoque_medio'] ?? null;

    // Verifica se algum dos campos obrigatórios está vazio
    if (
        is_null($produto) || is_null($peso) || is_null($unidade) ||
        is_null($quantidade) || is_null($estoque_min) || is_null($estoque_medio)
    ) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit;
    }

    // Prepara a consulta SQL para inserir um novo insumo na tabela 'insumo'
    $sql = "INSERT INTO insumo (produto, peso, unidade, quantidade, estoque_min, estoque_medio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sisiii", $produto, $peso, $unidade, $quantidade, $estoque_min, $estoque_medio);

        // Executa a consulta
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../estoque/estoque.php?msg=Insumo Cadastrado Com Sucesso!");
            exit;
        } else {
            echo "Erro ao cadastrar insumo: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro ao preparar a consulta: " . mysqli_error($connection);
    }
}

// Fecha a conexão
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/cadastro.css">
    <title>Cadastro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>

    <?php
    include_once('../../componentes/header.php');
    ?>

    <div class="container" style="padding-top: 120px;">
        <div class="text-center mb-4">
            <h3>Cadastre um novo Insumo</h3>
            <p class="text-muted">Complete o formulário abaixo para cadastrar um novo insumo.</p>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="cadastro.php" method="post" style="width:50vw; min-width:300px;" id="formulario-insumo">
                <div class="row mb-3">
                    <div class="mb-3">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" id="produto" name="produto"
                            placeholder="Escreva nome do produto" required>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Peso</label>
                        <input type="number" class="form-control" id="peso" name="peso" placeholder="Ex: 5">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Unidade</label>
                        <select class="form-control" id="unidade" name="unidade" required>
                            <option value="">Selecione</option>
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="L">L</option>
                            <option value="mL">mL</option>
                            <option value="ton">ton</option>
                            <option value="un">un</option>
                            <option value="m">m</option>
                            <option value="cm">cm</option>
                            <option value="dúzia">dúzia</option>
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Quantidade Inicial</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="Ex: 50"
                            required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col mb-3">
                        <label class="form-label">Estoque Mínimo</label>
                        <input type="number" class="form-control" id="estoque_min" name="estoque_min"
                            placeholder="Ex: 20" required>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">Estoque Médio</label>
                        <input type="number" class="form-control" id="estoque_medio" name="estoque_medio"
                            placeholder="Ex: 35" required>
                    </div>
                </div>

                <div style="text-align: right; padding:15px 10;">
                    <a href="../inicio/inicio.php" class="btn btn-danger me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success" id="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="../../js/cadastro.js"></script>
</body>

</html>