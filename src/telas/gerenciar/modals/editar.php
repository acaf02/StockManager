<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

$cod_insumo = '';
$produto = '';
$peso = '';
$unidade = '';
$quantidade = '';
$estoque_min = '';
$estoque_medio = ''; 

if (isset($_GET['cod_insumo'])) {
    $cod_insumo = (int) $_GET['cod_insumo'];

    // Consulta para obter os dados do insumo
    $query = "SELECT * FROM insumo WHERE cod_insumo = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $cod_insumo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se encontrou o insumo
    if ($row = $result->fetch_assoc()) {
        $produto = $row['produto'];
        $peso = $row['peso'];
        $unidade = $row['unidade'];
        $quantidade = $row['quantidade'];
        $estoque_min = $row['estoque_min'];
        $estoque_medio = $row['estoque_medio'];
    } else {
        echo "Insumo não encontrado!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cod_insumo'], $_POST['produto'], $_POST['peso'], $_POST['unidade'], $_POST['quantidade'], $_POST['estoque_min'], $_POST['estoque_medio'])) {
        $cod_insumo = (int) $_POST['cod_insumo'];
        $produto = $_POST['produto'];
        $peso = (int) $_POST['peso'];
        $unidade = $_POST['unidade'];
        $quantidade = (int) $_POST['quantidade'];
        $estoque_min = (int) $_POST['estoque_min'];
        $estoque_medio = (int) $_POST['estoque_medio'];

        $query = "UPDATE insumo SET produto = ?, peso = ?, unidade = ?, quantidade = ?, estoque_min = ?, estoque_medio = ? WHERE cod_insumo = ?";
        $stmt = $connection->prepare($query);
        if ($stmt) {
            $stmt->bind_param('sisiii', $produto, $peso, $unidade, $quantidade, $estoque_min, $estoque_medio, $cod_insumo);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Dados atualizados com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar os dados.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos ou método inválido.']);
    }
    $connection->close();
    exit();
}
?>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                            <div class="mb-3">
                                <label class="form-label">Produto</label>
                                <input type="text" class="form-control" id="produto_modal" name="produto" value="<?php echo $produto; ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Peso</label>
                                <input type="number" class="form-control" id="peso_modal" name="peso" value="<?php echo $peso; ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Unidade</label>
                                <select class="form-control" id="unidade_modal" name="unidade" required>
                                    <option value="">Selecione</option>
                                    <option value="kg" <?php if ($unidade == 'kg') echo 'selected'; ?>>kg</option>
                                    <option value="g" <?php if ($unidade == 'g') echo 'selected'; ?>>g</option>
                                    <option value="L" <?php if ($unidade == 'L') echo 'selected'; ?>>L</option>
                                    <option value="mL" <?php if ($unidade == 'mL') echo 'selected'; ?>>mL</option>
                                    <option value="ton" <?php if ($unidade == 'ton') echo 'selected'; ?>>ton</option>
                                    <option value="un" <?php if ($unidade == 'un') echo 'selected'; ?>>un</option>
                                    <option value="m" <?php if ($unidade == 'm') echo 'selected'; ?>>m</option>
                                    <option value="cm" <?php if ($unidade == 'cm') echo 'selected'; ?>>cm</option>
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Quantidade Inicial</label>
                                <input type="number" class="form-control" id="quantidade_modal" name="quantidade" value="<?php echo $quantidade ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col mb-3">
                                <label class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="estoque_min_modal" name="estoque_min" value="<?php echo $estoque_min ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Estoque Médio</label>
                                <input type="number" class="form-control" id="estoque_medio_modal" name="estoque_medio" value="<?php echo $estoque_medio ?>" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSalvar" class="btn btn-primary" data-cod_insumo="<?php echo $cod_insumo; ?>">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on("click", "#btnSalvar", function (event) {
    event.preventDefault();
    var codInsumo = $(this).data("cod_insumo");
    
    // Obter os valores dos campos do modal
    var produto = $("#produto_modal").val();
    var peso = $("#peso_modal").val();
    var unidade = $("#unidade_modal").val();
    var quantidade = $("#quantidade_modal").val();
    var estoqueMin = $("#estoque_min_modal").val();
    var estoqueMedio = $("#estoque_medio_modal").val();

    // Validação dos campos
    if (!produto || !peso || !unidade || !quantidade || !estoqueMin || !estoqueMedio) {
        alert("Por favor, preencha todos os campos com valores válidos.");
        return;
    }

    $("#btnSalvar").prop('disabled', true);

    fetch('modals/editar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            cod_insumo: codInsumo,
            produto: produto,
            peso: peso,
            unidade: unidade,
            quantidade: quantidade,
            estoque_min: estoqueMin,
            estoque_medio: estoqueMedio,
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            window.location.reload();
        } else {
            alert("Erro: " + data.message);
        }
    })
    .catch(error => {
        alert("Erro ao enviar o formulário: " + error.message);
    })
    .finally(() => {
        $("#btnSalvar").prop('disabled', false);
    });
});
</script>
