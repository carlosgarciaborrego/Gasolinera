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

/* Validación de contraseña en el formulario de registro.php*/
function validateForm() {

  var error1 = passwordValidation();

  var error2 = passwordConfirmation();

  return (error1.length==0) && (error2.length==0);
}

/* Comprobar la restricciones del password */
function passwordValidation(){
  var password = document.getElementById("contrasena");
  var pwd = password.value;
  var valid = true;

  valid = valid && (pwd.length>=8);

  var hasNumber = /\d/;
  var hasUpperCases = /[A-Z]/;
  var hasLowerCases = /[a-z]/;
  valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd)) && (hasLowerCases.test(pwd));

  if(!valid){
    var error = "¡Por favor, introduzca una contraseña válida! La contraseña debe ser superior a 7, y debe contener al menos una letra mayúscula, minúscula y un dígito";
  }else{
    var error = "";
  }
        password.setCustomValidity(error);
  return error;
}

function passwordConfirmation(){
  var password = document.getElementById("contrasena");
  var pwd = password.value;
  var passconfirm = document.getElementById("confirmarContrasena");
  var confirmation = passconfirm.value;

  if (pwd != confirmation) {
    var error = "¡Las contraseñas no coinciden!";
  }else{
    var error = "";
  }

  passconfirm.setCustomValidity(error);

  return error;
}

function campos(){
  var nombre, apellidos, dni, fechaNacimiento, telefono, email, expresionEmail, expresionDNI,expresionTelefono;

  nombre = document.getElementById("nombre").value;
  apellidos = document.getElementById("apellidos").value;
  dni = document.getElementById("dni").value;
  fechaNacimiento = document.getElementById("fechaNacimiento").value;
  telefono = document.getElementById("telefono").value;
  email = document.getElementById("email").value;

  expresionEmail = /\w+@\w+\.+[a-z]/;
  expresionDNI = /^\d{8}[a-zA-Z]$/;
  expresionTelefono = /^\d{9}$/;

 if(nombre === "" || apellidos === "" || dni === "" || fechaNacimiento === "" || telefono === "" || email === ""){
   alert("Todos los campos son obligatorios");
   return false;
 }
 else if(nombre.length>50){
   alert("El nombre es muy largo");
   return false;
 }
 else if(apellidos.length>50){
   alert("El apellido es muy largo");
   return false;
 }
 else if(expresionDNI.test(dni)){
   var n = dni.substr(0,8);
   var c = dni.substr(8,1);
   n = n%23;
   var le = 'TRWAGMYFPDXBNJZSQVHLCKET';
   le = le.substring(n,n+1);
   if(le != c.toUpperCase()){
     alert("La letra del DNI es errónea");
     return false;
   }
 }
else if(dni.length != 9){
  alert("El tamaño del dni es incorrecto");
  return false;
}
 else if(expresionTelefono.test(telefono)){
   alert("El teléfono debe contener 9 dígitos");
   return false;
 }
 else if(isNaN(telefono)){
   alert("El teléfono solo puede contener números");
   return false;
 }
 else if(email.length>60){
   alert("El email es muy largo");
   return false;
 }
 else if(!expresionEmail.test(email)){
   alert("El email no es válido");
   return false;
 }
}


/* Funciones para el carrito de la compra*/
 function editCart(numero){
   var campo_cantidad = document.getElementById("cantidadProducto" +numero);
   var boton_editar = document.getElementById("edit" +numero);
   var boton_confirmarEdicion = document.getElementById("continue" +numero);
   var boton_cancelarEdicion = document.getElementById("cancel" +numero);
   var cantidad_actual = document.getElementById("cantidadActual" +numero);

   campo_cantidad.style.display = "block";
   boton_editar.style.display = "none";
   boton_confirmarEdicion.style.display = "block";
   boton_cancelarEdicion.style.display ="block";
   cantidad_actual.style.display="none";
 }

 function cancelEdit(numero){
   var campo_cantidad = document.getElementById("cantidadProducto" +numero);
   var boton_editar = document.getElementById("edit"+numero);
   var boton_confirmarEdicion = document.getElementById("continue"+numero);
   var boton_cancelarEdicion = document.getElementById("cancel"+numero);
   var cantidad_actual = document.getElementById("cantidadActual"+numero);
   var subtotal_nuevo = document.getElementById("mod"+numero);

   campo_cantidad.style.display = "none";
   boton_editar.style.display = "block";
   boton_confirmarEdicion.style.display = "none";
   boton_cancelarEdicion.style.display ="none";
   cantidad_actual.style.display="block";
   subtotal_nuevo.innerHTML="";

 }

  function modification(numero){
   var precio = document.getElementById("precioProducto"+numero).value;
   var cantidad = document.getElementById("cantidadProducto"+numero).value;
   var subtotal_nuevo = precio * cantidad;
   document.getElementById("mod"+numero).innerHTML=subtotal_nuevo.toFixed(2) +"€";
  }
