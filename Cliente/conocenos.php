<?php
session_start();
include __DIR__.'/includes/functions.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Conócenos</title>
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
          <div class="textoDescriptivo">
          <h1>Sobre nosotros</h1><br>
          <p>La Estación de servicio Marina Sur se encuentra en el puerto marítimo de El Terrón (Lepe). Somos una empresa
            comprometida con la calidad tanto en los productos que ofrecemos como en nuestro servicio.</p><br><br>

             <p>Contamos con un servicio de repostaje tanto
            para vehículos terrestres como para embarcaciones marítimas (para las que existen un embarcadero homologado), y con personal cualificado para llevar
             a cabo la labor de repostaje con total seguridad.</p><br><br>

      <p>Nuestras instalaciones disponen de una tienda física en la que podrás adquirir todo tipo de productos,
        desde un refresco hasta algún producto mecánico. No dudes en visitar nuestro <a href="catalogo.php">catálogo</a>.</p><br></div>
        <div class="Mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d944.516993330512!2d-7.174691263973628!3d37.22483390790081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd102ddea8044a11%3A0x4aca8ae5240f23c9!2sTienda+Marina+Sur!5e0!3m2!1ses!2ses!4v1521119130954" width="75%" height="350" frameborder="1" style="border:1" allowfullscreen></iframe>
        </div>
      </div>
         </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
