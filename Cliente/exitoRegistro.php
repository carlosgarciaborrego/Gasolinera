<?php session_start();

 include __DIR__.'/includes/functions.php';


 if (isset($_SESSION["formulario"])) {
 		$nuevoUsuario = $_SESSION["formulario"];
 		$_SESSION["errores"] = null;
    if($_SESSION["formulario"]{"nombre"}==""){
         header("Location: registrarse.php");
    }
 	}else{
     $nuevoUsuario = null;
     header("Location: registrarse.php");
}

$conexion = crearConexionBD();

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Alta Usuario</title>
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


          if(alta_usuario($conexion, $nuevoUsuario)){?>
              <p class="mensajeUsuario"> Bienvenido <strong><?php echo $nuevoUsuario["nombre"] . " " . $nuevoUsuario["apellidos"]?></strong>, gracias por registrate en Marina Sur.</p>

              <p class="mensajeUsuario">Los datos con los que te has registrado son los siguientes:</p>

              <ul class="altaDatos">
                <li><i>Nombre: </i> <?php echo $nuevoUsuario["nombre"]; ?></li>
                <li><i>Apellidos: </i><?php echo  $nuevoUsuario["apellidos"]; ?></li>
                <li><i>DNI: </i><?php echo $nuevoUsuario["dni"]; ?></li>
                <li><i>Fecha de Nacimiento: </i><?php echo getFechaFormateada($nuevoUsuario["fechaNacimiento"]); ?></li>
                <li><i>Teléfono: </i><?php echo $nuevoUsuario["telefono"]; ?></li>
                <li><i>Email: </i><?php echo $nuevoUsuario["email"]; ?></li>
                <li><i>Contraseña: </i><?php echo $nuevoUsuario["contrasena"]; ?></li>
              </ul>

                <p class="mensajeUsuario"> Inicia Sesión para poder comprar cualquier artículo. <br>
                  Si deseas modificar tus datos en un futuro, puedes hacerlo accediendo a Mis Datos.</p>

      <?php  }else{?>
        <?php  if(isset($_SESSION["login"])){
                 if($_SESSION["login"]){ ?>
                    <p>Gracias por registrarte con nosotros.</p>
        <?php    }
               } else{ ?>
                  <p>El usuario ya existe, compruebe de nuevo sus datos.</p>
        <?php  }
            } ?>

        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
<?php cerrarConexionBD($conexion); ?>
