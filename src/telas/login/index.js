$(document).ready(function () {
  $("#login").on("click", function () {
    var username = $("#username").val();
    var password = $("#password").val();

    if (username === "" || password === "") {
      alert("Erro em login ou senha");
    } else {
      $.ajax({
        url: "index.php",
        method: "POST",
        data: {
          login: 1,
          username: username,
          password: password,
        },
        success: function (response) {
          response = response.trim();
          if (response === "success") {
            alert("Login bem-sucedido");
            window.location.href = "../inicio/inicio.php";
          } else {
            alert(response);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error: " + status + " - " + error);
        },
        dataType: "text",
      });
    }
  });
});



//funcção para icone de mostrar e esconder senha
const password = document.getElementById("password");
        const icone = document.getElementById("icones").children[0]; // Pega o <img> dentro do #icones

        function showHide() {
            if (password.type === "password") {
                password.setAttribute("type", "text");
                icone.src = "../../assets/imagens/hide.png"; // Muda para ícone de esconder
            } else {
                password.setAttribute("type", "password");
                icone.src = "../../assets/imagens/show.png"; // Muda para ícone de mostrar
            }
        }
