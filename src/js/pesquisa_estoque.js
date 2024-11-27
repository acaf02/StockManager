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
                  tbody += "<tr data-min-quantity='" + insumo.estoque_min + "' onclick=\"window.location.href='../visualizar/visualizar.php?cod_insumo=" + insumo.cod_insumo + "'\" style='cursor: pointer;'>";
                  tbody += "<td style='color: black; text-decoration: none;'>" + insumo.produto + "</td>";
                  tbody += "<td>" + insumo.peso + " " + insumo.unidade + "</td>";
                  tbody += "<td>" + insumo.quantidade + "</td>";
                  tbody += "</tr>";
              });
          } else {
              tbody = '<tr><td colspan="3">Nenhum insumo encontrado</td></tr>';
          }
          $("tbody").html(tbody);
      },
      error: function () {
          alert("Erro ao buscar os insumos");
      },
  });
});
