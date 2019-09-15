<?php include __DIR__.'/includes/functions.php' ?>
<?php
session_start();

  if(isset($_REQUEST["idCompra"],$_REQUEST["idCliente"])){

	$conexion = crearConexionBD();
	$clientes = consulta_cliente($conexion,$_REQUEST["idCliente"]);
	$infoCompra = getInfoCompra($conexion,$_REQUEST["idCompra"]);
	$compraAUX = consulta_compra($conexion,$_REQUEST["idCompra"]);
	cerrarConexionBD($conexion);

	foreach ($compraAUX as $c){
		$idCompra = $c["ID_COM"];
		$fechaRecogida = $c["FECHARECOGIDA"];
		$estadoPedido = $c["PAGADO"]." Pagado";
	}
	$sumaTotal = 0.0;
	foreach ($clientes as $c) {
		$cliente = $c;
	}

  } else {
  Header("Location: hacerPedidos.php");
  }
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Realizarlo</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <div class="menu-vertical">
            <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        </div>
        <div class="menu-cuenta">
            <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
        </div>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">
			<?php
			   echo "<div class='fechas'>
			            <h4> Fecha de Recogida </h4>
			            <p class='horaPedido'>".$fechaRecogida."</p>
			          </div>
			          <div class='datosCliente'>
			            <div class='etiqueta'><strong>DATOS DEL CLIENTE</strong></div>
			            <table>
			                <tr>
			                  <td><strong>Nombre:</strong></td>
			                  <td class='nombreCliente'>".$cliente["NOMBRE"]."</td>
			                </tr>
			                <tr>
			                  <td><strong>Apellidos:</strong></td>
			                  <td class='apellidosCliente'>".$cliente["APELLIDOS"]."</td>
			                </tr>
			                <tr>
			                  <td><strong>DNI:</strong></td>
			                  <td class='dniCliente'>".$cliente["DNI"]."</td>
			                </tr>
			                <tr>
			                  <td><strong>Teléfono:</strong></td>
			                  <td class='telefonoCliente'>".$cliente["TELEFONO"]."</td>
			                </tr>
			                <tr>
			                  <td><strong>Correo:</strong></td>
			                  <td class='emailCliente'>".$cliente["CORREO"]."</td>
			                </tr>
			            </table>
			          </div>
			          <div class='listaProductos'>
			            <strong>Productos</strong>
			            <table class='tablaPedidos'>
			              <tr>
			                <th>Foto</th>
			                <th>Nombre</th>
			                <th>Código</th>
			                <th>Cantidad</th>
			                <th>Precio</th>
			              </tr>";
			              foreach ($infoCompra as $p) {
			              	if(str_replace(",",".",$p["PRECIO"]) < 1) $cero = "0";
							else $cero = "";
							$sumaTotal = $sumaTotal + str_replace(",",".",$p["PRECIO"])* $p["CANTIDAD"];
			                  echo "<tr>
			                <td><img src=".$p["DIRECCIONIMAGEN"]." alt='Imagen' height='100' width='100'></td>
			                <td>".$p["NOMBRE"]."</td>
			                <td>".$p["CODIGO"]."</td>
			                <td>".$p["CANTIDAD"]."</td>
			                <td>".$cero.str_replace(",",".",$p["PRECIO"])." €</td>
			              </tr>";
			              }
			            echo
			            "</table>
			            <table class='precioTotal'>
			              <tr>
			                <td>Precio Total:</td>
			                <td>".$sumaTotal." €</td>
			              </tr>
			            </table>
			          </div>";
			?>
			<div class="estadoProducto">
            <p>Estado del pedido: <?php echo $estadoPedido ?></p>
          </div>
          	<form action='prepararCompra.php' method='post'>
          	<?php echo "<input type='number' name='idC' value=".$idCompra." style='display:none' />"; ?>
			<button type="submit" class="btn btn-primary sep">Listo</button>
			<button type="button" onclick="window.location.href='hacerPedidos.php'" class="btn btn-secundary sep2">Volver Atras</button>
			</form>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
