<?php
include_once ('../../db/db_connection.php');

$cod_insumo = $_GET['cod_insumo'];

$sql= "DELETE FROM insumo WHERE cod_insumo = $cod_insumo";

$result = mysqli_query($connection, $sql);

if ($result) {
    header("Location: ../estoque/estoque.php?msg=Deletado com Sucesso!");
} else {
    echo "Falhou: " . mysqli_error($connection);
}
?>