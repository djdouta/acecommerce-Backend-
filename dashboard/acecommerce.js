function mayorista(checkbox) {
  var checkboxes = document.getElementsByName("mayorista");
  checkboxes.forEach(item => {
    if (item !== checkbox) item.checked = false;
  });
  cambiarValor(checkboxes, "mayorista");
}

function minorista(checkbox) {
  var checkboxes = document.getElementsByName("minorista");
  checkboxes.forEach(item => {
    if (item !== checkbox) item.checked = false;
  });
  cambiarValor(checkboxes, "minorista");
}

function noInicialiados(checkbox) {
  var checkboxes = document.getElementsByName("noInicialiados");
  checkboxes.forEach(item => {
    if (item !== checkbox) item.checked = false;
  });
  cambiarValor(checkboxes, "noInicialiados");
}

function cambiarValor(checkboxes, tipo) {
  checkboxes.forEach(item => {
    if (item.checked == true) {
      var parametros = {
        precio: item.value,
        tipo: tipo
      };
      jQuery.ajax({
        data: parametros,
        url: `../wp-content/plugins/acecommerce/dashboard/cambiarPrecios.php`,
        type: "post",
        success: function(response) {
          alert(response);
        }
      });
    }
  });
}
