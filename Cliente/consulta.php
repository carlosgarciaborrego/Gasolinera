<?php
  session_start();
include __DIR__.'/includes/functions.php';
  $pedido = $_SESSION["pedido"];

  $conexion=crearConexionBD();
  $filas = consultarProductosDePedidos($conexion,16);
  cerrarConexionBD($conexion);
 ?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Consulta productos</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
      </nav>
      <section  class="section">
        <div class="cuerpo">

          <table id="tabla_productos">
						<tr><th>IMAGEN</th><th>NOMBRE</th><th>CANTIDAD</th><th>PRECIO</th></tr>

						<?php foreach($filas as $fila) { ?>

							<tr class="PRODUCTO">
								<td><?php echo $fila["DIRECCIONIMAGEN"]; ?></td>
								<td><?php echo $fila["NOMBRE"]; ?></td>
                <td><?php echo $fila["CANTIDAD"]; ?></td>
                <td><?php echo $fila["PRECIO"]; ?></td>
							</tr>

						<?php } ?>
					</table>
          <br><br><br>

          <a href="miCuentaActuales.php" class="btn btn-secundary">Volver atrás</a>


        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
