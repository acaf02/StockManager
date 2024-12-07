$("#pesquisar").on("keyup", function () {
  var pesquisa = $(this).val(); 
  $.ajax({
    url: "../../componentes/pesquisa.php", 
    method: "GET", 
    data: { palavra: pesquisa }, 
    dataType: "json",
    success: function (data) {
      var tbody = ""; 
      if (data.length > 0) {
        data.forEach(function (insumo) {

          tbody += "<tr data='" + insumo.estoque_min + "' onclick=\"window.location.href='../visualizar/visualizar.php?cod_insumo=" + insumo.cod_insumo + "'\" style='cursor: pointer;'>";

          tbody += "<td style='color: black; text-decoration: none;'>" + insumo.produto + "</td>";

          tbody += "<td>" + insumo.peso + " " + insumo.unidade + "</td>";

          var alertaIcon = "";

          if (insumo.alerta === "red") {
            alertaIcon = ' <i class="fa fa-exclamation-triangle" style="color: red; font-size:20px;"></i>';
          } else if (insumo.alerta === "orange") {
            alertaIcon = ' <i class="fa fa-exclamation-triangle" style="color: orange; font-size:20px;"></i>'; 
          }

          tbody += "<td>" + insumo.quantidade + alertaIcon + "</td>";
          tbody += "</tr>";
        });
      } else {
        tbody = '<tr><td colspan="3">Nenhum insumo encontrado</td></tr>';
      }
      $("tbody").html(tbody);
    },
    error: function () {
      alert("Erro ao buscar os insumos");
    }
  });
});
