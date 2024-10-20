<?php
    include "verification.php";
?>

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
                    <input type="number" class="form-control" id="quantidade_modal" placeholder="Digite a quantidade"
                        required>
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

        var codInsumo = $(this).data("cod_insumo");
        var quantidade = $("#quantidade_modal").val();

        if (!quantidade || isNaN(quantidade) || parseInt(quantidade) <= 0) {
            alert("Digite uma quantidade válida.");
            return;
        }
        
        $("#btnAdicionar").prop('disabled', true);

        fetch('modals/adicionar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                cod_insumo: codInsumo,
                quantidade: quantidade,
                operation: 'adicionar'
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