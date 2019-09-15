<?php
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