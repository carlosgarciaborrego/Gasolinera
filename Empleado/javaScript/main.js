/* Mostrar Valor de la barra de precios ---> CategoriaFiltro.php  */
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");

output.innerHTML = slider.value;
slider.oninput = function() {
  output.innerHTML = this.value;
}

/* Actualizar cantidad a litros */
function conversor(cantidad, precio){
  var z = Number.parseFloat(cantidad).toFixed(2);
  var y = Number.parseFloat(precio).toFixed(2);
  var x = z / y;
  return Number.parseFloat(x).toFixed(2);;
}

/* Anular intro en formulario -->Combustible */
function pulsar(e) {
    tecla=(document.all) ? e.keyCode : e.which;
  if(tecla==13) return false;
}
