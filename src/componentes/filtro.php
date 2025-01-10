<?php
$order_clause = "";
$where_clause = "";
$selected_text = "Classificar por: Estoque Completo";

// Verificação de ordenação
if (isset($_GET['ordenar'])) {
    $ordenar = mysqli_real_escape_string($connection, $_GET['ordenar']);

    if ($ordenar === 'media') {
        $where_clause = "WHERE quantidade <= estoque_medio AND quantidade > estoque_min";
        $order_clause = "ORDER BY estoque_medio DESC, quantidade DESC";
        $selected_text = "Classificar por: Alerta quantidade Média";
    } elseif ($ordenar === 'baixa') {
        $where_clause = "WHERE quantidade <= estoque_min";
        $order_clause = "ORDER BY estoque_min DESC, quantidade ASC";
        $selected_text = "Classificar por: Alerta quantidade Baixa";
    } elseif ($ordenar === 'tudo') {
        $order_clause = "ORDER BY produto ASC";
        $selected_text = "Classificar por: Estoque Completo";
    }
} else {
    $order_clause = "ORDER BY produto ASC";
}

// Páginação: Número de itens por página
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Consulta SQL para os itens com filtro, ordenação e paginação
$query = "SELECT * FROM insumo";

if ($where_clause) {
    $query .= " " . $where_clause;
}

if ($order_clause) {
    $query .= " " . $order_clause;
}

$query .= " LIMIT $limit OFFSET $offset"; 

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Erro ao buscar dados: " . mysqli_error($connection));
}

// Consulta SQL para total de itens
$query_total = "SELECT COUNT(*) as total FROM insumo";
if ($where_clause) {
    $query_total .= " " . $where_clause;
}
$result_total = mysqli_query($connection, $query_total);
$total_items = mysqli_fetch_assoc($result_total)['total'];
$total_pages = ceil($total_items / $limit);
?>


<style>
    .dropdown {
        padding: 5px;
        font-size: 18px;
        margin-left: 5px;
    }

    .dropdown-menu .dropdown-item i {
        margin-right: 10px;
    }

    .dropdown-menu .dropdown-item {
        font-size: 16px;
    }
</style>

<div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $selected_text; ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <!-- Opção para mostrar o estoque completo -->
        <li>
            <a class="dropdown-item" href="?ordenar=tudo">
                <i class="fas fa-list"></i> Estoque Completo
            </a>
        </li>
        <!-- Opção de alerta de quantidade média -->
        <li>
            <a class="dropdown-item" href="?ordenar=media">
                <i class="fas fa-exclamation-triangle" style="color: orange;"></i> Alerta quantidade Média
            </a>
        </li>
        <!-- Opção de alerta de quantidade baixa -->
        <li>
            <a class="dropdown-item" href="?ordenar=baixa">
                <i class="fas fa-exclamation-triangle" style="color: red;"></i> Alerta quantidade Baixa
            </a>
        </li>
    </ul>
</div>
