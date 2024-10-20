$(document).on("click", ".open-modal-adicionar", function(event) {
    event.preventDefault();
    var codInsumo = $(this).data("cod_insumo");

    $("#modalAdicionarInsumo").find("#btnAdicionar").data("cod_insumo", codInsumo);
    $("#btnAdicionar").attr("data-cod_insumo", codInsumo);
    
    var myModal = new bootstrap.Modal(document.getElementById("modalAdicionarInsumo"));
    myModal.show();
});


$('.open-modal-retirar').click(function () {
 
    let codInsumo = $(this).data('cod_insumo');
    let modalRetirarInsumo = new bootstrap.Modal(document.getElementById('modalRetirarInsumo'));
    $('#modalRetirarInsumo').attr('data-cod_insumo', codInsumo);
    modalRetirarInsumo.show();  // Mostra o modal
});

$(document).ready(function () {
    $('.open-modal-editar').click(function () {
        let codInsumo = $(this).data('cod_insumo');
        let modalEditarInsumo = new bootstrap.Modal(document.getElementById('modalEditar'));  // Cria a instância do modal
        $('#modalEditar').attr('data-cod_insumo', codInsumo);  // Atribui o valor de "cod_insumo" ao modal
        modalEditarInsumo.show();  // Exibe o modal
    });
});
