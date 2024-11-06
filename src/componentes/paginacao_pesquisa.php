<style>
    /* Estilo para o link da página */
    .pagination .page-link {
        color: #6c757d;
        border: 1px solid #ddd;
    }

    /* Hover (quando passa o mouse por cima) */
    .pagination .page-item:hover .page-link {
        background-color: #e2e6ea;
        color: #495057;
    }

    /* Paginação ativa (quando a página está selecionada) */
    .pagination .page-item.active .page-link {
        background-color: #006233;
        color: white;
    }

    /* Desabilitar a cor do link quando o botão está desabilitado */
    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f8f9fa;
        border-color: #ddd;
    }

    /* Borda das páginas (quando não está ativo ou desabilitado) */
    .pagination .page-link {
        border-radius: 4px;
        padding: 8px 12px;
        text-decoration: none;
    }
</style>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Define consulta SQL com base na pesquisa
$pesquisar = !empty($_GET['pesquisar']) ? mysqli_real_escape_string($connection, $_GET['pesquisar']) : '';


$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "") . " ORDER BY cod_insumo ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $sql) or die("Erro na consulta: " . mysqli_error($connection));

// Get total number of items for pagination
$total_sql = "SELECT COUNT(*) as total FROM insumo " . ($pesquisar ? "WHERE produto LIKE '%$pesquisar%'" : "");
$total_result = mysqli_query($connection, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $limit);

?>
