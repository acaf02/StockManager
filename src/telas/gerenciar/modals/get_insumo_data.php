<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Verificação de depuração
error_log("Debug: Iniciando a recuperação de dados do insumo via AJAX.");

if (isset($_GET['cod_insumo'])) {
    $cod_insumo = (int)$_GET['cod_insumo'];

    // Log para verificar o código do insumo recebido
    error_log("Debug: Código do insumo recebido via AJAX: $cod_insumo");

    // Consulta para obter os dados do insumo
    $query = "SELECT * FROM insumo WHERE cod_insumo = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $cod_insumo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Log para verificar os dados retornados
        error_log("Debug: Dados do insumo encontrados: " . json_encode($row));
        
        // Adicione esta linha para verificar a quantidade
        error_log("Quantidade do insumo: " . $row['quantidade']);
        
        // Retorna os dados como JSON
        echo json_encode([
            "status" => "success",
            "insumo" => $row
        ]);
    } else {
        // Log para verificar se nenhum resultado foi encontrado
        error_log("Erro: Nenhum insumo encontrado com o código $cod_insumo via AJAX.");
        echo json_encode([
            "status" => "error",
            "message" => "Insumo não encontrado!"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Código do insumo não fornecido."
    ]);
}
?>
