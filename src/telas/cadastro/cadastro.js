$.ajax({
    type: 'POST',
    url: 'cadastro.php', // URL onde os dados serão enviados
    data: formData,
    dataType: 'json', // Esperamos uma resposta JSON
    success: function(response) {
        if (response.success) {
            alert(response.message);
            window.location.href = '../estoque/estoque.php';
        } else {
            alert('Erro: ' + response.message);
        }
    },
    error: function(xhr, status, error) {
        alert('Ocorreu um erro: ' + error);
    }
});
