<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['quantidade'], $_POST['cod_insumo'], $_POST['operation'])) {
        $quantidade = (int) $_POST['quantidade'];
        $cod_insumo = (int) $_POST['cod_insumo'];
        $operation = (string) $_POST['operation'];
        $operation = strtolower($operation);

        if ($quantidade > 0) {
            // Atualiza a quantidade de acordo com a operação
            if ($operation == 'adicionar') {
                $query = "UPDATE insumo SET quantidade = quantidade + ? WHERE cod_insumo = ?";
            } else if ($operation == 'retirar') {
                $query = "UPDATE insumo SET quantidade = quantidade - ?, total_consumido = total_consumido + ? WHERE cod_insumo = ?";
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao processar a solicitação.']);
                exit();
            }
            
            $stmt = $connection->prepare($query);
            
            if ($stmt) {
                if ($operation == 'retirar') {
                    // Passa a quantidade duas vezes para atualizar `quantidade` e `total_consumido`
                    $stmt->bind_param('iii', $quantidade, $quantidade, $cod_insumo);
                } else {
                    $stmt->bind_param('ii', $quantidade, $cod_insumo);
                }
            
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Quantidade atualizada com sucesso!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar a quantidade.']);
                }
            
                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta.']);
            }
            
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Quantidade inválida.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados não recebidos ou método inválido.']);
    }

    $connection->close();
    exit();
}
?>