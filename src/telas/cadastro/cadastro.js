$.ajax({
    type: 'POST',
    url: 'cadastro.php',
    data: formData,
    dataType: 'json', 
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
