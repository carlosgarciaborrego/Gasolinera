<?php session_start();
include __DIR__.'/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Home</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
  .mySlides {display:none;}
</style>
<body>
<?php include __DIR__.'/includes/header.php' ?>
<div id="wrapper">
  <nav class="nav-Menu col-10">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
  </nav>
  <section  class="section col-10">
    <div class="cuerpo">
      <h3>¡Bienvenid@ al sitio web de la estación de servicio MarinaSur S.L!</h3><br>
      <div class="w3-content w3-section" style="max-width:500px">
        <img class="mySlides w3-animate-fading" src="imagenes/marinasur/1.jpg" style="width:100%">
        <img class="mySlides w3-animate-fading" src="imagenes/marinasur/2.jpg" style="width:100%">
        <img class="mySlides w3-animate-fading" src="imagenes/marinasur/3.jpg" style="width:100%">
      </div>
      <div class="horarios">
        <p> El horario de nuestro establecimiento es el siguiente: </p>

        <table class="horaPublico">
          <th class="borradito">
            <td>Horarios</td>
          </th>
          <tr>
            <td>Estación de servicio</td>
            <td class="horitas">Las 24h diarias</td>
          </tr>
          <tr>
            <td>Tienda</td>
            <td class="horitas">De 9:00 AM a 21:00 PM</td>
          </tr>
        </table>

        </div>

      <script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, 10000);
}
</script>
</div>
</section>
</div>
<?php include __DIR__.'/includes/footer.php' ?>
<?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
