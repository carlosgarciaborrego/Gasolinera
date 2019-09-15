<?php
/***************Modificar fecha de Nacimiento al registrarte******************/
function getFechaFormateada($fecha){
  $fechaNacimiento = date('d/m/Y', strtotime($fecha));
  return $fechaNacimiento;
}

/********Crear conexion con la Base de Datos******/
function crearConexionBD()
{
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="CARLOS";
	$password="yaco";

	try{
		/* Indicar que las sucesivas conexiones se puedan reutilizar */
		$conexion=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
	    /* Indicar que se disparen excepciones cuando ocurra un error*/
    	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conexion;
	}catch(PDOException $e){
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: excepcion.php");
	}
}

/********Cerrar conexion con la Base de Datos******/
function cerrarConexionBD($conexion){
	$conexion=null;
}

/**************** Consultar trabajador al loguearse***********************/
function consultarEmpleado($conexion,$dni,$contrasena) {

  $consulta = "SELECT nombre,apellidos,dni,contrasena FROM TRABAJADORES
    WHERE DNI = :dni and CONTRASENA = :contrasena";
    try{
      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':dni',$dni);
      $stmt->bindParam(':contrasena',$contrasena);
      $stmt->execute();
      return $stmt->fetch();
    }catch(PDOStatement $e){
      throw new Exception("Error" . $e);
    }
}

/**************** Buscar productos ***********************/
function obtenerProductos($conexion) {
  $result = null;
  $consulta = "SELECT * FROM PRODUCTOS P
  LEFT JOIN ITEMCOMPRAS I
  ON  P.ID_I = I.ID_I";
  try{
    $stmt = $conexion->prepare($consulta);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $result = $stmt->fetchAll();
  }catch(PDOStatement $e){
    throw new Exception("Error" . $e);
  }
  return $result;
}

/*********************************** Paginacion *************************/
function paginacion($conexion, $query, $primera, $ultima){
  $consulta_paginada =
     "SELECT * FROM (
      SELECT ROWNUM RNUM, AUX.* FROM ( $query ) AUX
      WHERE ROWNUM <= $ultima
    )
    WHERE RNUM >= $primera";

  $stmt = $conexion->prepare( $consulta_paginada );
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $stmt->execute();
  $result = $stmt->fetchAll();

  return $result;
}

function consultarPagina($conexion,$pag_size,$pagina){
  $primera = ( $pagina - 1 ) * $pag_size + 1;
  $ultima  = $pagina * $pag_size;
  $query = "SELECT * FROM PRODUCTOS P
  LEFT JOIN ITEMCOMPRAS I
  ON  P.ID_I = I.ID_I";
  return paginacion($conexion, $query, $primera, $ultima);
}

function totalConsultarPagina($conexion) {
  $total_consulta = "SELECT COUNT(*) AS TOTAL FROM PRODUCTOS";

  		$stmt = $conexion->prepare($total_consulta);
      $stmt->execute();
  		$result = $stmt->fetch();
  		$total = $result['TOTAL'];
  		return  $total;
}

/****************************** Buscar Productos ******************************/
function buscador($conexion, $pag_size, $pagina, $returnTotal = false) {
  $filtros = [
  	'busqueda' => (isset($_GET["producto"]) && $_GET["producto"] != '' )? $_GET["producto"] : null,
  	'categoria' => (isset($_GET["categoria"]) && $_GET["categoria"] != 'todos')? $_GET["categoria"] : null,
  	'range' => isset($_GET["range"])? $_GET["range"] : null,
  ];
  if($returnTotal){
    $consulta = "SELECT COUNT(*) AS TOTAL FROM PRODUCTOS P
    LEFT JOIN ITEMCOMPRAS I
    ON  P.ID_I = I.ID_I";
  }else{
    $consulta = "SELECT * FROM PRODUCTOS P
    LEFT JOIN ITEMCOMPRAS I
    ON  P.ID_I = I.ID_I";
  }

  $consulta = $consulta . " WHERE (I.PRECIO BETWEEN 0 AND ".$filtros['range'].")";

  if($filtros['busqueda']){
   	$consulta = $consulta . " AND lower(P.NOMBRE) LIKE lower('%".strtolower($filtros["busqueda"])."%')";
  }

  if($filtros['categoria']){
    $consulta = $consulta . " AND lower(I.TIPOCATEGORIA) LIKE lower('".strtolower($filtros["categoria"])."')";
  }

  try{
    if($returnTotal) {
      $stmt = $conexion->prepare($consulta);
      $stmt->execute();
      $datos = $stmt->fetch()['TOTAL'];
    }else{
      $primera = ( $pagina - 1 ) * $pag_size + 1;
      $ultima  = $pagina * $pag_size;
      $datos = paginacion($conexion, $consulta, $primera, $ultima);
    }

  }catch(PDOStatement $e){
  	throw new Exception("Error" . $e);
  }

  return [
  	'datos' => $datos,
  	'httpUrl' => http_build_query($filtros)
  ];
}

/*********************Elegir combustible *********************************/
function elegirCombustible($conexion,$tipo){

  $consulta = "SELECT * FROM COMBUSTIBLES C
  LEFT JOIN ITEMCOMPRAS I
  ON  C.ID_I = I.ID_I WHERE TIPOCOMBUSTIBLE LIKE '%".strtoupper($tipo)."%'";

  try{
  	$stmt = $conexion->prepare($consulta);
  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
  	$stmt->execute();
    $result = $stmt->fetch();
  	return $result;
  }catch(PDOStatement $e){
  	throw new Exception("Error" . $e);
  }
}

/************************** Función añadir cero antes de la coma ************/
function ceroComa($numero){
  $result = 0;
  if($numero<1){
    $result = $result.$numero;
  }else{
    $result = $numero;
  }
  return $result;
}

function getInfoCompra($conexion,$idCompra) {
	$consulta = "SELECT NOMBRE,DIRECCIONIMAGEN,CODIGO,CANTIDAD,PRECIO FROM PRODUCTOS,LINEACOMPRAS,ITEMCOMPRAS WHERE ".
	"PRODUCTOS.ID_I = LINEACOMPRAS.ID_I AND ".
	"ITEMCOMPRAS.ID_I = LINEACOMPRAS.ID_I AND LINEACOMPRAS.ID_COM = ".$idCompra;
	return $conexion->query($consulta);
}

function consulta_lineaCompra($conexion,$idItem) {
	$consulta = "SELECT * FROM LINEACOMPRAS WHERE ID_I =".$idItem;
	return $conexion->query($consulta);
}

function consulta_cliente($conexion,$idCliente) {
	$consulta = "SELECT * FROM CLIENTES WHERE ID_C =".$idCliente;
	return $conexion->query($consulta);
}

function consulta_compra($conexion,$idCompra) {
	$consulta = "SELECT * FROM COMPRAS WHERE ID_COM =".$idCompra;
	return $conexion->query($consulta);
}

function consulta_producto($conexion,$idProducto) {
	$consulta = "SELECT * FROM PRODUCTOS WHERE ID_P =".$idProducto;
	return $conexion->query($consulta);
}

function consulta_itemCompra($conexion,$idItem) {
	$consulta = "SELECT * FROM ITEMCOMPRAS WHERE ID_I =".$idItem;
	return $conexion->query($consulta);
}

function getAllComprasNoPreparadas($conexion){
	$consulta = "SELECT * FROM COMPRAS WHERE FECHARECOGIDA >= SYSDATE AND PREPARADO = 'NO'";
	return $conexion->query($consulta);
}

function getAllComprasPreparadas($conexion){
	$consulta = "SELECT * FROM COMPRAS WHERE PREPARADO = 'SI'";
	return $conexion->query($consulta);
}

function getAllProductos($conexion){
	$consulta = "SELECT * FROM PRODUCTOS,ITEMCOMPRAS WHERE PRODUCTOS.ID_I = ITEMCOMPRAS.ID_I";
	return $conexion->query($consulta);
}

function getAllProvedores($conexion){
	$consulta = "SELECT * FROM PROVEEDORES";
	return $conexion->query($consulta);
}

function preparar_compra($conexion,$idCompra) {
	try {
		$stmt=$conexion->prepare("UPDATE COMPRAS SET PREPARADO = 'SI' WHERE ID_COM = ".$idCompra);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function pagar_compra($conexion,$idCompra) {
	try {
		$stmt=$conexion->prepare("UPDATE COMPRAS SET PAGADO = 'SI' WHERE ID_COM = ".$idCompra);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function modificar_producto($conexion,$IdpProducto,$NomProducto,$CodProducto,$DirImgProducto,
		$IdiProducto,$IdaProducto,$IdproProducto) {
	try {
		$stmt=$conexion->prepare("UPDATE PRODUCTOS SET NOMBRE='".$NomProducto."',CODIGO='".$CodProducto."',DIRECCIONIMAGEN='".$DirImgProducto."',ID_I=".
								$IdiProducto.",ID_A=".$IdaProducto.",ID_PRO=".$IdproProducto." WHERE ID_P=".$IdpProducto);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function modificar_itemCompra($conexion,$IdItem,$stock,$precio,$categoria) {
	try {
		$stmt=$conexion->prepare("UPDATE ITEMCOMPRAS SET STOCK=".$stock.",PRECIO=".$precio.",TIPOCATEGORIA='".$categoria."' WHERE ID_I=".$IdItem);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function insertar_producto($conexion,$NomProducto,$CodProducto,$DirImgProducto,
		$IdiProducto,$IdaProducto,$IdproProducto) {
	try {
		$stmt=$conexion->prepare("INSERT INTO PRODUCTOS(ID_P,NOMBRE,CODIGO,DIRECCIONIMAGEN,ID_I,ID_A,ID_PRO) VALUES (sec_producto.nextval,'".
		$NomProducto."','".$CodProducto."','".$DirImgProducto."',".$IdiProducto.",".$IdaProducto.",".$IdproProducto.")");
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function insertar_itemCompra($conexion,$stock,$precio,$categoria) {
	try {
		$stmt=$conexion->prepare("INSERT INTO ITEMCOMPRAS(Id_I,STOCK,PRECIO,TIPOCATEGORIA) VALUES (sec_itemCompra.nextval,".$stock.",".$precio.",'".$categoria."')");
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function getIdItemCompra($conexion,$stock,$precio,$categoria){
	$consulta = "SELECT * FROM ITEMCOMPRAS WHERE STOCK =".$stock." AND PRECIO=".$precio." AND TIPOCATEGORIA='".$categoria."'";
	return $conexion->query($consulta);
}

function direccionError($conexion,$DireccionImagen){
	if($Categoria != "BEBIDA" && $Categoria != "ALIMENTACION" && $Categoria != "MECANICA" && $Categoria != "COMBUSTIBLE" && $Categoria != "OTROS" && $Categoria != "TODOS") return "Categoria";
	$productos = getAllProductos($conexion);
	foreach ($productos as $p) {
		if($p["DIRECCIONIMAGEN"] == $DireccionImagen) return "Imagen";
	}
	$provedores = getAllProvedores($conexion);
	foreach ($provedores as $pro) {
		if($pro["ID_PRO"] == $IDProveedor) return "";
	}
	return "Proveedor";
}
function direccionesImagenes($conexion){
	$consulta = "SELECT DIRECCIONIMAGEN FROM PRODUCTOS";
	return $conexion->query($consulta);
}
function idsProveedor($conexion){
	$consulta = "SELECT ID_PRO FROM PROVEEDORES";
	return $conexion->query($consulta);
}

function eliminar_Producto($conexion,$idProducto) {
	$productos = consulta_producto($conexion, $idProducto);
	foreach ($productos as $p) {
		$idItem = $p["ID_I"];
	}
	$lineas = consulta_lineaCompra($conexion, $idItem);
	foreach ($lineas as $l) {
		$idCompra = $l["ID_COM"];
	}
	try {
		$stmt1=$conexion->prepare("DELETE FROM PRODUCTOS WHERE ID_I = ".$idItem);
		$stmt1->execute();
		$stmt2=$conexion->prepare("DELETE FROM COMPRAS WHERE ID_COM = ".$idCompra);
		$stmt2->execute();
		$stmt3=$conexion->prepare("DELETE FROM LINEACOMPRAS WHERE ID_COM = ".$idCompra);
		$stmt3->execute();
		$stmt4=$conexion->prepare("DELETE FROM ITEMCOMPRAS WHERE ID_I = ".$idItem);
		$stmt4->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

function count_comprasPrep($conexion){
	$compras = getAllComprasPreparadas($conexion);
	$array = array();
	foreach ($compras as $c) {
		array_push($array,$c["ID_COM"]);
	}
	return count($array);
}

function count_comprasNoPrep($conexion){
	$compras = getAllComprasNoPreparadas($conexion);
	$array = array();
	foreach ($compras as $c) {
		array_push($array,$c["ID_COM"]);
	}
	return count($array);
}

function cambiar_stock($conexion,$idItem,$nuevoStock){
	try {
		$stmt=$conexion->prepare("UPDATE ITEMCOMPRAS SET STOCK=".$nuevoStock." WHERE ID_I=".$idItem);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
	}
}

?>
