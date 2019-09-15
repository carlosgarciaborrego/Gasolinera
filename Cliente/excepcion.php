<?php
session_start();
if(isset($_SESSION["excepcion"])){
$excepcion = $_SESSION["excepcion"];
unset($_SESSION["excepcion"]);
}else{
  $excepcion ="";
  Header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Error</title>
</head>

<body>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
        <div class="cuerpo col-10">
            <div class="peta">
              <p><?php echo $excepcion ?></p>

            </div>

           <a class="btn btn-secundary" href="index.php">Volver al inicio</a>
        </div>
   </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
