<?php
session_start();

include __DIR__.'/includes/functions.php';

if(isset($_REQUEST["IdProducto"])){
		
		$conexion = crearConexionBD();
		eliminar_Producto($conexion,$_REQUEST["IdProducto"]);
		cerrarConexionBD($conexion);
		Header("Location: categoriaFiltro.php");
	}
else{Header("Location: editarProducto.php");}
?>