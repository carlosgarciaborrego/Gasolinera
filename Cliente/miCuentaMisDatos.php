<?php
session_start();
include __DIR__.'/includes/functions.php';

	require_once("accionMiCuentaMisDatos.php");

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
   <title>MiCuentaMisDatos</title>
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

       <!-- MiCuentaMisDatos -->

       <div class = "datosCliente">
         <div class = "etiqueta"><strong>MIS DATOS</strong></div>

       	<main>
       		<ul>
       			<li><?php echo "Nombre: " . $nuevoUsuario["NOMBRE"]; ?></li>
       			<li><?php echo "Apellidos: " . $nuevoUsuario["APELLIDOS"]; ?></li>
            <li><?php echo "DNI: " . $nuevoUsuario["DNI"]; ?></li>
       			<li><?php echo "Fecha de Nacimiento: " . getFechaFormateada($nuevoUsuario["FECHANACIMIENTO"]); ?></li>
            <li><?php echo "Telefono: " . $nuevoUsuario["TELEFONO"]; ?></li>
       			<li><?php echo "E-mail: " . $nuevoUsuario["CORREO"]; ?></li>
       		</ul>

       	</main>

        </div>
        <div class = "botones">
          <a href = "miCuentaMisDatosModificar.php" class =  "btn btn-secundary">Modificar datos</a>
          <a href = "modificarContrasena.php" class =  "btn btn-primary">Modificar contraseña</a>
        </div>

		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
