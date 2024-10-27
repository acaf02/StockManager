$(document).on("click", ".open-modal-editar", function (event) {
  event.preventDefault();
  let codInsumo = $(this).data("cod_insumo");

  if (codInsumo) {
      $.ajax({
          url: "modals/get_insumo_data.php",
          type: "GET",
          data: { cod_insumo: codInsumo },
          success: function (response) {
              const data = JSON.parse(response);
              if (data.status === "success") {
                  $("#cod_insumo").val(data.insumo.cod_insumo);
                  $("#estoque_min").val(data.insumo.estoque_min);
                  $("#estoque_medio").val(data.insumo.estoque_medio);

                  let modalEditarInsumo = new bootstrap.Modal(document.getElementById("modalEditar"));
                  modalEditarInsumo.show();
              } else {
                  alert("Erro ao recuperar dados do insumo: " + data.message);
              }
          },
          error: function (xhr, status, error) {
              alert("Erro na requisição Ajax: " + error);
          },
      });
  } else {
      console.log("Erro: Código do insumo não foi capturado.");
  }
});
