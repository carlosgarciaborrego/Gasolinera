<?php
session_start();

include __DIR__.'/includes/functions.php';

$conexion = crearConexionBD();

 ?>

 <!--DOCTYPE html-->
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Combustibles</title>
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
          <div class="seleccionCombustible">
            <br>
            <p>Seleccione un tipo de combustible: </p>
            <a href="combustibles.php?tipo=gasolina"> Gasolina </a>
            <a href="combustibles.php?tipo=gasoil"> Gasoil </a>
          </div>
          <?php
          // Declaramos previamente $data, luego le asignamos el TIPOCOMBUSTIBLE = gasolina por defecto
            $data = null;
            $data = elegirCombustible($conexion,'GASOIL');


            if($_GET['tipo'] == NULL || $_GET['tipo'] == 'gasolina') {
              $data = elegirCombustible($conexion,'GASOLINA');
            }

            if(isset($_GET['tipo']) && $_GET['tipo'] == 'gasoil') {
              $data = elegirCombustible($conexion,'GASOIL');
            }

            //Si le entran datos(Si existe en sql datos)
            if($data) {
            ?>
            <div class="bordeProductos">
              <div class="imagenProducto">
                <img src="imagenes/combustibles.jpg">
              </div>
              <?php


              ?>
              <div class="datosProducto">
                <h2><strong><?php  echo $data['TIPOCOMBUSTIBLE'] ?></strong></h2>
                <hr>
                <div class="stock">
                  Quedan<p class="mostrarValores"><?php echo $data['STOCK']  ?></p> litros en stock.
                </div>

              <form action="accion_Combustible.php" method="post">
                <p>Introducir nuevo stock:</p>
              	<input name="nuevoStock" type="number" step="0.1" value=<?php echo $data['STOCK']  ?> required/>
              	<input name="idItem" type="number" value=<?php echo $data['ID_I'] ?> style="display:none" required/>
              	<button type="submit" class="btn btn-primary">Cambiar Stock</button>
              </form>

              </div>
            </div>
            <?php
            }else{
                echo "En estos momentos, nuestros surtidores están vacios. Disculpen las molestias.";
            }
          ?>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
<?php cerrarConexionBD($conexion); ?>
