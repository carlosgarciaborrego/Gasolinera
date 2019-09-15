<?php session_start();

 include __DIR__.'/includes/functions.php';

 if(!isset($_SESSION['formulario'])){
    $formulario['nombre'] = "";
    $formulario['apellidos'] = "";
    $formulario['dni'] = "";
    $formulario['fechaNacimiento'] = "";
    $formulario['telefono'] = "";
    $formulario['email'] = "";
 		$_SESSION['formulario'] = $formulario;
 }else{
 	$formulario = $_SESSION['formulario'];
 }

 if(isset($_SESSION["login"])){
    if($_SESSION["login"]){
      header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Registrarse</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <div class="menu-vertical">
            <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        </div>
        <div class="menu-cuenta">
            <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
        </div>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">

          <?php
            if(isset($_SESSION['errores']) && count($_SESSION['errores'])>0){
              echo "<div id=\"div_errores\" class=\"error\">";
              echo "<h4> Errores en el formulario</h4>";
              foreach ($_SESSION['errores'] as $error) {
                echo $error;
              }
              echo "</div>";
            }
            ?>

       <!-- Registrarse -->
       <form id="altaUsuario" method="post" action="accion_alta_usuario.php" onsubmit="return validateForm() && campos();">
         <p class="info">
           <i>Es obligatorio rellenar todos los campos</i>
         </p>

          <fieldset class="registrarse">
           <legend >
             Datos personales
           </legend>
<!-- Resvisar required-->
           <!-- Controles del formulario-->
          <label for="nombre">Nombre:</label>
           <input id="nombre"
                  name = "nombre"
                  type = "text"
                  size = "30"
                  maxlength = "50"
                  title = "Nombre"
                  value="<?php echo $formulario['nombre'];?>"
                  required/>
                  <br>

          <label for="apellidos">Apellidos:</label>
           <input id="apellidos"
                  name = "apellidos"
                  type = "text"
                  size = "30"
                  maxlength = "50"
                  title = "Apellidos"
                  value="<?php echo $formulario['apellidos'];?>"
                  required/>
                  <br>

          <label for="dni">DNI:</label>
           <input id="dni"
                  name = "dni"
                  type = "text"
                  size = "9"
                  maxlength = "9"
                  title = "Ocho dígitos seguidos de una letra mayúscula"
                  value="<?php echo $formulario['dni'];?>"
                  pattern = "^[0-9]{8}[A-Z]"
                  required
                  placeholder = "12345678X"/>
                  <br>


          <label for="fechaNacimiento">Fecha Nacimiento:</label>
            <input id="fechaNacimiento"
                   name = "fechaNacimiento"
                   type = "date"
                   title = "date"
                   value="<?php echo $formulario['fechaNacimiento'];?>"
                   required
                   placeholder = "DD/MM/AAAA"/>
                   <br>

          <label for="telefono">Teléfono:</label>
            <input id="telefono"
                   name = "telefono"
                   type = "tel"
                   size = "9"
                   maxlength = "9"
                   title = "9 dígitos"
                   value="<?php echo $formulario['telefono'];?>"
                   pattern = "^[0-9]{9}"
                   required
                   placeholder = "XXX XXX XXX"/>
        </fieldset>


        <fieldset class="registrarse">
          <legend>
            Datos de usuario
          </legend>

          <!-- Controles del formulario-->
         <label for="email">Email:</label>
           <input id="email"
                  name = "email"
                  type = "email"
                  size = "20"
                  maxlength = "50"
                  title = "Email"
                  value="<?php echo $formulario['email'];?>"
                  required
                  placeholder = "usuario@compañia.dominio"/>
                  <br>

         <label for="contrasena">Contraseña:</label>
           <input id="contrasena"
                  name = "contrasena"
                  type = "password"
                  size = "20"
                  maxlength = "20"
                  title = "La contraseña tiene que ser al menos de 8 carácteres y debe contener 1 número, letra mayúscula y letra minúscula."
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  required/>
                  <br>

          <label for="confirmarContrasena">Repetir Contraseña:</label>
            <input id="confirmarContrasena"
                   name = "confirmarContrasena"
                   type = "password"
                   size = "20"
                   maxlength = "20"
                   title = "Confirmar Contraseña"
                   required/>
                 </fieldset>

          <input name = "Enviar" type = "submit" value = "Enviar"/>
        </form>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
