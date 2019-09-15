<?php

		$pedido["ID_COM"] = $_REQUEST["ID_COM"];
		$pedido["FECHAPEDIDO"] = $_REQUEST["FECHAPEDIDO"];
		$pedido["FECHARECOGIDA"] = $_REQUEST["FECHARECOGIDA"];
		$pedido["PAGADO"] = $_REQUEST["PAGADO"];
		$pedido["PREPARADO"] = $_REQUEST["PREPARADO"];
		$pedido["ID_C"] = $_REQUEST["ID_C"];
		$pedido["ID_T"] = $_REQUEST["ID_T"];
		$pedido["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		$pedido["PRECIO"] = $_REQUEST["PRECIO"];

		$_SESSION["pedido"] = $pedido;


    if(isset($_REQUEST["eliminar"])){
       Header("Location: borrarPedido.php");
    }
    if(isset($_REQUEST["consulta"]))
      Header("Location: consulta.php");
?>
