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
			$estadoPedido = $c["PAGADO"];
		}
		$sumaTotal = 0.0;
		foreach ($clientes as $c) {
			$cliente = $c;
		}

	  } else {
	  Header("Location: hacerPedidos.php");
	  }
	}else {
	  Header("Location: hacerPedidos.php");
	}


?>
