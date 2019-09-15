<?php
include __DIR__.'/includes/functions.php';

$pedido = $_SESSION["pedido"];

	$conexion = crearConexionBD();
	echo $pedido["ID_COM"];
	$excepcion = borrar_pedido($conexion,$pedido["ID_COM"]);
	cerrarConexionBD($conexion);

	unset($_SESSION["pedido"]);
	
	if($excepcion<>"") {
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"] = "miCuentaActuales.php";
		Header("Location: excepcion.php");
	} else {
		borrar_pedido($conexion,$pedido["ID_COM"]);
		Header("Location: miCuentaActuales.php");
	}
?>
