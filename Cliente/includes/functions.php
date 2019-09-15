<?php
/***************Modificar fecha de Nacimiento al registrarte******************/
function getFechaFormateada($fecha){
  $fechaNacimiento = date('d/m/Y', strtotime($fecha));
  return $fechaNacimiento;
}

/********Validación en servidor del formulario de alta de usuario******/
function validarDatosUsuario($nuevoUsuario){
  $errores = [];
  // Validación del Nombre
  if($nuevoUsuario["nombre"]==""){
    $errores[]= "El nombre no puede estar vacío.";
  }elseif ($nuevoUsuario["nombre"].length>50) {
    $errores[]= "El nombre es muy largo.";
  }

  // Validación del Apellido
  if($nuevoUsuario["apellidos"]==""){
    $errores[]= "Los apellidos no pueden estar vacíos.";
  }else if ($nuevoUsuario["apellidos"].length>50) {
    $errores[]= "El apellido es muy largo.";
  }

	// Validación del DNI
	if($nuevoUsuario["dni"]==""){
		$errores[]= "El DNI no puede estar vacío.";
	}else if(!preg_match("/^[0-9]{8}[A-Z]$/",$nuevoUsuario["dni"])){
		$errores[]="El DNI debe contener 8 números y una letra mayúscula.";
	}

  // Validación de fechaNacimiento
  if($nuevoUsuario["fechaNacimiento"]==""){
    $errores[]= "La fecha no puede estar vacía.";
  }

  // Validación del teléfono
	if($nuevoUsuario["telefono"]==""){
		$errores[]= "El teléfono no puede estar vacío.";
	}else if(!preg_match("/^[0-9]{9}/",$nuevoUsuario["telefono"])){
		$errores[]="El teléfono debe contener 9 números.";
	}

  // Validación del email
	if($nuevoUsuario["email"]==""){
		$errores[]="El email no puede estar vacio";
	} else if(!filter_var($nuevoUsuario["email"], FILTER_VALIDATE_EMAIL)){
		$errores="El email no tiene el formato correcto";
	}elseif ($nuevoUsuario["email"].length>60) {
    $errores[]= "El correo es muy largo.";
  }

  // Validación de la contraseña
	if(!isset($nuevoUsuario["contrasena"]) || strlen($nuevoUsuario["contrasena"])<8){
		$errores[]="La contraseña tiene menos de 8 digitos";
	}else if(!preg_match("/[a-z]+/", $nuevoUsuario["contrasena"]) ||
		    !preg_match("/[A-Z]+/", $nuevoUsuario["contrasena"]) ||
			!preg_match("/[0-9]+/", $nuevoUsuario["contrasena"])){
				$errores[]="La contraseña no está en el formato correcto. Debe contener al menos un digito y un caracter mayúscula y minuscula";
	}

	if($nuevoUsuario["contrasena"] != $nuevoUsuario["confirmarContrasena"]){
		$errores[]="La confirmacion de contraseña es distinta de la contraseña";
	}

  return $errores;
}

/********Crear conexion con la Base de Datos******/
function crearConexionBD()
{
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="BD";
	$password="iaonde";

	try{
		/* Indicar que las sucesivas conexiones se puedan reutilizar */
		$conexion=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
	    /* Indicar que se disparen excepciones cuando ocurra un error*/
    	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conexion;
	}catch(PDOException $e){
		$_SESSION['excepcion'] = "No ha sido posible acceder a la base de datos, intentelo de nuevo más tarde.";
		header("Location: excepcion.php");
	}
}

/********Cerrar conexion con la Base de Datos******/
function cerrarConexionBD($conexion){
	$conexion=null;
}

/********Añadir un usuario a Base de Datos******/
function alta_usuario($conexion,$usuario) {

  $Fecha = date('d/m/Y', strtotime($usuario["fechaNacimiento"]));

	try {
    $stmt = $conexion->PREPARE("INSERT INTO CLIENTES (Id_C, nombre, apellidos, dni ,telefono ,correo ,fechaNacimiento, contrasena) VALUES(sec_cliente.nextval, :nombre, :apellidos, :dni ,:telefono ,:correo ,:fechaNacimiento, :contrasena)");
    $stmt->bindParam(":nombre", $usuario["nombre"]);
    $stmt->bindParam(":apellidos", $usuario["apellidos"]);
    $stmt->bindParam(":dni", $usuario["dni"]);
    $stmt->bindParam(":telefono", $usuario["telefono"]);
    $stmt->bindParam(":correo", $usuario["email"]);
    $stmt->bindParam(":fechaNacimiento", $Fecha);
    $stmt->bindParam(":contrasena", $usuario["contrasena"]);
    $stmt->execute();
    return true;
  }catch(PDOException $e){
    $_SESSION["excepcion"] = "Ha habido un error al registrarte: ".$e->getMessage();
    header("Location: excepcion.php");
    return false;
  }
}

/**************** Consultar usuario al loguearse***********************/
function consultarUsuario($conexion,$dni,$contrasena) {

  $consulta = "SELECT Id_C, nombre, apellidos, dni, correo, contrasena, fechaNacimiento, TELEFONO, token FROM CLIENTES
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

/**************** Consultar trabajador al loguearse***********************/
function consultarEmpleado($conexion,$dni,$contrasena) {

  $consulta = "SELECT nombre, apellidos, dni, contrasena FROM TRABAJADORES
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

/******************** Consultar email *********************/
function consultarEmail($conexion, $correo){

  $consulta = "SELECT * FROM CLIENTES
    WHERE CORREO = :correo";

    try{
      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':correo',$correo);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      $result = $stmt->fetch();
      return $result;
  }catch(PDOStatement $e){
  	throw new Exception("Error" . $e);
  }
}

/****************** Crear token ********************************/
function generateCodigo(){
   return date("YmdHis").substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
}

/****************** Actualizar usuario ****************************/
function actualizarUsuario($conexion,$id){
  $token = generateCodigo();
  $consulta = "UPDATE CLIENTES
    SET token = :token
    WHERE ID_C = :id_c";

    try{
      $stmt = $conexion->prepare($consulta);
      $stmt->bindParam(':token',$token);
      $stmt->bindParam(':id_c',$id);

      $stmt->execute();
      return $token;
    }catch(PDOStatement $e){
    throw new Exception("Error" . $e);
    }
}

/****************** Recuperacion de email ****************************/
function enviarEmailRecuperacion($usuario,$url){

  $mensaje = '
<html>
<head>
  <title>Recuperar Contraseña</title>
</head>
<body>
  <p>Hola' . $usuario["NOMBRE"] . '</p>
  <p><a href="'. $url .'" target="_new" >Aquí para recuperar contraseña</a></p>
</body>
</html>
';

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$cabeceras .= 'To:'. $usuario["NOMBRE"] . '<' .$usuario["EMAIL"] . '>'."\r\n";
$cabeceras .= 'From: GASOLINERA <garciaborrego.carlos@gmail.com>' . "\r\n";

mail($usuario["EMAIL"], 'Recuperar Contraseña', $mensaje, $cabeceras);

}


/*************************** codigo token ****************************/
function buscarClientePorToken ($conexion, $token){

  $consulta = "SELECT * FROM CLIENTES
  WHERE TOKEN = :token";

  try{
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':token',$token);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
  }catch(PDOStatement $e){
  throw new Exception("Error" . $e);
  }

}

/********************************** Actualizar Contraseña  ************************************/
function actualizarContrasena ($conexion, $contrasena,$usuario){

  $consulta = "UPDATE CLIENTES SET CONTRASENA = :contrasena WHERE ID_C = :id_c";

  try{
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':id_c',$usuario["ID_C"]);
    $stmt->bindParam(':contrasena',$contrasena);
    $stmt->execute();
    return true;
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

/************************ Calcular nuevo subtotal ***********************/
function subtotalProducto($prod){
  $subtotal = $prod["cantidadProducto"] * $prod["precioProducto"];
  return $subtotal;
}

/********************* Calcular total carrito *********************************/
function totalCarrito($cart){
  $total = 0;
  foreach ($cart as $p) {
    $total=$total + subtotalProducto($p);
  }
  return $total;
}

/******************* Crear compra al procesar pedido *************************/
function creaCompra($conexion, $fechaRecogida, $fechaPedido, $idCliente){
  $idTrabajador = 2;
  $pagado = "NO";
  $preparado = "NO";

  try{
    //Primero, creamos la consulta sql en un string
    $consulta = "SELECT insertarcompra(TO_DATE(:fechapedido, 'DD/MM/YYYY HH24:Mi'), TO_DATE(:fecharecogida, 'DD/MM/YYYY HH24:Mi'), :pagado, :preparado, :id_c, :id_t) FROM DUAL";
    //Preparamos la consulta con la conexion pasada por parametros a la funcion
  $stmt = $conexion->prepare($consulta);
    //Asignamos valores a los parametros de la consulta
    $stmt->bindParam(":fechapedido", $fechaPedido);
    $stmt->bindParam(":fecharecogida", $fechaRecogida);
    $stmt->bindParam(":pagado", $pagado);
    $stmt->bindParam(":preparado", $preparado);
    $stmt->bindParam(":id_c", $idCliente);
    $stmt->bindParam(":id_t", $idTrabajador);
    //Por ultimo, ejecutamos la consulta
    $stmt->execute();
    $id_compra = $stmt->fetch();
    //Retornamos el id de la compra creada para posteriormente añadir las lineas de compra
    return $id_compra;
  }catch(PDOexception $e){
    //Retornamos el mensaje de error de la excepcion
    $_SESSION["excepcion"]="Ha habido un error al procesar la compra: ".$e->getMessage();
    header("Location: excepcion.php");
    return false;
  }
}

/****************** Obtener ID del itemCompra a partir del producto ***********************/
function obtieneIdI($conexion, $idProducto){
  try{
    $consulta = "SELECT ID_I FROM PRODUCTOS WHERE CODIGO=:idProducto";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(":idProducto", $idProducto);
    $stmt->execute();

    return $stmt->fetch();
  }catch(PDOexception $e){
    $_SESSION["excepcion"]="Error al obtener el id del item asociado al producto (Id_I)".$e->getMessage();
    header("Location: excepcion.php");
    return false;
  }

}
function obtieneIdICOMB($conexion, $idProducto){
  try{
    $consulta = "SELECT ID_I FROM COMBUSTIBLES WHERE ID_COMB=:idProducto";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(":idProducto", $idProducto);
    $stmt->execute();

    return $stmt->fetch();
  }catch(PDOexception $e){
    $_SESSION["excepcion"]="Error al obtener el id del item asociado al producto (Id_I)".$e->getMessage();
    header("Location: excepcion.php");
    return false;
  }

}

/*************************** Crear una lineaCompra por cada producto del carrito ******************/
function creaLineaCompra($conexion, $cantidad, $id_i, $id_com){
  try{
  $consulta ="INSERT INTO LINEACOMPRAS (ID_L, CANTIDAD, ID_I, ID_COM) VALUES (SEC_LINEACOMPRA.NEXTVAL, :cantidad, :id_i, :id_com)";
  $cantidadF = str_replace(".",",",$cantidad);

  $stmt = $conexion->prepare($consulta);
  $stmt->bindParam(":cantidad", $cantidadF);
  $stmt->bindParam(":id_i", $id_i);
  $stmt->bindParam(":id_com", $id_com);
  $stmt->execute();

  return true;
 }catch(PDOexception $e){
  $_SESSION["excepcion"]="Error al crear una linea de compra: ".$e->getMessage();
  header("Location: excepcion.php");
  return false;
 }
}

/************** INFORMACIÓN DE COMPRA ************************************/
function getInfoCompra($conexion,$id_com) {
  $consulta = "SELECT LINEACOMPRAS.CANTIDAD, ITEMCOMPRAS.PRECIO
  FROM LINEACOMPRAS, ITEMCOMPRAS, COMPRAS
  WHERE (COMPRAS.ID_COM = LINEACOMPRAS.ID_COM AND LINEACOMPRAS.ID_I = ITEMCOMPRAS.ID_I AND COMPRAS.ID_COM=:id_com)";

       try {
         $stmt=$conexion->prepare($consulta);
         $stmt->bindParam(':id_com',$id_com);
         $stmt->execute();
         $result = $stmt->fetchAll();
         return $result;

       }catch(PDOStatement $e) {
         $_SESSION["excepcion"]=$e->getMessage();
         return false;
       }
}

/********************* CONSULTAR PEDIDOS ACTUAL DE UN CLIENTE **************/
function consultarPedidosActuales($conexion,$id_c) {
  $consulta = "SELECT * FROM COMPRAS WHERE :id_c = COMPRAS.ID_C AND COMPRAS.FECHARECOGIDA > TO_CHAR(SYSDATE,'DD-MM-YYYY')";
  try {
    $stmt=$conexion->prepare($consulta);
    $stmt->bindParam(':id_c',$id_c);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;

  }catch(PDOStatement $e) {
    $_SESSION["excepcion"]=$e->getMessage();
    return false;
  }
}

/********************* CONSULTAR PEDIDOS HISTORIAL DE UN CLIENTE **************/
function consultarPedidosHistorial($conexion,$id_c) {
  $consulta = "SELECT * FROM COMPRAS WHERE :id_c = COMPRAS.ID_C AND COMPRAS.FECHARECOGIDA < TO_CHAR(SYSDATE,'DD-MM-YYYY')";
  try {
    $stmt=$conexion->prepare($consulta);
    $stmt->bindParam(':id_c',$id_c);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;

  }catch(PDOStatement $e) {
    $_SESSION["excepcion"]=$e->getMessage();
    return false;
  }
}

/*************** CONSULTAR LOS PRODUCTOS DE UN PEDIDO *****************/
function consultarProductosDePedidos($conexion, $idCompra) {
	$consulta = "SELECT PRODUCTOS.DIRECCIONIMAGEN, PRODUCTOS.NOMBRE, LINEACOMPRAS.CANTIDAD, ITEMCOMPRAS.PRECIO
   FROM PRODUCTOS, LINEACOMPRAS, ITEMCOMPRAS
   WHERE (ITEMCOMPRAS.ID_I = LINEACOMPRAS.ID_I AND ITEMCOMPRAS.ID_I = PRODUCTOS.ID_I AND LINEACOMPRAS.ID_COM = :idCompra)";
   try {
     $stmt=$conexion->prepare($consulta);
     $stmt->bindParam(':idCompra',$idCompra);
     $stmt->execute();
     $result = $stmt->fetchAll();
     return $result;

   }catch(PDOStatement $e) {
     $_SESSION["excepcion"]=$e->getMessage();
     return false;
   }
}



/*********************** MODIFICAR CLIENTE *****************************/
function editar_cliente($conexion,$id_c,$nombre,$apellidos,$dni,$telefono,$correo,$fechaNacimiento,$contrasena,$direccionImagen,$token) {
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZAR_CLIENTES(:id_c,:nombre,:apellidos,:dni,:telefono,:correo,:fechaNacimiento,:contrasena,:direccionImagen,:token)');
		$stmt->bindParam(':id_c',$id_c);
    $stmt->bindParam(':nombre',$nombre);
    $stmt->bindParam(':apellidos',$apellidos);
    $stmt->bindParam(':dni',$dni);
    $stmt->bindParam(':fechaNacimiento',$fechaNacimiento);
    $stmt->bindParam(':telefono',$telefono);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':contrasena',$contrasena);
    $stmt->bindParam(':token',$token);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

 /****************** MODIFICAR CONTRASEÑA ******************/
function modificarContrasena($conexion,$IC_C,$contrasena) {
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZAR_CLIENTES(:ID_C,:contrasena)');
		$stmt->bindParam(':ID_C',$ID_C);
		$stmt->bindParam(':contrasena',$contrasena);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

/******************* BORRAR PEDIDO *************************/
function borrar_pedido($conexion,$IDCom) {
	try {
		$stmt=$conexion->prepare("CALL eliminar_compras(:IDCom)");
		$stmt->bindParam(':IDCom',$IDCom);
		$stmt->execute();
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
