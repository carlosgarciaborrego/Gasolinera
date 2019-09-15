<?php
    session_start();
    include __DIR__.'/includes/functions.php';
    $conexion = crearConexionBD();


	if(isset($_REQUEST["idItem"],$_REQUEST["nuevoStock"])){
		cambiar_stock($conexion,$_REQUEST["idItem"],$_REQUEST["nuevoStock"]);
    cerrarConexionBD($conexion);
    header("Location: combustibles.php?tipo=gasolina");
	}else{
		header("Location: combustibles.php?tipo=gasolina");
	}


?>
