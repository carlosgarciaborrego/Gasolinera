<?php
session_start();
include __DIR__.'/includes/functions.php';

	if(isset($_SESSION["login"])){
		$nuevoUsuario = $_SESSION["login"];
		//$pedido = $_SESSION["login"];
		if(isset($_SESSION["pedido"])){
			$pedido = $_SESSION["pedido"];
		}
	}else{
				Header("Location: registrarse.php");
	}

		$conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Pedidos actuales</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu">
        <div class="menu-vertical">
            <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        </div>
        <div class="menu-cuenta">
            <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
        </div>
      </nav>
      <section  class="section">
        <div class="cuerpo">

					<!-- MiCuentaActuales -->

					<table class="pedido">
					<tr><th>ID_COM</th><th>FECHARECOGIDA</th><th>FECHAPEDIDO</th><th>CONSULTA</th><th>PRECIO</th><th>ELIMINAR</th></tr>


			<?php
			$numero = 0;
			$filas = consultarPedidosActuales($conexion,$nuevoUsuario["ID_C"]);
			foreach ($filas as $pedido) {
			$numero = $numero + 1;
			$result =	getInfoCompra($conexion,$pedido["ID_COM"]);
			$subTotal = 0;
		foreach ($result as $infoP) {
				$subTotal = $subTotal + $infoP["CANTIDAD"]*str_replace(",",".",$infoP["PRECIO"]);
		}?>
						<form method="post" action="consulta.php">

						 	<input id="ID_COM" name="ID_COM" type="hidden" value="<?php echo $pedido["ID_COM"];?>"/>
							<input id="FECHAPEDIDO" name="FECHAPEDIDO" type="hidden" value="<?php echo $pedido["FECHAPEDIDO"];?>"/>
							<input id="FECHARECOGIDA" name="FECHARECOGIDA" type="hidden" value="<?php echo $pedido["FECHARECOGIDA"];?>"/>
							<input id="PAGADO" name="PAGADO" type="hidden" value="<?php echo $pedido["PAGADO"];?>"/>
							<input id="PREPARADO" name="PREPARADO" type="hidden" value="<?php echo $pedido["PREPARADO"];?>"/>
							<input id="ID_C" name="ID_C" type="hidden" value="<?php echo $pedido["ID_C"];?>"/>
							<input id="ID_T" name="ID_T" type="hidden" value="<?php echo $pedido["ID_T"];?>"/>
							<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $pedido["CANTIDAD"];?>"/>
							<input id="PRECIO" name="PRECIO" type="hidden" value="<?php echo $pedido["PRECIO"];?>"/>


							<tr>
								<td><?php echo $pedido["ID_COM"]; ?></td>
								<td><?php echo $pedido["FECHARECOGIDA"]; ?></td>
								<td><?php echo $pedido["FECHAPEDIDO"]; ?></td>
								<td><button id="consulta<?php echo $numero ?>" name="consulta" type="submit" class="consulta">Consultar</button></td>
								<td> <?php echo $subTotal; ?></td>
								<td><button id="eliminar" name="eliminar" type="submit" class="eliminar">Eliminar</button></td>
							</tr>
						</form>
		<?php	}
		cerrarConexionBD($conexion);?>

</table>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
