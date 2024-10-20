<?php
    include "verification.php";
?>

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
                    'quantidade': quantidade,
                    'operation': 'retirar'
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