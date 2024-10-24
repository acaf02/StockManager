$(document).on("click", "#btnSalvar", function (event) {
    event.preventDefault();

    // Obter os valores dos campos do modal
    var codInsumo = $("#cod_insumo").val();
    var produto = $("#produto").val();
    var peso = $("#peso").val();
    var unidade = $("#unidade").val();
    var quantidade = $("#quantidade").val();
    var estoqueMin = $("#estoque_min").val();
    var estoqueMedio = $("#estoque_medio").val();

    // Validação dos campos
    if (!produto || !peso || !unidade || !quantidade || !estoqueMin || !estoqueMedio) {
        alert("Por favor, preencha todos os campos com valores válidos.");
        return;
    }

    $("#btnSalvar").prop('disabled', true);

    $.ajax({
        url: 'modals/editar.php', 
        type: 'POST',
        data: {
            cod_insumo: codInsumo,
            produto: produto,
            peso: peso,
            unidade: unidade,
            quantidade: quantidade,
            estoque_min: estoqueMin,
            estoque_medio: estoqueMedio
        },
        success: function (response) {
            console.log("Resposta do servidor:", response);
            try {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert("Erro: " + data.message);
                }
            } catch (e) {
                console.error("Erro ao parsear JSON:", e);
                alert("Erro inesperado: " + response);
            }
        },
        error: function (xhr, status, error) {
            console.error("Response:", xhr.responseText);
            alert("Erro ao enviar o formulário: " + error);
        },
        complete: function () {
            $("#btnSalvar").prop('disabled', false);
        }
    });
});