<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Modal para retirar insumos -->
    <div id="modalRetirarInsumo" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Retire Insumos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" id="retireInsumo" placeholder="0">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-success" onclick="retirar()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Função para salvar a quantidade ao retirar insumo
function retirar() {
    let quantidade = $('#retireInsumo').val(); 
    let cod_insumo = $('#modalRetirarInsumo').data('cod_insumo'); 

    if (!quantidade || !cod_insumo) {
        alert('Por favor, preencha todos os campos.');
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
            let resposta = JSON.parse(response); 

            if (resposta.status === 'success') {
                alert('Quantidade Atualizada!');
                location.reload(); 
            } else {
                alert('Erro: ' + resposta.message); 
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