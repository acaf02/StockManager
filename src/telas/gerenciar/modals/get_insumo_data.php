<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

if (isset($_GET['cod_insumo'])) {
    $cod_insumo = (int)$_GET['cod_insumo'];

    // Consulta para obter os dados do insumo
    $query = "SELECT * FROM insumo WHERE cod_insumo = ?";
    $stmt = $connection->prepare($query);
    
    if (!$stmt) {
        error_log("Erro ao preparar a consulta: " . $connection->error);
        echo json_encode(["status" => "error", "message" => "Erro na consulta."]);
        exit;
    }

    $stmt->bind_param('i', $cod_insumo);
    
    if (!$stmt->execute()) {
        error_log("Erro ao executar a consulta: " . $stmt->error);
        echo json_encode(["status" => "error", "message" => "Erro ao executar a consulta."]);
        exit;
    }
    
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Retorna os dados como JSON
        echo json_encode([
            "status" => "success",
            "insumo" => $row
        ]);
    } else {
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
