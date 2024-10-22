$(document).on("click", ".open-modal-adicionar", function(event) {
    event.preventDefault();
    var codInsumo = $(this).data("cod_insumo");

    // Verifica se o codInsumo foi capturado corretamente
    console.log("Adicionar codInsumo:", codInsumo);

    // Atribui o codInsumo ao botão dentro do modal
    $("#modalAdicionarInsumo").find("#btnAdicionar").data("cod_insumo", codInsumo);
    $("#btnAdicionar").attr("data-cod_insumo", codInsumo);
    
    var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarInsumo"));
    myModal.show();
});

$(document).on("click", ".open-modal-retirar", function(event) {
    event.preventDefault();
    let codInsumo = $(this).data('cod_insumo');

    // Verifica se o codInsumo foi capturado corretamente
    console.log("Retirar codInsumo:", codInsumo);

    let modalRetirarInsumo = new bootstrap.Modal(document.getElementById('modalRetirarInsumo'));
    $('#modalRetirarInsumo').data('cod_insumo', codInsumo);
    
    modalRetirarInsumo.show();
});