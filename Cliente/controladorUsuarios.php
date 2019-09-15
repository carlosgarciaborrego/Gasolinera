<?php


	if (isset($_REQUEST["ID_C"])) {
		$nuevoUsuario = [];
		$nuevoUsuario["NOMBRE"] = $_REQUEST["NOMBRE"];
		$nuevoUsuario["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$nuevoUsuario["DNI"] = $_REQUEST["DNI"];
		$nuevoUsuario["FECHANACIMIENTO"] = $_REQUEST["FECHANACIMIENTO"];
		$nuevoUsuario["TELEFONO"] = $_REQUEST["TELEFONO"];
		$nuevoUsuario["EMAIL"] = $_REQUEST["EMAIL"];
		$nuevoUsuario["CONTRASENA"] = $_REQUEST["CONTRASENA"];

		$_SESSION['login'] = $nuevoUsuario;

		if(isset($_REQUEST["editar"])){
			Header("Location: miCuentaMisDatosModificar.php");
		}else if(isset($_REQUEST["grabar"])){
			Header("Location: miCuentaMisDatos.php");
		}else{
			header("Location: miCuentaMisDatos.php");
		}
	}


?>
