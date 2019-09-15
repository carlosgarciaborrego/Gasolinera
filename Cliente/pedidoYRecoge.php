<?php
session_start();
include __DIR__.'/includes/functions.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Pedido&ampRecoge</title>
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

       <!-- PedidoYRecoge -->
         <div class="pyr">
         <h2>¡ Pide Online y tenlo listo cuando quieras ! </h2>

         <p>Los pasos que seguimos para facilitar tu compra son: </p>
         <br>
         <ol>
           <li>Selecciona los productos que deseas comprar en nuestro catálogo online.</li>
           <li>Rellena tus datos de compra, junto con la fecha y hora de recogida del pedido.</li>
           <li>Nuestros dependientes prepararan tu pedido y lo tendrán listo a la hora acordada.</li>
           <li>Atraca tu barco y sólo tendrás que recoger el pedido que ya se encontrará preparado.</li>
           <li>Realiza el pago manualmente allí mismo a nuestro dependiente (efectivo o tarjeta).</li>
           <li>A disfrutar de su compra.</li>
         </ol>

           <a href = "categoriaFiltro.php?producto=&categoria=todos&range=200" class = "btn btn-primary">Ver productos</a>

        </div>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
