<?php
session_start();

	if(isset($_SESSION["pedidoSeleccionado"])) {
	  if(isset($_REQUEST["idCompra"],$_REQUEST["idCliente"])){
	  	$compra["idCompra"] = $_REQUEST["idCompra"];
		$compra["idCliente"] = $_REQUEST["idCliente"];

	  	$_SESSION["pedidoSeleccionado"] = $compra;

		$conexion = crearConexionBD();
		$clientes = consulta_cliente($conexion,$compra["idCliente"]);
		$infoCompra = getInfoCompra($conexion,$compra["idCompra"]);
		$compraAUX = consulta_compra($conexion,$compra["idCompra"]);
		cerrarConexionBD($conexion);

		foreach ($compraAUX as $c){
			$fechaRecogida = $c["FECHARECOGIDA"];
			if($c["PAGADO"]=='SI'){
				$estadoPedido = "Pagado";
			}
			else {
				$estadoPedido = "NO Pagado";
			}
		}
		$sumaTotal = 0.0;
		foreach ($clientes as $c) {
			$cliente = $c;
		}

	  } else {
	  Header("Location: recogerPedidos.php");
	  }
	}else {
	  Header("Location: recogerPedidos.php");
	}


?>
