<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Função para obter a quantidade mínima e média
function getMinMedQuantity($connection, $cod_insumo) {
    $query_min_med_quantity = "SELECT estoque_min, estoque_medio FROM insumo WHERE cod_insumo = '$cod_insumo'";
    $result_min = mysqli_query($connection, $query_min_med_quantity);
    return $result_min ? mysqli_fetch_assoc($result_min) : ['estoque_min' => 0, 'estoque_medio' => 0];
}

if (!empty($_GET['palavra'])) {
    $data = $_GET['palavra'];
    $data = mysqli_real_escape_string($connection, $data);
    $sql = "SELECT * FROM insumo WHERE produto LIKE '%$data%' ORDER BY cod_insumo ASC";
} else {
    $sql = "SELECT * FROM insumo ORDER BY cod_insumo ASC";
}

$result = mysqli_query($connection, $sql);

$insumos = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $min_med_quantity = getMinMedQuantity($connection, $row['cod_insumo']);
        $min_quantity = $min_med_quantity['estoque_min'];
        $med_quantity = $min_med_quantity['estoque_medio'];

        $alert = null;
        if ($row['quantidade'] <= $min_quantity) {
            $alert = 'red';
        } elseif ($row['quantidade'] <= $med_quantity) {
            $alert = 'orange';
        }

        $insumos[] = [
            'cod_insumo' => $row['cod_insumo'],
            'produto' => $row['produto'],
            'peso' => $row['peso'],
            'unidade' => $row['unidade'],
            'quantidade' => $row['quantidade'],
            'alerta' => $alert
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($insumos);
?>
