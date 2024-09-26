$(document).ready(function() {
    $("#login").on('click', function() {
        var username = $("#username").val();
        var password = $("#password").val();

        if (username === "" || password === "") {
            alert("Erro em login ou senha");
        } else {
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    login: 1,
                    username: username,
                    password: password
                },
                success: function(response) {
                    response = response.trim();
                    if (response === 'success') {
                        alert("Login bem-sucedido");
                        window.location.href = "../inicio/inicio.php";
                    } else {
                        alert(response); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                },
                dataType: 'text'
            });
        }
    });
});