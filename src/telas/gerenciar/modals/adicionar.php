<?php
include "verification.php";
?>

<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdicionarInsumo" tabindex="-1" aria-labelledby="modalAdicionarInsumoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdicionarInsumoLabel">Adicionar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Campo para adicionar a quantidade -->
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
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

        // Enviando os dados via AJAX usando $.ajax()
        $.ajax({
            url: 'modals/adicionar.php',
            method: 'POST',
            data: {
                cod_insumo: codInsumo,
                quantidade: quantidade,
                operation: 'adicionar'
            },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    alert("Insumo adicionado com sucesso!");
                    window.location.reload();
                } else {
                    console.error('Erro:', data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição:', error);
            },
            complete: function () {
                $("#btnAdicionar").prop('disabled', false);
            }
        });
    });


</script>