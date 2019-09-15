<?php
session_start();

$conexion = crearConexionBD();
$compras = getAllComprasPreparadas($conexion);
cerrarConexionBD($conexion);

if(!isset($_SESSION["pedidoSeleccionado"])){
	$pedidoSeleccionado['idCompra'] = "";
	$pedidoSeleccionado['idCliente'] = "";

  $_SESSION['pedidoSeleccionado'] = $pedidoSeleccionado;
}else $pedidoSeleccionado = $_SESSION['pedidoSeleccionado'];
?>
