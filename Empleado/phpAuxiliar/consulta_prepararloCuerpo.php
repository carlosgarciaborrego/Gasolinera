<?php
   echo "<div class='fechas'>
            <h4> Fecha de Recogida </h4>
            <p class='horaPedido'>".$fechaRecogida."</p>
          </div>
          <div class='datosCliente'>
            <div class='etiqueta'><strong>DATOS DEL CLIENTE</strong></div>
            <table>
                <tr>
                  <td><strong>Nombre:</strong></td>
                  <td class='nombreCliente'>".$cliente["NOMBRE"]."</td>
                </tr>
                <tr>
                  <td><strong>Apellidos:</strong></td>
                  <td class='apellidosCliente'>".$cliente["APELLIDOS"]."</td>
                </tr>
                <tr>
                  <td><strong>DNI:</strong></td>
                  <td class='dniCliente'>".$cliente["DNI"]."</td>
                </tr>
                <tr>
                  <td><strong>Teléfono:</strong></td>
                  <td class='telefonoCliente'>".$cliente["TELEFONO"]."</td>
                </tr>
                <tr>
                  <td><strong>Correo:</strong></td>
                  <td class='emailCliente'>".$cliente["CORREO"]."</td>
                </tr>
            </table>
          </div>
          <div class='listaProductos'>
            <strong>Productos</strong>
            <table>
              <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Precio</th>
              </tr>";
              foreach ($infoCompra as $p) {
              	if(str_replace(",",".",$p["PRECIO"]) < 1) $cero = "0";
				else $cero = "";
				$sumaTotal = $sumaTotal + str_replace(",",".",$p["PRECIO"])* $p["CANTIDAD"];
                  echo "<tr>
                <td><img src=".$p["DIRECCIONIMAGEN"]." alt='Imagen' height='100' width='100'></td>
                <td>".$p["NOMBRE"]."</td>
                <td>".$p["CODIGO"]."</td>
                <td>".$p["CANTIDAD"]."</td>
                <td>".$cero.str_replace(",",".",$p["PRECIO"])." €</td>
              </tr>";
              }
            echo  
            "</table>
            <table class='precioTotal'>
              <tr>
                <td>Precio Total:</td>
                <td>".$sumaTotal." €</td>
              </tr>
            </table>
          </div>";
?>