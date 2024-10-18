<?php
include($_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se os dados estão chegando corretamente
    if (isset($_POST['quantidade'], $_POST['cod_insumo'])) {
        $quantidade = (int) $_POST['quantidade'];
        $cod_insumo = (int) $_POST['cod_insumo'];

        if ($quantidade > 0) {
            // Atualiza a quantidade subtraindo do insumo
            $query = "UPDATE insumo SET quantidade = quantidade - ? WHERE cod_insumo = ?";
            $stmt = $connection->prepare($query);

            if ($stmt) {
                $stmt->bind_param('ii', $quantidade, $cod_insumo);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Quantidade retirada com sucesso!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao retirar a quantidade.']);
                }

                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Quantidade inválida.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados não recebidos ou método inválido.']);
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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
   <!-- Modal Adicionar -->
<div class="modal fade" id="modalRetirarInsumo" tabindex="-1" aria-labelledby="modalRetirarInsumoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRetirarInsumoLabel">Retirar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Campo para Retirar a quantidade -->
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade" placeholder="Digite a quantidade" required>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Botão para Retirar insumo -->
                <button type="button" id="btnRetirar" class="btn btn-primary" data-cod_insumo="">Retirar</button>
            </div>
        </div>
    </div>
</div>

<script>
 

  document.querySelector("#btnRetirar").addEventListener("click", async function() {
    var codInsumo = document.querySelector("#modalRetirarInsumo").dataset.cod_insumo;  // Pegando o cod_insumo
    console.log("Código do insumo enviado: ", codInsumo);  // Verificar o código do insumo
    var quantidade = document.querySelector("#quantidade").value;

    if (!quantidade || isNaN(quantidade) || parseInt(quantidade) <= 0) {
        alert("Digite uma quantidade válida.");
        return;
    }

    document.querySelector("#btnRetirar").disabled = true;

    try {
        let response = await fetch('modals/retirar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'cod_insumo': codInsumo,
                'quantidade': quantidade
            })
        });

        let data = await response.json();
        
        if (data.status === 'success') {
            alert("Insumo retirado com sucesso!");
            $('#modalRetirarInsumo').modal('hide');
            window.location.reload();
        } else {
            alert("Erro ao retirar insumo: " + data.message);
        }
    } catch (error) {
        alert("Erro na requisição: " + error.message);
    } finally {
        document.querySelector("#btnRetirar").disabled = false;
    }
  });


</script>
</body>
</html>
