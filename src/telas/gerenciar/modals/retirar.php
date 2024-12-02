<?php
include "verification.php";
?>

<!-- Modal Retirar -->
<div class="modal fade" id="modalRetirarInsumo" tabindex="-1" aria-labelledby="modalRetirarInsumoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRetirarInsumoLabel">Retirar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Campo para Retirar a quantidade -->
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade" placeholder="Digite a quantidade"
                        required>
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
    $(document).on("click", "#btnRetirar", function (event) {
        event.preventDefault();

        var codInsumo = $("#modalRetirarInsumo").data("cod_insumo"); // Pegando o cod_insumo
        console.log("Código do insumo enviado: ", codInsumo); // Verificar o código do insumo
        var quantidade = $("#quantidade").val();

        if (!quantidade || isNaN(quantidade) || parseInt(quantidade) <= 0) {
            alert("Digite uma quantidade válida.");
            return;
        }

        $("#btnRetirar").prop('disabled', true);

        $.ajax({
            url: 'modals/retirar.php',
            method: 'POST',
            data: {
                cod_insumo: codInsumo,
                quantidade: quantidade,
                operation: 'retirar'
            },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    alert("Insumo retirado com sucesso!");
                    $('#modalRetirarInsumo').modal('hide');
                    window.location.reload(); // Recarregar a página
                } else {
                    alert("Erro ao retirar insumo: " + data.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Erro na requisição: " + error);
            },
            complete: function () {
                $("#btnRetirar").prop('disabled', false);
            }
        });
    });



</script>