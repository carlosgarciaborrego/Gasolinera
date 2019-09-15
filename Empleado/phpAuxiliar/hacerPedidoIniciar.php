<?php
session_start();

$conexion = crearConexionBD();
$compras = getAllComprasNoPreparadas($conexion);
cerrarConexionBD($conexion);

if(!isset($_SESSION["pedidoSeleccionado"])){
  $pedidoSeleccionado['idCliente'] = "";
  $pedidoSeleccionado['listaCompras'] = "";

  $_SESSION['pedidoSeleccionado'] = $pedidoSeleccionado;
}else $pedidoSeleccionado = $_SESSION['pedidoSeleccionado'];
?>
