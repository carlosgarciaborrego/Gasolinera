<?php
session_start();

include __DIR__.'/includes/functions.php';

if(isset($_REQUEST["idC"])){
	$conexion = crearConexionBD();
	preparar_compra($conexion,$_REQUEST["idC"]);
	cerrarConexionBD($conexion);
	Header("Location: hacerPedidos.php");
}
else{Header("Location: prepararlo.php");}
?>