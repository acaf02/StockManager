<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

$cod_insumo = '';
$produto = '';
$peso = '';
$unidade = '';
$quantidade = '';
$estoque_min = '';
$estoque_medio = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos necessários estão setados
    if (isset($_POST['cod_insumo'], $_POST['produto'], $_POST['peso'], $_POST['unidade'], $_POST['quantidade'], $_POST['estoque_min'], $_POST['estoque_medio'])) {
        $cod_insumo = (int) $_POST['cod_insumo'];
        $produto = $_POST['produto'];
        $peso = $_POST['peso'];
        $unidade = $_POST['unidade'];
        $quantidade = $_POST['quantidade'];
        $estoque_min = $_POST['estoque_min'];
        $estoque_medio = $_POST['estoque_medio'];

        // Preparar a consulta para atualizar o insumo
        $query = "UPDATE insumo SET produto = ?, peso = ?, unidade = ?, quantidade = ?, estoque_min = ?, estoque_medio = ? WHERE cod_insumo = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('sisiiii', $produto, $peso, $unidade, $quantidade, $estoque_min, $estoque_medio, $cod_insumo);

        if ($stmt->execute()) {
            // Se a atualização for bem-sucedida
            echo json_encode(['status' => 'success', 'message' => 'Insumo editado com sucesso!']);
            exit;
        } else {
            // Se houver erro na execução da consulta
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar insumo.']);
            exit;
        }
    } else {
        // Se algum dado obrigatório não foi recebido
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos recebidos.']);
        exit;
    }
}
?>

<!-- modal para edição -->
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
                                <input type="text" class="form-control" id="produto" name="produto"
                                    value="<?php echo $produto; ?>">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Peso</label>
                                <input type="number" class="form-control" id="peso" name="peso"
                                    value="<?php echo $peso; ?>">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Unidade</label>
                                <select class="form-control" id="unidade" name="unidade">
                                    <option value="">Selecione</option>
                                    <option value="kg" <?php if ($unidade == 'kg')
                                        echo 'selected'; ?>>kg</option>
                                    <option value="g" <?php if ($unidade == 'g')
                                        echo 'selected'; ?>>g</option>
                                    <option value="L" <?php if ($unidade == 'L')
                                        echo 'selected'; ?>>L</option>
                                    <option value="mL" <?php if ($unidade == 'mL')
                                        echo 'selected'; ?>>mL</option>
                                    <option value="ton" <?php if ($unidade == 'ton')
                                        echo 'selected'; ?>>ton</option>
                                    <option value="un" <?php if ($unidade == 'un')
                                        echo 'selected'; ?>>un</option>
                                    <option value="m" <?php if ($unidade == 'm')
                                        echo 'selected'; ?>>m</option>
                                    <option value="cm" <?php if ($unidade == 'cm')
                                        echo 'selected'; ?>>cm</option>
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade"
                                    value="<?php echo $quantidade; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col mb-3">
                                <label class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="estoque_min" name="estoque_min"
                                    value="<?php echo $estoque_min; ?>">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Estoque Médio</label>
                                <input type="number" class="form-control" id="estoque_medio" name="estoque_medio"
                                    value="<?php echo $estoque_medio; ?>">
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
<script src="../../js/editar.js"></script>