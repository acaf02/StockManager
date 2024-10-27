<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

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
        $insumos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($insumos);
?>
