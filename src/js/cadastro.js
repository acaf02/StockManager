$(document).ready(function () {
  $("#seuFormulario").on("submit", function (e) {
    e.preventDefault(); // Evita que o formulário seja enviado normalmente

    // Cria um objeto FormData com os dados do formulário
    var formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "cadastro.php",
      data: formData,
      processData: false, 
      contentType: false, 
      dataType: "json",
      success: function (response) {
        if (response.success) {
          alert(response.message);
          window.location.href = "../estoque/estoque.php";
        } else {
          alert("Erro: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        alert("Ocorreu um erro: " + error);
      },
    });
  });
});