<?php
session_start();

include __DIR__.'/includes/functions.php';

if(isset($_REQUEST["idC"])){
	$conexion = crearConexionBD();
	pagar_compra($conexion,$_REQUEST["idC"]);
	cerrarConexionBD($conexion);
	Header("Location: recogerPedidos.php");
}
else{Header("Location: consulta.php");}
?>