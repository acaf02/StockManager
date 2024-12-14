<style>
    .pagination .page-link {
        color: #6c757d;
        border: 1px solid #ddd;
    }

    .pagination .page-item:hover .page-link {
        background-color: #e2e6ea;
        color: #495057;
    }

    .pagination .page-item.active .page-link {
        background-color: #006233;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f8f9fa;
        border-color: #ddd;
    }

    .pagination .page-link {
        border-radius: 4px;
        padding: 8px 12px;
        text-decoration: none;
    }
</style>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

$pesquisar = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';


$limit = 12;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "") . " ORDER BY cod_insumo ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));


$total_sql = "SELECT COUNT(*) as total FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "");
$total_result = mysqli_query($connection, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $limit);

?>
