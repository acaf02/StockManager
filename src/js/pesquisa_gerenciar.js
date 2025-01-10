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
          var alertaIcon = "";
          if (insumo.alerta === "red") {
            alertaIcon = ' <i class="fa fa-exclamation-triangle" style="color: red; font-size:20px;"></i>';
          } else if (insumo.alerta === "orange") {
            alertaIcon = ' <i class="fa fa-exclamation-triangle" style="color: orange; font-size:20px;"></i>'; 
          }

          tbody += "<tr>";
          tbody += "<td style='color: black;'>" + insumo.produto + "</td>";
          tbody += "<td>" + insumo.peso + " " + insumo.unidade + "</td>";
          tbody += "<td>" + insumo.quantidade + alertaIcon + "</td>";
          

          // Botões de ações
          tbody += '<td><a href="javascript:void(0)" class="open-modal-adicionar" data-cod_insumo="' +
            insumo.cod_insumo +
            '"><i class="fa-regular fa-square-plus" style="color: green; font-size:20px;"></i></a></td>';
          
          tbody += '<td><a href="javascript:void(0)" class="open-modal-retirar" data-cod_insumo="' +
            insumo.cod_insumo +
            '"><i class="fa-regular fa-square-minus" style="color: red; font-size:20px;"></i></a></td>';
            
          tbody += '<td><a href="javascript:void(0)" class="open-modal-editar" data-cod_insumo="' +
            insumo.cod_insumo +
            '"><i class="fa-regular fa-pen-to-square" style="font-size:20px;"></i></a></td>';

          tbody += "</tr>";
        });
      } else {
        tbody = '<tr><td colspan="6">Nenhum insumo encontrado</td></tr>';
      }
      $("tbody").html(tbody);
    },
    error: function () {
      alert("Erro ao buscar os insumos");
    },
  });
});
