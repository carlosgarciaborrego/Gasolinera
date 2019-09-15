<?php
session_start();
include __DIR__.'/includes/functions.php';

$conexion = crearConexionBD();
$error = null;
$mensaje = null;
$urlLocal = null;

if(isset($_POST['email'])){
  $email = $_POST['email'];
  $result = consultarEmail($conexion,$email);
  if($result == NULL){
    $error = 'No existe ningún email asociado a esta cuenta';
  }else{
    $token = actualizarUsuario($conexion,$result['ID_C']);
    $url = $_SERVER['HTTP_HOST'] . "/iissi-17-18/2Cuatrimestre/Cliente/nuevaContrasena.php?codigo=".$token;
    //enviarEmailRecuperacion($result,$url);
    $urlLocal = "nuevaContrasena.php?codigo=".$token;
    $mensaje = true;
  }
}

 ?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Recuperar Contraseña</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php'?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">

  <?php if(isset($error)){ ?>
          <div class="error">
            <h4><?php echo $error ?></h4>
          </div>
  <?php }

    if(isset($mensaje)){ ?>
          <div class="error">
            <h4>Hemos enviado a su correo un enlace de recuperación. </h4>
            <p><a href="<?php echo $urlLocal ?>" target="_blank"><?php echo $urlLocal ?></a></p>
          </div>
  <?php } ?>

          <div class="olvidarPass">
            <h3>¿Has olvidado tu contraseña?</h3>
            <hr>
            <form action="recuperarPassword.php" method="post">
              <p>Introduce tu dirección de correo.</p>
              <input type="text" name="email" placeholder="Email">
              <hr>
              <input type="submit" value="Enviarme mensaje al correo">
            </form>
          </div>
          <strong>Recuerda que tu usuario, corresponde con tu DNI</strong>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
<?php crearConexionBD($conexion)?>
