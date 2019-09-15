<?php

	if (isset($_REQUEST["ID_P"])){
		$producto["ID_P"] = $_REQUEST["ID_P"];
		$producto["DIRECCIONIMAGEN"] = $_REQUEST["DIRECCIONIMAGEN"];
		$producto["NOMBRE"] = $_REQUEST["NOMBRE"];
		$producto["CANTIDAD"] = $_REQUEST["CANTIDAD"];
    $producto["PRECIO"] = $_REQUEST["PRECIO"];

		$_SESSION["producto"] = $producto;

		Header("Location: consulta.php");
?>
