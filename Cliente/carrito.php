<?php
session_start();

include __DIR__.'/includes/functions.php';
include __DIR__.'/includes/js.php';

if(isset($_SESSION["carrito"])){
  $carrito = $_SESSION["carrito"];

  if(isset($_REQUEST["anadirProducto"])){
    $producto["imagenProducto"] = $_REQUEST["imagenProducto"];
    $producto["nombreProducto"] = $_REQUEST["nombreProducto"];
    $producto["precioProducto"] = $_REQUEST["precioProducto"];
    $producto["idProducto"] = $_REQUEST["idProducto"];
    $producto["cantidadProducto"] = $_REQUEST["cantidadProducto"];
    $stock = $_REQUEST["stockProducto"];


    if($stock<$producto["cantidadProducto"]){
      $_SESSION["excepcion"] = "La cantidad seleccionada supera al stock disponible.";
      header("Location: excepcion.php");die;
    }


    $existe = false;
    while ($p = current($carrito)) {
      if ($p["idProducto"] == $producto["idProducto"]) {
          $key = key($carrito);
          unset($carrito["$key"]);
          $producto["cantidadProducto"] = $producto["cantidadProducto"] + $p["cantidadProducto"];
          array_push($carrito, $producto);
          $existe = true;
      }
        next($carrito);

  }
  if($existe == false){
     array_push($carrito, $producto);
}



$_SESSION["carrito"] = $carrito;
$_REQUEST["anadirProducto"] = "";


  }else {
      $carrito = $_SESSION["carrito"];
      if(empty($carrito)){
        Header("Location: carrito_vacio.php");
      }

  }
}else{
  $carrito = array();
  $_SESSION["carrito"] = $carrito;

  if(isset($_REQUEST["anadirProducto"])){
    $producto["imagenProducto"] = $_REQUEST["imagenProducto"];
    $producto["nombreProducto"] = $_REQUEST["nombreProducto"];
    $producto["precioProducto"] = $_REQUEST["precioProducto"];
    $producto["idProducto"] = $_REQUEST["idProducto"];
    $producto["cantidadProducto"] = $_REQUEST["cantidadProducto"];

    array_push($carrito, $producto);

    $_SESSION["carrito"] = $carrito;
    $_REQUEST["anadirProducto"] = "";

  }else {
      $carrito = $_SESSION["carrito"];
      if(empty($carrito)){
        Header("Location: carrito_vacio.php");
      }
  }
}

if(isset($_SESSION["formularioEdicion"])){
  $formularioEdicion["imagenProducto"] = "";
  $formularioEdicion["nombreProducto"] = "";
  $formularioEdicion["precioProducto"] = "";
  $formularioEdicion["idProducto"] = "";
  $formularioEdicion["cantidadProducto"] = "";

  $_SESSION["formularioEdicion"] = $formularioEdicion;
}

if(isset($_SESSION["fechaRecogida"], $_SESSION["horaRecogida"])){
  $fechaRecogida=$_SESSION["fechaRecogida"];
  $horaRecogida = $_SESSION["horaRecogida"];
}else{
  $fechaRecogida="";
  $horaRecogida="";
}
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Carrito</title>
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
          <h2 class="tituloCarrito">Carrito de Compra</h2><br>
          <table class="tablaProductosSeleccionados">
            <tr>
              <th></th>
              <th>Artículo</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
            </tr>

            <?php $numero = 0;
            foreach ($carrito as $p) {
                $numero=$numero+1;
              if($p["nombreProducto"]=="GASOLINA" || $p["nombreProducto"]=="GASOIL"){ ?>

          <div class="lineaCarrito">
            <form class="formularioEdicion" action="editarCarrito.php" method="post">
              <tr>
              <td><img src="imagenes/combustibles.jpg" alt="<?php echo $p["nombreProducto"] ?>"></td>
              <td><?php echo $p["nombreProducto"] ?></td>
              <td><p class="cantidadActual" id="cantidadActual<?php echo $numero?>" style="display:block"><?php echo $p["cantidadProducto"] ?></p><input type="number" step="0.1" id="cantidadProducto<?php echo $numero?>" name="cantidadProducto" value="<?php echo $p["cantidadProducto"]?>" min ="1" onclick="modification('<?php echo $numero?>')" style="display:none"/></td>
              <td><?php echo $p["precioProducto"]?>€</td>
              <td><?php echo subtotalProducto($p);?>€ <p id="mod<?php echo $numero?>"></p></td>
              <td class="cancelar">
                <input type="number" id="idProducto" name="idProducto" value="<?php echo $p["idProducto"] ?>" style="display:none"/>
                <input type="text" id="imagenProducto" name="imagenProducto" value="<?php echo $p["imagenProducto"] ?>" style="display:none"/>
                <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $p["nombreProducto"] ?>" style="display:none"/>
                <input type="number" id="precioProducto<?php echo $numero?>" name="precioProducto" value="<?php echo $p["precioProducto"] ?>" style="display:none"/>

                <button type="submit" name="remove" alt="Cancelar pedido" title="Cancelar pedido"><i class="fas fa-trash-alt"></i></button>
                <button type="button" name="edit" id="edit<?php echo $numero?>" alt="Editar cantidad" title="Editar cantidad" onclick="editCart('<?php echo $numero ?>');" style="display:block"><i class="fas fa-pencil-alt"></i></button>

              <br><br><div class="editar">
                <button type="submit" name="continue" id="continue<?php echo $numero?>" alt="Confirmar edicion" title="Confirmar edicion" style="display:none" >Confirmar</button>
                <button type="button" name="cancel" id="cancel<?php echo $numero?>" alt="Cancelar edicion" title="Cancelar edicion" style="display:none" onclick="cancelEdit('<?php echo $numero?>')">Cancelar</button>
              </div>
              </td>
              </tr>
            </form>
          </div>
        <?php }else { ?>
          <div class="lineaCarrito">
            <form class="formularioEdicion" action="editarCarrito.php" method="post">
              <tr>
              <td><img src="<?php echo $p["imagenProducto"]?>" alt="<?php echo $p["nombreProducto"] ?>"></td>
              <td><?php echo $p["nombreProducto"] ?></td>
              <td><p class="cantidadActual" id="cantidadActual<?php echo $numero?>" style="display:block"><?php echo $p["cantidadProducto"] ?></p><input type="number" step="1" id="cantidadProducto<?php echo $numero?>" name="cantidadProducto" value="<?php echo $p["cantidadProducto"]?>" min ="1" onclick="modification('<?php echo $numero?>')" style="display:none"/></td>
              <td><?php echo $p["precioProducto"]?>€</td>
              <td><?php echo subtotalProducto($p);?>€ <p id="mod<?php echo $numero?>"></p></td>
              <td class="cancelar">
                <input type="number" id="idProducto" name="idProducto" value="<?php echo $p["idProducto"] ?>" style="display:none"/>
                <input type="text" id="imagenProducto" name="imagenProducto" value="<?php echo $p["imagenProducto"] ?>" style="display:none"/>
                <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $p["nombreProducto"] ?>" style="display:none"/>
                <input type="number" id="precioProducto<?php echo $numero?>" name="precioProducto" value="<?php echo $p["precioProducto"] ?>" style="display:none"/>

                <button type="submit" name="remove" alt="Cancelar pedido" title="Cancelar pedido"><i class="fas fa-trash-alt"></i></button>
                <button type="button" name="edit" id="edit<?php echo $numero?>" alt="Editar cantidad" title="Editar cantidad" onclick="editCart('<?php echo $numero ?>');" style="display:block"><i class="fas fa-pencil-alt"></i></button>

              <br><br><div class="editar">
                <button type="submit" name="continue" id="continue<?php echo $numero?>" alt="Confirmar edicion" title="Confirmar edicion" style="display:none" >Confirmar</button>
                <button type="button" name="cancel" id="cancel<?php echo $numero?>" alt="Cancelar edicion" title="Cancelar edicion" style="display:none" onclick="cancelEdit('<?php echo $numero?>')">Cancelar</button>
              </div>
              </td>
              </tr>
            </form>
          </div>
      <?php  }
      } ?>

          </table>
          <table class="totalDelPedido totalCarrito">
            <tr>
              <td>Total: <?php echo totalCarrito($carrito)?>€</td>
            </tr>
          </table>
          <div class="formDatosCompra">
            <form action="confirmarCarrito.php" method="post">
              <div>
                <label for="fechaHoraRecogida">Fecha de recogida: </label>
                <input type="date" name="fechaRecogida" value="<?php echo date('Y-m-d'); ?>" min ="<?php echo date('Y-m-d'); ?>" id="fechaRecogida">
                <input type="time" name="horaRecogida" value ="<?php echo date("H").":".date("i"); ?>" min="<?php echo date("H").":".date("i")+10; ?>" id="horaRecogida">
              </div>
          </div>
          <button type="submit" name="realizarPedido" class="btn btn-primary">Realizar pedido</button>
        </div>
        </div>
		  </section>

    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
</body>
</html>
