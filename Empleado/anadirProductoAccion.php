<?php
session_start();
include __DIR__.'/includes/functions.php';

if(isset($_REQUEST["NombreProducto"],$_REQUEST["Stock"],$_REQUEST["Precio"],$_REQUEST["Categoria"],
	$_REQUEST["Codigo"],$_REQUEST["DireccionImagen"],$_REQUEST["IDProveedor"])){	
		$conexion = crearConexionBD();
		insertar_itemCompra($conexion,$_REQUEST["Stock"],$_REQUEST["Precio"],$_REQUEST["Categoria"]);
		$ids = getIdItemCompra($conexion,$_REQUEST["Stock"],$_REQUEST["Precio"],$_REQUEST["Categoria"]);
		foreach ($ids as $id) {
			$idItem = $id["ID_I"];
		}
		insertar_producto($conexion,$_REQUEST["NombreProducto"],$_REQUEST["Codigo"],$_REQUEST["DireccionImagen"],
			$idItem,1,$_REQUEST["IDProveedor"]);
		cerrarConexionBD($conexion);
		Header("Location: categoriaFiltro.php");
}else{Header("Location: anadirProducto.php");}
?>