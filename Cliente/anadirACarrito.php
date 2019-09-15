<?php
session_start();
if(isset($_SESSION["formularioProducto"])) {
  if(isset($_REQUEST["idProducto"] , $_REQUEST["nombreProducto"], $_REQUEST["precioProducto"], $_REQUEST["imagenProducto"])){
  $producto["imagenProducto"] = $_REQUEST["imagenProducto"];
  $producto["precioProducto"] = $_REQUEST["precioProducto"];
  $producto["nombreProducto"] = $_REQUEST["nombreProducto"];
  $producto["idProducto"] = $_REQUEST["idProducto"];
  $producto["stockProducto"] = $_REQUEST["stockProducto"];

  $_SESSION["formularioProducto"] = $producto;

  } else {
  Header("Location: categoriaFiltro.php");
  }
}else {
  Header("Location: categoriaFiltro.php");
}


 include __DIR__.'/includes/functions.php'
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Añadir a carrito</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">
          <div class="bordeProductos">
            <div class="imagenProducto">
              <img src="<?php echo $producto["imagenProducto"]?>">
            </div>
            <div class="datosProducto">
              <form class="anadirProducto" action="carrito.php" method="post">
              <h2><strong><?php echo $producto["nombreProducto"] ?></strong></h2>
              <hr>
              <div class="stock">
                Quedan<p class="mostrarValores"><?php echo $producto["stockProducto"] ?></p> unidades en stock.
              </div>
              <h4>Cantidad:</h4>
              <input type="number" id="cantidadProducto" name="cantidadProducto" min=1 max=<?php echo $producto["stockProducto"]?> value="1" /><br><br>
              <h4>Precio: </h4><p class="mostrarValores"><?php echo $producto["precioProducto"]?></p> €<br><br><br>

              <input type="number" id="idProducto" name="idProducto" value="<?php echo $producto["idProducto"] ?>" style="display:none"/>
              <input type="text" id="imagenProducto" name="imagenProducto" value="<?php echo $producto["imagenProducto"] ?>" style="display:none"/>
              <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $producto["nombreProducto"] ?>" style="display:none"/>
              <input type="number" id="precioProducto" name="precioProducto" value="<?php echo $producto["precioProducto"] ?>" style="display:none"/>
              <input type="number" id="stockProducto" name="stockProducto" value="<?php echo $producto["stockProducto"] ?>" style="display:none"/>




            <!--  <button type="submit" id="botonAnadir" class="btn btn-primary" name="anadirProducto">Añadir al carrito</button>
              <a href="categoriaFiltro.php?producto=&categoria=todos&range=200" class="btn btn-secundary">Volver Atrás</a> -->

      <?php   if($producto["stockProducto"]!= 0 && isset($_SESSION["login"])) {
                if($_SESSION["login"]){?>
                  <button type="submit" class="btn btn-primary" name="anadirProducto">Añadir al carrito</button>
          <?php }
              }else{
                  echo "<p class='noLogueado' >Debes estar logueado para poder comprar.<p>";
              }?>
                <a href="categoriaFiltro.php" class="btn btn-secundary">Volver Atrás</a>


            </form>
            </div>
          </div>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
