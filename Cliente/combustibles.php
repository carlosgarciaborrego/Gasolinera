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
              //Remplazar comas por puntos
              $precioBD =  $data['PRECIO'];
              $precioFormato = str_replace(",",".",$precioBD);

              ?>
              <div class="datosProducto">
                <h2><strong><?php  echo $data['TIPOCOMBUSTIBLE'] ?></strong></h2>
                <hr>
                <div class="stock">
                  Quedan<p class="mostrarValores"><?php echo $data['STOCK']  ?></p> litros en stock.
                </div>
                <div class="cambioCombustible">
                  <form action="combustibles.php?tipo=gasolina" method="get">
                    <h4>Precio a introducir(<?php echo $precioFormato?> €/l):</h4>
                    <!-- Funcion JavaScript para obtener el valor en litros de la cantidad introducida-->
                    <input id="cantidadComb" type="number" step="any" min=1 max=999 value="0" onkeyup="document.getElementById('convertir').innerHTML=conversor(this.value, <?php echo $precioFormato ?>);document.getElementById('cantidadProducto').value=conversor(this.value, <?php echo $precioFormato ?>)"
                     onclick="document.getElementById('convertir').innerHTML=conversor(this.value, <?php echo $precioFormato ?>);document.getElementById('cantidadProducto').value=conversor(this.value, <?php echo $precioFormato ?>)" onkeypress="return pulsar(event)" ><br><br>
                      <h4>Valor en litros: </h4><span id="convertir"><!--En span muestro el valor --></span>L
                </form>


                </div>

                <!-- Donde me dijistes para trabajar-->
                <form  class="botonesCombustible" action="carrito.php" method="post">
                  <button type="submit" name="anadirProducto" class="btn btn-primary">Añadir al carrito</button>
                  <a href="categoriaFiltro.php" class="btn btn-secundary">Volver Atrás</a>
                  <input type="number" id="idProducto" name="idProducto" value="<?php echo $data["ID_COMB"] ?>" style="display:none"/>
                  <input type="text" id="imagenProducto" name="imagenProducto" value="<?php echo $producto["imagenProducto"] ?>" style="display:none"/>
                  <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $data['TIPOCOMBUSTIBLE'] ?>" style="display:none"/>
                  <input type="number" id="precioProducto" name="precioProducto" value="<?php echo  $precioFormato ?>" style="display:none"/>
                  <input type="text" id="cantidadProducto" name="cantidadProducto" value="0" style="display:none"/>
                  <input type="number" id="stockProducto" name="stockProducto" value="<?php echo  str_replace(",",".",$data["STOCK"]); ?>" style="display:none"/>


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
