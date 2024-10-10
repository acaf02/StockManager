$(document).on('click', '.open-modal-adicionar', function () {
    let cod_insumo = $(this).data('cod_insumo'); 
    $('#modalAdicionarInsumo').data('cod_insumo', cod_insumo); 
    $('#modalAdicionarInsumo').modal('show'); 
});

$(document).on('click', '.open-modal-retirar', function () {
    let cod_insumo = $(this).data('cod_insumo'); 
    $('#modalRetirarInsumo').data('cod_insumo', cod_insumo); 
    $('#modalRetirarInsumo').modal('show'); 
});

// Função para salvar a quantidade ao adicionar insumo
function adicionar() {
    let quantidade = $('#adicionaInsumo').val();
    let cod_insumo = $('#modalAdicionarInsumo').data('cod_insumo');

    if (!quantidade || !cod_insumo) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Envia os dados via AJAX
    $.ajax({
        url: 'gerenciar.php',
        method: 'POST',
        data: {
            quantidade: quantidade,
            cod_insumo: cod_insumo
        },
        success: function (response) {
            let resposta = JSON.parse(response);

            if (resposta.status === 'success') {
                alert('Quantidade Atualizada!');
                location.reload(); 
            } else {
                alert('Erro: ' + resposta.message); 
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição:', error); 
        }
    });
}

// Função para salvar a quantidade ao retirar insumo
function retirar() {
    let quantidade = $('#retireInsumo').val(); 
    let cod_insumo = $('#modalRetirarInsumo').data('cod_insumo'); 

    if (!quantidade || !cod_insumo) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Envia os dados via AJAX
    $.ajax({
        url: 'gerenciar.php',
        method: 'POST',
        data: {
            quantidade: quantidade,
            cod_insumo: cod_insumo
        },
        success: function (response) {
            let resposta = JSON.parse(response); 

            if (resposta.status === 'success') {
                alert('Quantidade Atualizada!');
                location.reload(); 
            } else {
                alert('Erro: ' + resposta.message); 
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição:', error); 
        }
    });
}
