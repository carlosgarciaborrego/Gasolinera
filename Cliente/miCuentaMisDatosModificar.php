<?php
session_start();
include __DIR__.'/includes/functions.php';

	require_once("accionMiCuentaMisDatos.php");


	if (!isset($_SESSION['formulario'])) {
		$formulario['nombre'] = "";
		$formulario['apellidos'] = "";
		$formulario['dni'] = "dni";
		$formulario['fechaNacimiento'] = "";
		$formulario['telefono'] = "";
		$formulario['email'] = "";

		$_SESSION['formulario'] = $formulario;
	}
	else
		$nuevoUsuario = $_SESSION["login"];

		if(isset($_SESSION["login"])){
			$nuevoUsuario = $_SESSION["login"];
		}else{
			Header("Location: registrarse.php");
		}


	?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>MiCuentaMisDatosModificar</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu">
        <div class="menu-vertical">
            <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        </div>
        <div class="menu-cuenta">
            <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
        </div>
      </nav>
      <section  class="section">
        <div class="cuerpo">

       <!-- MiCuentaMisDatosModificar -->
		<form id="modificarUsuario" method="post" action="modificacion.php">
         <!-- Controles del formulario-->
        <label>Nombre:</label>
         <input name = "Nombre" type = "text" size = "30" maxlength = "40" title = "Nombre"
				 				value="<?php echo $nuevoUsuario["NOMBRE"];?>" required/>
                <br>

        <label>Apellidos:</label>
         <input name = "Apellidos" type = "text" size = "30" maxlength = "60" title = "Apellidos"
				 				value="<?php echo $nuevoUsuario["APELLIDOS"];?>"required/>
                <br>

        <label>DNI:</label>
         <input name = "DNI" type = "text" size = "9" maxlength = "9" title = "Ocho dígitos seguidos de una letra mayúscula" required
				  			value="<?php echo $nuevoUsuario["DNI"];?>" pattern = "^[0-9]{8}[A-Z]" placeholder = "12345678X"/>
                <br>


        <label>Teléfono:</label>
          <input name = "Telefono" type = "tel" size = "9" maxlength = "9" title = "Teléfono" required placeholder = "XXX XXX XXX"
								value="<?php echo $nuevoUsuario["TELEFONO"];?>"/>
                 <br>

         <label>Email:</label>
           <input name = "email" type = "email" size = "20" maxlength = "40" title = "Email" required placeholder = "usuario@compañia.dominio"
					 		  	value="<?php echo $nuevoUsuario["CORREO"];?>"/>

</br></br>

        <input name="Aceptar" type="submit" value="Aceptar"/>
        <a href="miCuentaMisDatos.php" class="btn btn-special">Volver atrás</a>

			</form>


        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
