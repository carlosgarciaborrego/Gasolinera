<?php
session_start();
 include __DIR__.'/includes/functions.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>ModificarContraseña</title>
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

          <!-- ModificarContraseña -->
          <fieldset class="registrarse">
          <label>Antigua Contraseña:</label>
            <input name = "ContrasenaAntigua"
                   type = "password"
                   size = "20"
                   maxlength = "20"
                   title = "ContrasenaAntigua"
                   required />
                 </br>
          <label>Nueva Contraseña:</label>
            <input name = "ContrasenaNueva"
                   type = "password"
                   size = "20"
                   maxlength = "20"
                   title = "ContrasenaNueva"
                   required/>
                  </br>
           <label>Repetir Contraseña:</label>
             <input name = "ContrasenaNueva"
                    type = "password"
                    size = "20"
                    maxlength = "20"
                    title = "ContrasenaNueva"
                    required/>
                    </br>
        </fieldset>
         <input name = "Enviar"
                type = "submit"
                value = "Enviar"
         />

         <?php
       		foreach($filas as $fila) {
       	?>

       	<article class="formulario">
       		<form method="post" action="controladorUsuarios.php">
       			<div class="fila_cliente">
       				<div class="datos_cliente">
       					<input id="CONTRASENA" name="CONTRASENA"
       						type="hidden" value="<?php echo $fila["CONTRASENA"]; ?>"/>
       					<input id="REPETIRCONTRASENA" name="REPETIRCONTRASENA"
       						type="hidden" value="<?php echo $fila["REPETIRCONTRASENA"]; ?>"/>


<?php
         if (isset($formulario) and ($formulario["IC_C"] == $fila["ID_C"])) { ?>
           <input id="CONTRASENA" name="CONTRASENA" type="password" value="<?php echo $fila["CONTRASENA"]; ?>"/>
         <?php } ?>
         <a href="miCuentaMisDatos.php" class="btn btn-special">Volver atrás</a>
         <?php } ?>
        </div>
		  </section>
    </form>
    </div>
  </article>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
