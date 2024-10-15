
$(document).ready(function () {
    $('.open-modal-adicionar').on('click', function () {
        let cod_insumo = $(this).data('cod_insumo');
        let modalAdicionarInsumo = new bootstrap.Modal(document.getElementById('modalAdicionarInsumo'));
        $('#modalAdicionarInsumo').attr('data-cod_insumo', cod_insumo);
        modalAdicionarInsumo.show();  // Mostra o modal
    });

    $('.open-modal-retirar').click(function () {
        let codInsumo = $(this).data('cod_insumo');
        let modalRetirarInsumo = new bootstrap.Modal(document.getElementById('modalRetirarInsumo'));
        $('#modalRetirarInsumo').attr('data-cod_insumo', codInsumo);
        modalRetirarInsumo.show();  // Mostra o modal
    });
});

