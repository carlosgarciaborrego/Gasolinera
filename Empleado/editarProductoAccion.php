<?php
session_start();

include __DIR__.'/includes/functions.php';

if(isset($_REQUEST["IdProducto"],$_REQUEST["NombreProducto"],$_REQUEST["Stock"],$_REQUEST["Precio"],$_REQUEST["Categoria"],
	$_REQUEST["Codigo"],$_REQUEST["DireccionImagen"],$_REQUEST["IDProveedor"])){
		
		$conexion = crearConexionBD();
		$ids = consulta_producto($conexion,$_REQUEST["IdProducto"]);
		foreach ($ids as $id) {
			$idItem = $id["ID_I"];
		}
		modificar_itemCompra($conexion,$idItem,$_REQUEST["Stock"],$_REQUEST["Precio"],$_REQUEST["Categoria"]);
		modificar_producto($conexion,$_REQUEST["IdProducto"],$_REQUEST["NombreProducto"],$_REQUEST["Codigo"],$_REQUEST["DireccionImagen"],
			$idItem,1,$_REQUEST["IDProveedor"]);
		cerrarConexionBD($conexion);
		Header("Location: categoriaFiltro.php");
	}
else{Header("Location: editarProducto.php");}
?>