<?php include __DIR__.'/includes/functions.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
   <?php include __DIR__.'/includes/meta.php' ?>
   <title>Index</title>
</head>

<body>
	<?php
	session_start();
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

	cerrarConexionBD($conexion);
	?>
	<script>
		var a = <?php echo json_encode($listaDirec);?>;
		var b = <?php echo json_encode($listaProv);?>;
		$(document).ready(function(){
			$("#DireccionImagen").change(function(){
				$("#errorDireccionImagen").html("");
  				$("#boton").prop("disabled",false);
				var valor = this.value;
				a.forEach(function(element) {
					if(valor === element){
  						$("#errorDireccionImagen").html("{[ La Direccion Imagen ya ha sido usada ]}");
  						$("#boton").prop("disabled",true);
  					}
				});
			});
			$("#Categoria").change(function(){
				var v = this.value;
				if(v != "BEBIDA" && v != "ALIMENTACION" && v != "MECANICA" &&
					 v != "OTROS" && v != "TODOS") {
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
      <section class="section col-10">
        <div class="cuerpo">
            <form class="cuerpoPrin" action='anadirProductoAccion.php' method='post'>
            <label>Nombre del Producto:</label>
             <input name = "NombreProducto"
                    type = "text"
                    maxlength = "35"
                    title = "Nombre del producto"
                    required>
                    <br>
            <label>Stock :</label>
             <input name = "Stock"
                    type = "number"
                    class="separador"
                    required
                    min = "0"
                    max = "250">
            <label>Precio :</label>
              <input name = "Precio"
                     type = "number"
                     step=".01"
                     required
                     min = "0"
                     max = "250">
                    <br>
            <label>Categoria:</label>
             <input name = "Categoria"
             		id = "Categoria"
             		type="text"
                    list = "CategoriaList"
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
                    maxlength = "35"
                    required>
                    <br>
            <label>Direccion Imagen :</label>
              <input name = "DireccionImagen"
              		id = "DireccionImagen"
                     type = "text"
                     required>
                     <p style="color:red;" id="errorDireccionImagen"></p>
            <label>ID Proveedor :</label>
             <input name = "IDProveedor"
             		id = "IDProveedor"
                    type = "number"
                    min = 0
                    required>
                    <p style="color:red;" id="errorIDProveedor"></p>
              <button id="boton" type="submit" class="btn btn-primary sep">Añadir Producto</button>

							<button type="button" onclick="window.location.href='categoriaFiltro.php'" class="btn btn-secundary sep2">Volver Atras</button>
            </form>
        </div>
		  </section>
    </div>
    <?php include __DIR__.'/includes/footer.php' ?>
    <?php include __DIR__.'/includes/js.php' ?>
</body>
</html>
