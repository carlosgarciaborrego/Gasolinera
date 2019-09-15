<?php include __DIR__.'/includes/functions.php';

session_start();
$conexion = crearConexionBD();
if(isset($_REQUEST["Aceptar"])){
  $mod["nombre"] = $_REQUEST["Nombre"];
  $mod["apellidos"] = $_REQUEST["Apellidos"];
  $mod["dni"] = $_REQUEST["DNI"];
  $mod["telefono"] = $_REQUEST["Telefono"];
  $mod["email"] = $_REQUEST["email"];


  $usuario = $_SESSION["login"];
  var_dump($mod);
  var_dump($usuario);die;

  editar_cliente($conexion, $usuario["ID_C"], $mod["nombre"], $mod["apellidos"], $mod["dni"], $mod["telefono"], $mod["email"], $usuario["FECHANACIMIENTO"],$usuario["CONTRASENA"],"",$usuario["TOKEN"]);
  header("Location: miCuentaMisDatos.php");

}else{
  header("Location: miCuentaMisDatos.php");

}
?>
