$(document).ready(function() {
    $("#login").on('click', function() {
        var login_funcionario = $("#login_funcionario").val();
        var senha = $("#senha").val();

        if (login_funcionario == "" || senha == "")
            alert("Erro em login ou senha");
        else {
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    login: 1,
                    login_funcionario: login_funcionario,
                    senha: senha
                },
                success: function(response) {
                    console.log(response);
                    if (response.trim() == 'success') {
                        alert("Login bem-sucedido");
                        window.location.href = "./inicio/inicio.php"
                    } else {
                        alert("Falha no login. Verifique seu nome de usuário e senha.");
                    }
                },
                dataType: 'text'
            })

        }

    });
});