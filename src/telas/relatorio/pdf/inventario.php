<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

$result = "SELECT * FROM insumo";
$resultado_tabela = mysqli_query($connection, $result);

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf(['enable_remote' => true]);

// Definir orientação para paisagem
$dompdf->setPaper('A4', 'landscape');

// Carregar e converter a imagem do logo para base64
$logoPath = $_SERVER['DOCUMENT_ROOT'] . "/SM/src/assets/imagens/LogoSM.jpg";
$type = pathinfo($logoPath, PATHINFO_EXTENSION);
$data = file_get_contents($logoPath);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$html = '';

$html .= '
    <div style="text-align: center; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;"> 
        <img src="' . $base64 . '" alt="Logo" style="width: 150px; height: 55px; margin-right: 10px; padding-bottom: 20px;"> 
        <h2 style="color: #2e3d49; font-family: Roboto, sans-serif; font-size: 24px; font-weight: bold; margin: 0;">Inventário de Estoque</h2>
    </div>
    <table style="width: 100%; border-collapse: collapse; font-family: Roboto, sans-serif; border: none; background-color: #f8f9fa; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <thead style="background-color: #006233; color: white; text-align: left;">
            <tr>
                <th style="padding: 12px; font-weight: bold; color: white;">Produto</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Peso/Unidade</th>
                <th style="padding: 12px; font-weight: bold; color: white;">Quantidade</th>
            </tr>
        </thead>
        <tbody>
';

// Preenchendo a tabela com os dados
while ($row_tabela = mysqli_fetch_assoc($resultado_tabela)) {
    $html .= '
        <tr>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . $row_tabela['produto'] . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . $row_tabela['peso'] . " " . $row_tabela['unidade'] . '</td>
            <td style="padding: 12px; border: 1px solid #ddd; color: #555; text-align: center; border-bottom: 1px solid #ddd;">' . $row_tabela['quantidade'] . '</td>
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
    "relatorio_estoque.pdf",
    array(
        "Attachment" => true
    )
);
?>