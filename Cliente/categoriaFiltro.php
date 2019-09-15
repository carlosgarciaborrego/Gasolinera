<?php
session_start();

include __DIR__.'/includes/functions.php';

$conexion = crearConexionBD();

$pag_size = 15;
if(isset($_GET['pagina'])){
  $pagina = $_GET['pagina'];
}else{
  $pagina = 1;
}

if(!isset($_SESSION["formularioProducto"])){
  $formularioProducto['imagenProducto'] = "";
  $formularioProducto['nombreProducto'] = "";
  $formularioProducto['precioProducto'] = "";
  $formularioProducto['idProducto'] = "";
  $formularioProducto['stockProducto'] = "";

  $_SESSION['formularioProducto'] = $formularioProducto;
}else
  $formularioProducto = $_SESSION['formularioProducto'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Filtro</title>
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
          <div class="filtro">
            <form action="categoriaFiltro.php" method="get">
              <fieldset>
                <legend><strong>Filtros de búsqueda</strong></legend>
                <label for="busqueda">Buscar: </label>
                <input type="search" name="producto" id="busqueda" value="<?php echo isset($_GET['producto'])? $_GET['producto']: '' ?>"><br>

                <div class="categorias">
                <p>Categorias:</p>
                <!-- No evaluamos el checked, debido a que si existe algun valor acontinuación, html elige siempre la ultima opción-->
                <input type="radio" id="categoria0"  name="categoria" value="todos" checked>
                <label for="categoria1">Todas</label>

                <?php
                  function isChecked($string) {
                    if(isset($_GET['categoria'])) {
                      if($_GET['categoria'] == $string) {
                        return "checked";
                      }
                    }
                  }
                ?>

                <input type="radio" id="categoria1" name="categoria" value="alimentacion" <?php echo isChecked('alimentacion') ?>>
                <label for="categoria1">Alimentación</label>

                <input type="radio" id="categoria2" name="categoria" value="bebida" <?php echo isChecked('bebida') ?>>
                <label for="categoria2">Bebidas</label>

                <input type="radio" id="categoria3" name="categoria" value="mecanica" <?php echo isChecked('mecanica') ?>>
                <label for="categoria4">Mecánica</label>

                <input type="radio" id="categoria4" name="categoria" value="otros" <?php echo isChecked('otros') ?>>
                <label for="categoria5">Otros</label><br><br>
                </div>

                <div class="slidecontainer">
                  <p>Precio máximo:</p>
                  <input type="range" min="1" max="200" value="<?php echo isset($_GET['range'])? $_GET['range']: '50' ?>" class="slider" name="range" id="myRange">
                  <span id="demo"></span> €
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
              </fieldset>
            </form>
          </div>

          <div class="gridProductos">
            <?php

            if(isset($_GET['range'])) {

              $data = buscador($conexion, $pag_size,$pagina)['datos'];

            }else{
              //$data = obtenerProductos($conexion);
              $data = consultarPagina($conexion,$pag_size,$pagina);

            }

            foreach ($data as $producto){

                $mycero = ceroComa($producto['PRECIO']);
                ?>
            <div class="producto">
              <form class="formProducto" action="anadirACarrito.php" method="post">

                <input type="text" id="imagenProducto" name="imagenProducto" value="imagenes/<?php echo $producto["DIRECCIONIMAGEN"]?>.jpg" style="display:none"/>
                  <input type="text" id="nombreProducto" name="nombreProducto" value="<?php echo $producto["NOMBRE"]?>" style="display:none"/>
                  <input type="number" id="idProducto" name="idProducto" value="<?php echo $producto["CODIGO"]?>" style="display:none"/>
                  <input type="number" step="any" id="precioProducto" name="precioProducto" value="<?php echo  str_replace(",",".",$mycero) ?>" style="display:none"/>
                  <input type="number" id="stockProducto" name="stockProducto" value="<?php echo $producto["STOCK"]?>" style="display:none"/>

                  <img class="item" src="imagenes/<?php echo $producto['DIRECCIONIMAGEN'] ?>.jpg" alt="<?php echo $producto['NOMBRE'] ?>">
                  <h4><button type="submit" name="anadir"><i class="fas fa-plus-square"></i></button> <?php echo $producto['NOMBRE']  ?></h4>
                  <h3> <?php  echo $mycero ?></h3>

              </form>
            </div>
            <?php
          }

          if(!$data) {
            ?>
            <div>
              <h5>No hay productos</h5>
            </div>
            <?php
          }
          ?>

          <?php
          if(!isset($_GET['busqueda']) && !isset($_GET['categoria']) && !isset($_GET['range'])){
            $total = totalConsultarPagina($conexion);
            //echo $total;
            $total_paginas = ceil($total/$pag_size);
          ?>
                <div class="paginacion">
                <?php
                  echo "<a>Páginas: </a>";
                  for($i=1; $i<=$total_paginas; $i++){
                    echo "<a href='categoriaFiltro.php?pagina=".$i."'>".$i."</a>";
                  }
                ?>
                </div>
    <?php }else{
              $total = buscador($conexion, $pag_size,$pagina, true);

              $total = $total['datos'];
              $total_paginas = ceil($total/$pag_size);

              ?>
                    <div class="paginacion">
                    <?php
                      echo "<a>Páginas: </a>";
                      for($i=1; $i<=$total_paginas; $i++){

                       $busqueda = empty($_GET['producto']) ? $_GET['producto'] : ' ';

                        echo "<a href='categoriaFiltro.php?producto=".$busqueda."&categoria=".$_GET['categoria']."&range=".$_GET['range']."&pagina=".$i."'>".$i."</a>";
                      }

                      if($total_paginas==0){
                        echo "0";
                      }
                    ?>
                    </div>
      <?php } ?>
            </div>
          </div>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
<?php cerrarConexionBD($conexion); ?>
