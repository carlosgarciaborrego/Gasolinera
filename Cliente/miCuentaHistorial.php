<?php
session_start();
include __DIR__.'/includes/functions.php';
require_once("controladorPedidos.php");


	if(isset($_SESSION["login"])){
		$nuevoUsuario = $_SESSION["login"];
		$pedido = $_SESSION["login"];
	}else{
		Header("Location: registrarse.php");
	}

	if(!isset($_SESSION['idCompra'])){
	   $idCompra = "";
  		$_SESSION['idCompra'] = $idCompra;
  }else{
  	$idCompra = $_SESSION['idCompra'];
  }

	$conexion=crearConexionBD();
	$consultaPedidoCliente=consultarPedidosHistorial($conexion,$nuevoUsuario["ID_C"]);
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
			foreach ($consultaPedidoCliente as $pedido) {
				$numero = $numero + 1;
			$result =	getInfoCompra($conexion,$pedido["ID_COM"]);
			$subTotal = 0;
			foreach ($result as $infoP) {
				$subTotal = $subTotal + $infoP["CANTIDAD"]*str_replace(",",".",$infoP["PRECIO"]);
			}?>

				<form method="post" action="consulta.php">


						 	<input id="ID_COM" name="idCompra" type="text" style="display: NONE" value="<?php echo $pedido["ID_COM"];?>"/>


							<tr>
								<td><?php echo $pedido["ID_COM"]; ?></td>
								<td><?php echo $pedido["FECHARECOGIDA"]; ?></td>
								<td><?php echo $pedido["FECHAPEDIDO"]; ?></td>
								<td><button id="consulta<?php echo $numero ?>" name="consulta" type="submit" class="consulta">Consultar</button></td>
								<td> <?php echo $subTotal; ?></td>
								<td> <?php echo 2;?></td>
							</tr>
						</form>
		<?php	} ?>

</table>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
