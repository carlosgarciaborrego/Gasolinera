<?php

 if(isset($_POST["dni"]) && isset($_POST["contrasena"])){
   $dni = $_POST["dni"];
   $contrasena = $_POST["contrasena"];

   $conexion = crearConexionBD();

   $usuario = consultarUsuario($conexion,$dni,$contrasena);

   cerrarConexionBD($conexion);

   if(isset($_SESSION["formulario"])){
     $_SESSION["formulario"] = null;
   }

   if($usuario){
     $_SESSION["login_error"] = null;
     $_SESSION["login"] = $usuario;
      header("Location: index.php");
   }else{
     $empleado = consultarEmpleado($conexion,$dni,$contrasena);
     if($empleado){
       $_SESSION["empleado"] = $empleado;
       header("Location: ./../Empleado/index.php");
     }else{
       $_SESSION["login"] = null;
       $_SESSION["login_error"] = "Usuario o contraseña invalido";
     }
   }
 }


 if(isset($_POST["logout"])){
   session_destroy();
   header("Location: index.php");
 }

 ?>

<header id="cabecera">
  <nav class="menu-header">
      <div class="container-header">
        <div class="logoEmpresa">
          <a href="index.php"><img src="imagenes/LogoMarinaSur.jpg" alt="Logo Marina Sur" title="Logo Marina Sur"></a>
        </div>
        <div class="login col-10">
          <div class="lista-login">
            <div class="inputConIcono">
              <form action="categoriaFiltro.php" method="get" id="busquedaHeader">
                <input type="hidden" value="200"name="range">
                <input type="hidden" value="todos"name="categoria">
                <input type="search" name="producto" placeholder="Buscar...">
                <i class="fa fa-search" aria-hidden="true"></i>
              </form>
            </div>
            <div class="SesionCabecera col-6">
              <?php
              if(isset($_SESSION["login_error"])){
                if($_SESSION["login_error"]){?>
                  <div class="error">
              			<p>Usuario y/o contraseña incorrectos.</p>
              		</div>
                <?php }
              }


              if(isset($_SESSION["login"])){
                 if($_SESSION["login"]){  ?>

                       <i class="fa fa-user logueado" aria-hidden="true"></i>
                       <p><?php echo $_SESSION["login"][1] ?></p>
                       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                         <input type="hidden" name="logout" value="logout">
                         <input class="cerrar" type="submit" value="Cerrar Sesión">
                       </form>

                  <?php }
              } else{?>
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" name="dni" placeholder="Usuario">
                    <input type="password" name="contrasena" placeholder="Contraseña">
                    <a href="registrarse.php">Regístrate</a>
                    <a href="recuperarPassword.php">¿Has olvidado tu contraseña?</a>
                    <input type="submit" value="Iniciar Sesión">
                  </form>
              <?php } ?>


            </div>

      <?php if(isset($_SESSION["login"])){
               if($_SESSION["login"]){ ?>
                 <a class="bye" href="carrito.php"><i class="fas fa-shopping-cart" aria-hidden="true" alt="Carrito Compra" title="Carrito Compra"></i></a>
      <?php    }
    }else { ?>
              <a class="bye" href="https://www.google.es/maps/place/Marina+Sur/@37.2249465,-7.1736689,15z/data=!4m12!1m6!3m5!1s0x0:0xac3c4efbdfcd915e!2sMarina+Sur!8m2!3d37.2249807!4d-7.1736689!3m4!1s0x0:0xac3c4efbdfcd915e!8m2!3d37.2249807!4d-7.1736689"><i class="fas fa-street-view" aria-hidden="true" alt="Ubicación tienda" title="Ubicación"></i></a>
      <?php }  ?>

          </div>
        </div>
      </div>
  </nav>
</header>
