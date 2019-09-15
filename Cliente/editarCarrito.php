<?php
session_start();

if(isset($_REQUEST["remove"])){
  $producto["imagenProducto"] = $_REQUEST["imagenProducto"];
  $producto["nombreProducto"] = $_REQUEST["nombreProducto"];
  $producto["precioProducto"] = $_REQUEST["precioProducto"];
  $producto["idProducto"] = $_REQUEST["idProducto"];
  $producto["cantidadProducto"] = $_REQUEST["cantidadProducto"];




  $carrito = $_SESSION["carrito"];

  while ($p = current($carrito)) {
    if ($p == $producto) {
        $key = key($carrito);
        unset($carrito[$key]);
    }
    next($carrito);
}
  $_SESSION["carrito"] = $carrito;

  Header("Location: carrito.php");
}else if(isset($_REQUEST["continue"])){
  $producto["imagenProducto"] = $_REQUEST["imagenProducto"];
  $producto["nombreProducto"] = $_REQUEST["nombreProducto"];
  $producto["precioProducto"] = $_REQUEST["precioProducto"];
  $producto["idProducto"] = $_REQUEST["idProducto"];
  $producto["cantidadProducto"] = $_REQUEST["cantidadProducto"];

  $carrito = $_SESSION["carrito"];

  while ($p = current($carrito)) {
    if ($p["idProducto"] == $producto["idProducto"]) {
        $key = key($carrito);
        unset($carrito["$key"]);
        $p["cantidadProducto"] = $producto["cantidadProducto"];
        array_push($carrito, $producto);
    }
      next($carrito);
}
  $_SESSION["carrito"] = $carrito;

 Header("Location: carrito.php");

}else{
  header("Location: carrito.php");
}

 ?>
