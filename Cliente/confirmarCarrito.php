<?php
session_start();
include __DIR__.'/includes/functions.php';

$conexion = crearConexionBD();

if(isset($_SESSION["carrito"])){

  $pedido = $_SESSION["carrito"];
  if(isset($_REQUEST["realizarPedido"])){

  $fechaActualF = date("Y/m/d");
  $horaActualF = date("H").":".date("i");
  $fechaHoraActual = $fechaActualF ." " .$horaActualF;
  $fechaHoraActualF = date("d/m/Y H:i", strtotime($fechaHoraActual));

  $fechaRecogidaF = date("Y/m/d", strtotime($_REQUEST["fechaRecogida"]));
  $horaRecogidaF = $_REQUEST["horaRecogida"];
  $fechaHoraRecogida = $fechaRecogidaF ." ".$horaRecogidaF;
  $fechaHoraRecogidaF = date("d/m/Y H:i", strtotime($fechaHoraRecogida));



    if($fechaHoraRecogida>$fechaHoraActual){
      $return = (int)creaCompra($conexion, $fechaHoraRecogidaF, $fechaHoraActualF, $_SESSION["login"][0] )[0];
      if($return==false){
        Header("Location: excepcion.php");
      }else{
        foreach ($pedido as $prod) {
          if($prod["nombreProducto"]=="GASOLINA" || $prod["nombreProducto"]=="GASOIL"){
            $id_i = obtieneIdICOMB($conexion, $prod["idProducto"])[0];
            creaLineaCompra($conexion, $prod["cantidadProducto"], $id_i, $return);
          }else{
           $id_i = obtieneIdI($conexion, $prod["idProducto"])[0];
           creaLineaCompra($conexion, $prod["cantidadProducto"], $id_i, $return);
         }
        }
        header("Location: index.php");
          unset($_SESSION["carrito"]);
      }
    }else{
      Header("Location: excepcion.php");
      $_SESSION["excepcion"]="La fecha/hora de recogida del pedido no puede ser anterior o igual a la actual";
    }
    cerrarConexionBD($conexion);
  }else{
    cerrarConexionBD($conexion);
    header("Location: carrito.php");
  }
}else{
  cerrarConexionBD($conexion);
  header("Location: carrito.php");
}
?>
