<?php
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