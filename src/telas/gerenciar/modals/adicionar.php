<?php
include($_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php");
 // erro que aparece {"status":"error","message":"M\u00e9todo inv\u00e1lido."} {"status":"error","message":"M\u00e9todo inv\u00e1lido."}
 // se tu for na url dos modals aparece isso {"status":"error","message":"M\u00e9todo inv\u00e1lido."}
 // e tipo ta pegando GET só que continua funcionando a função aqui em baixo só q eu acho q por
 //ta pegando ger ta dando esse else lá embaixo
 // mesmo erro acontece em retirar.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifique se é uma requisição POST
    // Verifica se os parâmetros estão presentes
    if (isset($_POST['quantidade'], $_POST['cod_insumo'])) {
        $quantidade = (int) $_POST['quantidade'];
        $cod_insumo = (int) $_POST['cod_insumo'];

        if ($quantidade > 0) {
            $query = "UPDATE insumo SET quantidade = quantidade + ? WHERE cod_insumo = ?";
            $stmt = $connection->prepare($query);

            if ($stmt) {
                $stmt->bind_param('ii', $quantidade, $cod_insumo);

                if ($stmt->execute()) {
                    // Resposta em formato JSON para ser tratada no frontend
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
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados não recebidos.']);
    }

    $connection->close();
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Insumos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Modal Adicionar -->
    <div class="modal fade" id="modalAdicionarInsumo" tabindex="-1" aria-labelledby="modalAdicionarInsumoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarInsumoLabel">Adicionar Insumo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campo para adicionar a quantidade -->
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <!-- O ID do campo quantidade agora é dinâmico com base no cod_insumo -->
                        <input type="number" class="form-control" id="quantidade_modal" placeholder="Digite a quantidade" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botão para adicionar insumo -->
                    <button type="button" id="btnAdicionar" class="btn btn-primary" data-cod_insumo="">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on("click", "#btnAdicionar", function (event) {
    event.preventDefault();
    
    // Pega o valor do cod_insumo e da quantidade
    var codInsumo = $(this).data("cod_insumo");
    var quantidade = $("#quantidade_modal").val();

    if (!quantidade || isNaN(quantidade) || parseInt(quantidade) <= 0) {
        alert("Digite uma quantidade válida.");
        return;
    }

    // Desativa o botão para evitar múltiplos cliques
    $("#btnAdicionar").prop('disabled', true);

    fetch('modals/adicionar.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
        cod_insumo: codInsumo,
        quantidade: quantidade
    })
})
.then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        alert("Insumo adicionado com sucesso!");
        $('#modalAdicionarInsumo').modal('hide');
        window.location.reload();
    } else {
        console.error('Erro:', data.message);
    }
})
.catch(error => console.error('Erro na requisição:', error));

        });
    </script>
</body>

</html>