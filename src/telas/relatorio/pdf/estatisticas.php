<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuração do Dompdf
$options = new Options();
$options->set('defaultFont', 'Roboto');
$options->set('enable_remote', true);
$dompdf = new Dompdf($options);


// Consultar os insumos mais consumidos
$query_more = "
    SELECT produto, peso, unidade, total_consumido 
    FROM insumo 
    ORDER BY total_consumido DESC
    LIMIT 10
";
$result_more = $connection->query($query_more);

// Consultar os insumos menos consumidos
$query_less = "
    SELECT produto, peso, unidade, total_consumido 
    FROM insumo 
    ORDER BY total_consumido ASC
    LIMIT 10
";
$result_less = $connection->query($query_less);

// Carregar e converter a imagem do logo para base64
$logoPath = $_SERVER['DOCUMENT_ROOT'] . "/SM/src/assets/imagens/LogoSM.jpg";
$type = pathinfo($logoPath, PATHINFO_EXTENSION);
$data = file_get_contents($logoPath);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$html = ''; 

$html .= '
    <div style="text-align: center; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
        <img src="' . $base64 . '" alt="Logo" style="width: 150px; height: 55px; margin-right: 10px; padding-bottom: 20px;">
        <h2 style="color: #2e3d49; font-family: Roboto, sans-serif; font-size: 24px; font-weight: bold; margin: 0;">Estatísticas</h2>
    </div>
    <h2 style="color: #2e3d49; font-family: Roboto, sans-serif; font-size: 20px; margin-bottom: 10px;">Insumos Mais Consumidos</h2>
    <table style="width: 100%; border-collapse: collapse; font-family: Roboto, sans-serif; border: none; background-color: #f8f9fa; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); ">
        <thead style="background-color: #006233; color: white; text-align: left;">
            <tr>
                <th style="padding: 12px; font-weight: bold; color: white;">Produto</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Peso/Unidade</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Total Consumido</th>
            </tr>
        </thead>
        <tbody>
';

// Preenchendo a tabela com os dados dos insumos mais consumidos
while ($row_more = $result_more->fetch_assoc()) {
    $html .= '
        <tr>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . htmlspecialchars($row_more['produto']) . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . $row_more['peso'] . " " . $row_more['unidade'] . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . (int)$row_more['total_consumido'] . '</td>
        </tr>
    ';
}

$html .= '
        </tbody>
    </table>
    <h3 style="color: #2e3d49; font-family: Roboto, sans-serif; font-size: 20px; margin-top: 30px; margin-bottom: 10px;">Insumos Menos Consumidos</h3>
    <table style="width: 100%; border-collapse: collapse; font-family: Roboto, sans-serif; border: none; background-color: #f8f9fa; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); ">
        <thead style="background-color: #006233; color: white; text-align: left;">
            <tr>
                <th style="padding: 12px; font-weight: bold; color: white;">Produto</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Peso/Unidade</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Total Consumido</th>
            </tr>
        </thead>
        <tbody>
';

// Preenchendo a tabela com os dados dos insumos menos consumidos
while ($row_less = $result_less->fetch_assoc()) {
    $html .= '
        <tr>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . htmlspecialchars($row_less['produto']) . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . $row_less['peso'] . " " . $row_less['unidade'] . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . (int)$row_less['total_consumido'] . '</td>
        </tr>
    ';
}

$html .= '
        </tbody>
    </table>
';

// Carregar o HTML no Dompdf
$dompdf->loadHtml($html);

// Renderizar o PDF
$dompdf->render();

// Exibir o PDF no navegador
$dompdf->stream(
    "relatorio_consumo_insumos.pdf",
    array(
        "Attachment" => true
    )
);
?>
