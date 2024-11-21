$(document).ready(function () {
  // Função de login
  function realizarLogin() {
    var username = $("#username").val();
    var password = $("#password").val();

    if (username === "" || password === "") {
      alert("Erro em login ou senha");
    } else {
      $.ajax({
        url: "index.php",
        type: "POST",
        data: {
          login: 1,
          username: username,
          password: password,
        },
        success: function (response) {
          response = response.trim();
          if (response === "success") {
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
  }

  // Evento de clique no botão de login
  $("#login").on("click", function () {
    realizarLogin();
  });

  // Evento para capturar a tecla Enter e acionar o login
  $(document).on("keypress", function (e) {
    if (e.which === 13) {
      // Código 13 corresponde à tecla Enter
      realizarLogin();
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
