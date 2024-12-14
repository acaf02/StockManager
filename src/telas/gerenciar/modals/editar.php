<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Variáveis para os dados do insumo
$cod_insumo = '';
$estoque_min = '';
$estoque_medio = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos necessários estão setados
    if (isset($_POST['cod_insumo'], $_POST['estoque_min'], $_POST['estoque_medio'])) {
        $cod_insumo = (int) $_POST['cod_insumo'];
        $estoque_min = $_POST['estoque_min'];
        $estoque_medio = $_POST['estoque_medio'];

        // Preparar a consulta para atualizar o insumo
        $query = "UPDATE insumo SET estoque_min = ?, estoque_medio = ? WHERE cod_insumo = ?";
        $stmt = $connection->prepare($query);

        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta: ' . $connection->error]);
            exit;
        }

        $stmt->bind_param('iii', $estoque_min, $estoque_medio, $cod_insumo);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Insumo editado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar insumo: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos recebidos.']);
    }
    exit;
}
?>

<!-- Modal para edição -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container d-flex justify-content-center">
                    <form style="width:50vw; min-width:300px;" id="formulario-insumo">
                        <input type="hidden" id="cod_insumo" name="cod_insumo" value="<?php echo $cod_insumo; ?>">
                        <div class="row mb-3">
                            <div class="col mb-3">
                                <label class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="estoque_min" name="estoque_min" value="<?php echo $estoque_min; ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Estoque Médio</label>
                                <input type="number" class="form-control" id="estoque_medio" name="estoque_medio" value="<?php echo $estoque_medio; ?>" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSalvar">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on("click", "#btnSalvar", function (event) {
    event.preventDefault();

    // Obter os valores dos campos do modal
    var codInsumo = $("#cod_insumo").val();
    var estoqueMin = $("#estoque_min").val();
    var estoqueMedio = $("#estoque_medio").val();

    // Validação dos campos
    if (!estoqueMin || !estoqueMedio) {
        alert("Por favor, preencha todos os campos com valores válidos.");
        return;
    }

    $("#btnSalvar").prop('disabled', true);

    $.ajax({
        url: 'modals/editar.php',
        type: 'POST',
        data: {
            cod_insumo: codInsumo,
            estoque_min: estoqueMin,
            estoque_medio: estoqueMedio
        },
        success: function (response) {
            console.log("Resposta do servidor:", response);
            try {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert("Erro: " + data.message);
                }
            } catch (e) {
                console.error("Erro ao parsear JSON:", e);
                alert("Erro inesperado: " + response);
            }
        },
        error: function (xhr, status, error) {
            console.error("Response:", xhr.responseText);
            alert("Erro ao enviar o formulário: " + error);
        },
        complete: function () {
            $("#btnSalvar").prop('disabled', false);
        }
    });
});
</script>
