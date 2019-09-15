<?php

	require_once("controladorUsuarios.php");

	if (isset($_SESSION['formulario'])) {
		$nuevoUsuario = $_SESSION['formulario'];
		unset($_SESSION['formulario']);

		$conexion = crearConexionBD();
		$excepcion = editar_cliente($conexion,$nuevoUsuario["ID_C"],$nuevoUsuario["NOMBRE"],$nuevoUsuario["APELLIDOS"],$nuevoUsuario["DNI"],$nuevoUsuario["TELEFONO"],$nuevoUsuario["EMAIL"],$nuevoUsuario["FECHANACIMIENTO"],$nuevoUsuario["CONTRASENA"],$nuevoUsuario["DIRECCIONIMAGEN"],$nuevoUsuario["TOKEN"]);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "miCuentaMisDatosModificar.php";
			Header("Location: excepcion.php");
		}
}
?>
