<?php include __DIR__.'/includes/functions.php' ?>
<?php
session_start();
if(isset($_REQUEST["IdProducto"])){

		$conexion = crearConexionBD();
		$productos = consulta_producto($conexion,$_REQUEST["IdProducto"]);
		foreach ($productos as $p) {
			$producto = $p;
		}
		$items = consulta_itemCompra($conexion,$producto["ID_I"]);
		foreach ($items as $i) {
			$item = $i;
		}
		cerrarConexionBD($conexion);
		if(str_replace(",",".",$item["PRECIO"])<1) $cero = "0";
		else $cero = "";
	}
else{Header("Location: categoriaFiltro.php");}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Index</title>
</head>

<body>
	<?php
	$conexion = crearConexionBD();

	$listaDirec = array();
	$lista = direccionesImagenes($conexion);
	foreach ($lista as $l) {
		array_push($listaDirec, $l["DIRECCIONIMAGEN"]);
	}
	$listaProv = array();
	$lista2 = idsProveedor($conexion);
	foreach ($lista2 as $l) {
		array_push($listaProv, $l["ID_PRO"]);
	}
	$direcActual = $producto["DIRECCIONIMAGEN"];

	cerrarConexionBD($conexion);
	?>
	<script>
		function comprobarEliminacion(){
			$("#eliminar").css('display', 'none');
			$("#trueEliminar").css('display', 'inline-block');
			$("#cancelarEliminar").css('display', 'inline-block');
			$("#pregunta").html("¿ Estas seguro de que quieres eliminar este Producto ?");
		}

		function cancelarEliminacion(){
			$("#eliminar").css('display', 'inline-block');
			$("#trueEliminar").css('display', 'none');
			$("#cancelarEliminar").css('display', 'none');
			$("#pregunta").html("");
		}

		var direcA = '<?php echo $direcActual; ?>';
		var a = <?php echo json_encode($listaDirec);?>;
		var b = <?php echo json_encode($listaProv);?>;
		$(document).ready(function(){
			$("#DireccionImagen").change(function(){
				$("#errorDireccionImagen").html("");
  				$("#boton").prop("disabled",false);
				var valor = this.value;
				a.forEach(function(element) {
					if(valor === element && valor != direcA){
  						$("#errorDireccionImagen").html("{[ La Direccion Imagen ya ha sido usada ]}");
  						$("#boton").prop("disabled",true);
  					}
				});
			});
			$("#Categoria").change(function(){
				var v = this.value;
				if(v != "BEBIDA" && v != "ALIMENTACION" && v != "MECANICA"  && v != "OTROS" && v != "TODOS") {
					$("#errorCategoria").html("{[ La Categoria es erronea ]}");
  					$("#boton").prop("disabled",true);
  				}else {
  					$("#errorCategoria").html("");
  					$("#boton").prop("disabled",false);
  				}
			});
			$("#IDProveedor").change(function(){
				$("#errorIDProveedor").html("{[ El ID de Proveedor no existe ]}");
  				$("#boton").prop("disabled",true);
				var valor = this.value;
				b.forEach(function(element) {
					if(valor === element){
  						$("#errorIDProveedor").html("");
  						$("#boton").prop("disabled",false);
  					}
				});
			});
		});
	</script>
    <?php include __DIR__.'/includes/header.php' ?>
    <div id="wrapper">
      <nav class="nav-Menu col-10">
        <?php include __DIR__.'/includes/navegadorMenu.php' ?>
        <?php include __DIR__.'/includes/navegadorCuenta.php' ?>
      </nav>
      <section  class="section col-10">
        <div class="cuerpo">
            <form class="cuerpoPrin" action='editarProductoAccion.php' method='post'>
            	<input name = "IdProducto"
                    type = "number"
                    value = <?php echo $producto["ID_P"]; ?>
                    style="display:none"
                    required>
            <label>Nombre del Producto:</label>
             <input name = "NombreProducto"
                    type = "text"
                    maxlength = "60"
                    value = <?php echo "'".$producto["NOMBRE"]."'"; ?>
                    title = "Nombre del producto"
                    required>
                    <br>
            <label>Stock :</label>
             <input name = "Stock"
                    type = "number"
                    class = "separador"
                    value = <?php echo $item["STOCK"]; ?>
                    required
                    min = "0"
                    max = "250">
            <label>Precio :</label>
              <input name = "Precio"
                     type = "number"
                     step=".01"
                     value = <?php echo $cero.str_replace(",",".",$item["PRECIO"]); ?>
                     required
                     min = "0"
                     max = "250">
                    <br>
            <label>Categoria:</label>
             <input name = "Categoria"
             		id = "Categoria"
             		type="text"
                    list = "CategoriaList"
                    value=<?php echo $item["TIPOCATEGORIA"]; ?>
                    required>
                    <datalist id="CategoriaList">
					    <option value="BEBIDA">
					    <option value="ALIMENTACION">
					    <option value="MECANICA">
					    <option value="OTROS">
					    <option value="TODOS">
					</datalist>
			</input>
			<p style="color:red;" id="errorCategoria"></p>
            <label>Codigo :</label>
             <input name = "Codigo"
                    type = "text"
                    value = <?php echo "'".$producto["CODIGO"]."'"; ?>
                    maxlength = "35"
                    required>
                    <br>
            <label>Direccion Imagen :</label>
              <input name = "DireccionImagen"
              		id = "DireccionImagen"
                     type = "text"
                     value = <?php echo "'".$producto["DIRECCIONIMAGEN"]."'"; ?>
                     required>
                     <p style="color:red;" id="errorDireccionImagen"></p>
            <label>ID Proveedor :</label>
             <input name = "IDProveedor"
             		id = "IDProveedor"
                    type = "number"
                    value = <?php echo $producto["ID_PRO"]; ?>
                    required>
                    <p style="color:red;" id="errorIDProveedor"></p>
              <button id="boton" type="submit" class="btn btn-primary sep">Editar Producto</button>
              <button type="button" onclick="window.location.href='categoriaFiltro.php'" class="btn btn-secundary sep2">Volver Atras</button>
           </form>
           <button id="eliminar" onclick="comprobarEliminacion()" class="btn btn-secundary sep2">Eliminar Producto</button>
           <p style="color:#208DED;font-weight: bold;" id="pregunta"></p>
           <form action='eliminarProductoAccion.php' method='post'>
           		<input name = "IdProducto"
                    type = "number"
                    value = <?php echo $producto["ID_P"]; ?>
                    style="display:none"
                    required>
            	<button id="trueEliminar" type="submit" class="btn btn-primary sep" style="display: none">Eliminar</button>
            	<button type="button" id="cancelarEliminar" onclick="cancelarEliminacion()" class="btn btn-secundary sep2" style="display: none">Cancelar</button>
           </form>
      </div>
        </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
