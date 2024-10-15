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
    <title>Adicionar Insumos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Modal para adicionar insumos -->
    <div id="modalAdicionarInsumo" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicione Insumos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="number" class="form-control" id="adicionaInsumo" placeholder="Quantidade" min="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onclick="adicionar()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Carregar jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Carregar Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    function adicionar() {
    let quantidade = $('#adicionaInsumo').val();
    let cod_insumo = $('#modalAdicionarInsumo').data('cod_insumo');  // Pega o cod_insumo definido anteriormente

    if (!quantidade || !cod_insumo) {
        alert('Por favor, preencha todos os campos corretamente.');
        return;
    }

    // Envia os dados via AJAX
    $.ajax({
        url: 'gerenciar.php',
        method: 'POST',
        data: {
            quantidade: quantidade,
            cod_insumo: cod_insumo
        },
        success: function (response) {
            try {
                let resposta = JSON.parse(response);

                if (resposta.status === 'success') {
                    alert('Quantidade Atualizada com Sucesso!');
                    $('#modalAdicionarInsumo').modal('hide');  // Fecha o modal
                    location.reload();  // Recarrega a página para refletir as mudanças
                } else {
                    alert('Erro: ' + resposta.message); 
                }
            } catch (e) {
                alert('Erro no processamento da resposta do servidor.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição:', error); 
        }
    });
}

</script>

</body>
</html>
