$(document).on("click", ".open-modal-editar", function(event) {
    event.preventDefault();
    let codInsumo = $(this).data('cod-insumo');
    
    // Verifica se o codInsumo foi capturado corretamente
    console.log("Editar codInsumo:", codInsumo);

    if (codInsumo) {
        // Faz uma requisição Ajax para buscar os dados do insumo
        $.ajax({
            url: 'modals/get_insumo_data.php',  // Um arquivo PHP que retorna os dados do insumo
            type: 'GET',
            data: { cod_insumo: codInsumo },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    // Log os dados que estão sendo preenchidos
                    console.log("Dados do insumo:", data.insumo);
            
                    $("#cod_insumo").val(data.insumo.cod_insumo);
                    $("#produto").val(data.insumo.produto);
                    $("#peso").val(data.insumo.peso);
                    $("#unidade").val(data.insumo.unidade);
                    $("#quantidade").val(data.insumo.quantidade);  // Verifique se este valor é correto
                    $("#estoque_min").val(data.insumo.estoque_min);
                    $("#estoque_medio").val(data.insumo.estoque_medio);
            
                    let modalEditarInsumo = new bootstrap.Modal(document.getElementById('modalEditar'));
                    modalEditarInsumo.show();
                } else {
                    alert("Erro ao recuperar dados do insumo: " + data.message);
                }
                    
            },
            error: function(xhr, status, error) {
                alert("Erro na requisição Ajax: " + error);
            }
        });
    } else {
        console.log("Erro: Código do insumo não foi capturado.");
    }
});
