<?php
session_start();

include __DIR__.'/includes/functions.php';

$conexion = crearConexionBD();

if(!isset($_GET["codigo"])){
  header("Location : index.php");
}

$usuario = buscarClientePorToken ($conexion, $_GET["codigo"]);

if(!$usuario){
  header("Location : index.php");
}

if(isset($_POST["contrasena"]) && isset($_POST["confirmarContrasena"])){
  if($_POST["contrasena"] == $_POST["confirmarContrasena"]){
    $actualizacion = actualizarContrasena ($conexion, $_POST["contrasena"],$usuario);
  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Nueva Contraseña</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">
          <?php
          if(isset($actualizacion)){ ?>
            <div class="mensajeUsuario">
              <p> Felicidades <?php echo $usuario["NOMBRE"] ?> su contraseña ha sido cambiada satisfactoriamente, puede iniciar sesión. </p>
            </div>
          <?php }else{ ?>
            <div class="mensajeUsuario">
              <p> Hola <?php echo $usuario["NOMBRE"] ?> , introduce una nueva contraseña. </p>
            </div>
            <div>
              <?php  $action = "nuevaContrasena.php?codigo=" . $_GET["codigo"] ?>
              <form action="<?php echo $action ?>" method="post">
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

                  <button type="submit">Enviar</button>
                </form>
            </div>

      <?php } ?>

        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
<?php crearConexionBD($conexion) ?>
