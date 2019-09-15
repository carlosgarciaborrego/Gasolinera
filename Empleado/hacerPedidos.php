<?php include __DIR__.'/includes/functions.php' ?>
<?php
session_start();

$conexion = crearConexionBD();
$compras = getAllComprasNoPreparadas($conexion);
$size = count_comprasNoPrep($conexion);
cerrarConexionBD($conexion);

?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Hacer Pedidos</title>
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
          <h1>Nuevos Pedidos</h1><br>
          <table class="tablaPedidos">
          	<?php
          	if ($size>0) {
            		echo "<tr>
              				<th>Cliente</th>
              				<th>Fecha</th>
            			</tr>";
			}
			else echo "<p style='color:blue'>[ No hay Compras Preparadas ]</p>";
			foreach ($compras as $pedido) {
					
				$conexion = crearConexionBD();
				$clientes = consulta_cliente($conexion,$pedido["ID_C"]);
				cerrarConexionBD($conexion);
				
				foreach ($clientes as $cliente) {
					echo
					"<tr>
			      		<td>".$cliente["NOMBRE"]." ".$cliente["APELLIDOS"]."</td>
			      		<td>".$pedido["FECHAPEDIDO"]."</td>
			      			<div class='compra'>
			      			<form class='formCompra' action='prepararlo.php' method='post'>
				      			<input type='number' id='idCompra' name='idCompra' value=".$pedido["ID_COM"]." style='display:none'/>
				      			<input type='number' id='idCliente' name='idCliente' value=".$cliente["ID_C"]." style='display:none'/>
			        			<td class='cancelar'><button type='submit' name='anadir'>Prepararlo</button></td>
			     			</form>
			     			</div>
			    	</tr>";
				}	
			}
			?>
          </table>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
