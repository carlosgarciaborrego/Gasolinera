<?php include __DIR__.'/includes/functions.php' ?>
<?php
session_start();

$conexion = crearConexionBD();
$compras = getAllComprasPreparadas($conexion);
$size = count_comprasPrep($conexion);
cerrarConexionBD($conexion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Mi Cuenta - Historial</title>
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
          <h1>Historial de Pedidos</h1><br>
          <table class="tablaPedidos">
            <?php
            	if ($size>0) {
            		echo "<tr>
              				<th>Cliente</th>
              				<th>Fecha</th>
            			</tr>";
				}
				else echo "<p style='color:blue'>[ No hay Compras para preparar ]</p>";
				foreach ($compras as $pedido) {
				$cadenaPagado = "";
				if($pedido["PAGADO"]=='SI'){
					$cadenaPagado = "<td class='cancelar pagado'>Pagado</td>";
				}
				else{
					$cadenaPagado = "<td class='cancelar nopagado'>No Pagado</td>";
				}
				$conexion = crearConexionBD();
				$clientes = consulta_cliente($conexion,$pedido["ID_C"]);
				cerrarConexionBD($conexion);
				
				foreach ($clientes as $cliente) {
					echo
					"<tr>
			      		<td>".$cliente["NOMBRE"]." ".$cliente["APELLIDOS"]."</td>
			      		<td>".$pedido["FECHAPEDIDO"]."</td>".$cadenaPagado.
			      			"<div class='compra'>
			      			<form class='formCompra' action='consulta.php' method='post'>
				      			<input type='number' id='idCompra' name='idCompra' value=".$pedido["ID_COM"]." style='display:none'/>
				      			<input type='number' id='idCliente' name='idCliente' value=".$cliente["ID_C"]." style='display:none'/>
			        			<td class='cancelar'><button type='submit' name='anadir'>Consultarlo</button></td>
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
