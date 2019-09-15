<?php
session_start();

include __DIR__.'/includes/functions.php';

if(isset($_SESSION["carrito"]) && !empty($_SESSION["carrito"])){
  Header("Location: carrito.php");
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
        <div class="menu-cuenta col-10">
            <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
        </div>
      </nav>
      <section  class="section">
        <div class="cuerpo">
          <h2 class="tituloCarrito">Carrito de Compra</h2><br>
          <h3 class="carritoVacio">El carrito de la compra está vacío. ¡Visita la <a href="categoriaFiltro.php">tienda para añadir productos a tu pedido!</a></h3>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
