<?php
// Conexão com o banco de dados
include $_SERVER['DOCUMENT_ROOT'] . "/SM/src/db/db_connection.php";

// Consultar os insumos mais consumidos
$query_more = "
    SELECT produto, total_consumido 
    FROM insumo 
    ORDER BY total_consumido DESC
    LIMIT 10
";
$result_more = $connection->query($query_more);

// Consultar os insumos menos consumidos
$query_less = "
    SELECT produto, total_consumido 
    FROM insumo 
    ORDER BY total_consumido ASC
    LIMIT 10
";
$result_less = $connection->query($query_less);

// Preparar os dados para os gráficos
$data_more = [];
$data_less = [];

while ($row = $result_more->fetch_assoc()) {
    $data_more[] = [$row['produto'], (int) $row['total_consumido']];
}

while ($row = $result_less->fetch_assoc()) {
    $data_less[] = [$row['produto'], (int) $row['total_consumido']];
}

// Fechar a conexão com o banco de dados
$connection->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Estatísticas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <style>
        html body {
            background: #eeeeee;
            font-family: Arial, sans-serif;
        }

        h1 {
            padding-top: 30px; /* Espaço entre o header e o título */
            font-size: 1.8rem; /* Redução no tamanho da fonte do título */
        }
    </style>
</head>

<body>
    <?php
    include_once('../../componentes/header.php');
    ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Relatório de Estatísticas</h1>

        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-center">Mais Consumidos</h3>
                <div id="chart_more" class="border rounded p-3"></div>
            </div>
            <div class="col-lg-6">
                <h3 class="text-center">Menos Consumidos</h3>
                <div id="chart_less" class="border rounded p-3"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Carregar a biblioteca de gráficos do Google
        google.charts.load('current', { packages: ['corechart'] });

        // Dados PHP para JavaScript
        const dataMore = <?php echo json_encode($data_more); ?>;
        const dataLess = <?php echo json_encode($data_less); ?>;

        // Renderizar os gráficos
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawChart(dataMore, 'chart_more', 'Insumos Mais Consumidos');
            drawChart(dataLess, 'chart_less', 'Insumos Menos Consumidos');
        }

        function drawChart(dataArray, elementId, title) {
            const data = new google.visualization.DataTable();
            data.addColumn('string', 'Produto');
            data.addColumn('number', 'Total Consumido');
            data.addRows(dataArray);

            const options = {
                title: title,
                width: '100%',
                height: 400,
                bar: { groupWidth: '75%' },
                legend: { position: 'none' },
                hAxis: { title: 'Produto' },
                vAxis: { title: 'Quantidade Consumida' }
            };

            const chart = new google.visualization.ColumnChart(document.getElementById(elementId));
            chart.draw(data, options);
        }
    </script>
</body>

</html>
