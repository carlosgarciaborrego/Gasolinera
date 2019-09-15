<?php


/*if(isset($_POST["dni"]) && isset($_POST["contrasena"])){
  $dni = $_POST["dni"];
  $contrasena = $_POST["contrasena"];

  $conexion = crearConexionBD();

  $empleado = consultarEmpleado($conexion,$dni,$contrasena);

  cerrarConexionBD($conexion);

  if($empleado){
    $_SESSION["empleado"] = $empleado;

  }else{
    header("Location: ./../Cliente/index.php");
  }
}else{

  var_dump("No entro en el if");
  var_dump($_POST["dni"]);
  var_dump($_POST["contrasena"]);
  //  header("Location: ./../Cliente/index.php");
}*/



if($_SESSION["empleado"][2]=="" || $_SESSION["empleado"][3]==""){
  header("Location: ./../Cliente/index.php");
}else{
  $dni = $_SESSION["empleado"][2];
  $contrasena = $_SESSION["empleado"][3];

  $conexion = crearConexionBD();
  $empleado = consultarEmpleado($conexion,$dni,$contrasena);
  cerrarConexionBD($conexion);

  if($empleado){
    $_SESSION["empleado"] = $empleado;

  }else{
    header("Location: ./../Cliente/index.php");
  }

}

if(isset($_POST["logout"])){
  session_destroy();
  header("Location: ./../Cliente/index.php");
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

  <?php //   if(isset($_SESSION["login"])){
          //   if($_SESSION["login"]){  ?>
               <i class="fa fa-user" aria-hidden="true"></i>
               <p><?php echo $_SESSION["empleado"][0] ?></p>
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                 <input type="hidden" name="logout" value="logout">
                 <input type="submit" value="Cerrar Sesión">
               </form>
             <?php //}
            // } ?>
            </div>

          </div>
        </div>
      </div>
  </nav>
</header>
