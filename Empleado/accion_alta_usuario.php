<?php session_start();

include __DIR__.'/includes/functions.php';

if (isset($_SESSION["formulario"])) {
	$nuevoUsuario = [];
	$nuevoUsuario["nombre"] = $_REQUEST["nombre"];
	$nuevoUsuario["apellidos"] = $_REQUEST["apellidos"];
	$nuevoUsuario["dni"] = $_REQUEST["dni"];
	$nuevoUsuario["fechaNacimiento"] = $_REQUEST["fechaNacimiento"];
	$nuevoUsuario["telefono"] = $_REQUEST["telefono"];
	$nuevoUsuario["email"] = $_REQUEST["email"];
	$nuevoUsuario["contrasena"] = $_REQUEST["contrasena"];
	$nuevoUsuario["confirmarContrasena"] = $_REQUEST["confirmarContrasena"];

	$_SESSION["formulario"] = $nuevoUsuario;

	$errores = validarDatosUsuario($nuevoUsuario);

	if(count($errores)>0){
	  $_SESSION["errores"] =$errores;
		Header('Location: registrarse.php');

  }else{
			Header('Location: exitoRegistro.php');
  }
	}else{
		Header("Location: registrarse.php");
	}

 ?>
