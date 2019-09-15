<?php if(isset($_SESSION["login"])){
         if($_SESSION["login"]){ ?>

            <ul class="menuMiCuenta">
                <li>
                  <br>
                    <i class="Etiqueta">Mi Cuenta</i>
                </li>
                <br>
                <li>
                  <a href="miCuentaMisDatos.php"><i class="fas fa-address-card"></i> Mis Datos</a>
                </li>
                <li>
                  <a><i class="fas fa-indent"></i> Mis Pedidos</a>
                  <ul class="desplegable">
                    <li><a href="miCuentaActuales.php"><i class="far fa-clock"></i> Actuales</a></li>
                    <li><a href="miCuentaHistorial.php"><i class="fas fa-history"></i> Historial</a></li>
                  </ul>
                </li>
            </ul>

  <?php   }
      } ?>
