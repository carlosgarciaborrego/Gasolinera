-- PAQUETES - CABECERAS--
--Clientes
CREATE OR REPLACE PACKAGE Pruebas_Clientes IS 

  PROCEDURE inicializar;
  
  PROCEDURE insertar(nombre_prueba VARCHAR2, w_nombre IN clientes.nombre%TYPE, w_apellidos IN clientes.apellidos%TYPE, w_dni IN clientes.dni%TYPE, w_telefono IN clientes.telefono%TYPE,
  w_correo IN clientes.correo%TYPE, w_fechaNacimiento IN clientes.fechaNacimiento%TYPE, w_contrasena IN clientes.contrasena%TYPE, w_token IN clientes.token%TYPE , salida_esperada BOOLEAN);

  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_Id_C IN clientes.Id_C%TYPE, w_nombre IN clientes.nombre%TYPE, w_apellidos IN clientes.apellidos%TYPE, w_dni IN clientes.dni%TYPE, w_telefono IN clientes.telefono%TYPE,
  w_correo IN clientes.correo%TYPE, w_fechaNacimiento IN clientes.fechaNacimiento%TYPE, w_contrasena IN clientes.contrasena%TYPE, w_token IN clientes.token%TYPE ,salida_esperada BOOLEAN);
  
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_C IN clientes.Id_C%TYPE, salida_esperada BOOLEAN);

END Pruebas_Clientes;  
/

--Trabajadores
CREATE OR REPLACE PACKAGE pruebas_trabajadores AS
  
  PROCEDURE inicializar;
  
  PROCEDURE insertar
  (nombre_prueba       VARCHAR2,
   w_nombre            IN trabajadores.nombre%TYPE,
   w_apellidos         IN trabajadores.apellidos%TYPE,
   w_dni               IN trabajadores.dni%TYPE,
   w_telefono          IN trabajadores.telefono%TYPE,
   w_salario           IN trabajadores.salario%TYPE,
   w_tipoEmpleado      IN trabajadores.tipoEmpleado%TYPE,
   w_contrasena        IN trabajadores.contrasena%TYPE,
   salidaEsperada      BOOLEAN);

   PROCEDURE actualizar
   (nombre_prueba       VARCHAR2,
   w_id_T               IN trabajadores.id_T%TYPE,
   w_nombre             IN trabajadores.nombre%TYPE,
   w_apellidos          IN trabajadores.apellidos%TYPE,
   w_dni                IN trabajadores.dni%TYPE,
   w_telefono           IN trabajadores.telefono%TYPE,
   w_salario            IN trabajadores.salario%TYPE,
   w_tipoEmpleado       IN trabajadores.tipoEmpleado%TYPE,
   w_contrasena         IN trabajadores.contrasena%TYPE,
   salidaEsperada       BOOLEAN);

   PROCEDURE eliminar
   (nombre_prueba   VARCHAR2,
    w_id_T          IN trabajadores.id_T%TYPE,
   salidaEsperada   BOOLEAN);
 END pruebas_trabajadores;
/

--Embarcaderos
CREATE OR REPLACE PACKAGE pruebas_embarcaderos AS
  
  PROCEDURE inicializar;
  
  PROCEDURE insertar
  (nombre_prueba       VARCHAR2,
   w_disponible        IN embarcaderos.disponible%TYPE,
   salidaEsperada      BOOLEAN);

   PROCEDURE actualizar
   (nombre_prueba       VARCHAR2,
   w_id_E               IN embarcaderos.id_E%TYPE,
   w_disponible         IN embarcaderos.disponible%TYPE,
   salidaEsperada       BOOLEAN);

   PROCEDURE eliminar
   (nombre_prueba      VARCHAR2,
    w_id_E             IN embarcaderos.id_E%TYPE,
   salidaEsperada      BOOLEAN);

   END pruebas_embarcaderos;
/

--ItemCompras
/*create or replace PACKAGE pruebas_itemcompras AS
PROCEDURE eliminar(nombre_prueba VARCHAR2,W_ID_I IN ITEMCOMPRAS.ID_I%TYPE, salidaEsperada BOOLEAN);
PROCEDURE inicializar;
PROCEDURE actualizar
(nombre_prueba VARCHAR2,w_Id_I IN ITEMCOMPRAS.ID_I%TYPE,
w_stock IN ITEMCOMPRAS.STOCK%TYPE,
w_precio IN ITEMCOMPRAS.PRECIO%TYPE,salidaEsperada BOOLEAN);
PROCEDURE insertar
(nombre_prueba VARCHAR2,
w_stock IN ITEMCOMPRAS.STOCK%TYPE,
w_precio IN ITEMCOMPRAS.PRECIO%TYPE,salidaEsperada BOOLEAN);
END pruebas_itemcompras;
*/
CREATE OR REPLACE PACKAGE PRUEBAS_ITEMCOMPRAS IS
  
  PROCEDURE inicializar;
  PROCEDURE insertar(nombre_prueba VARCHAR2, w_stock IN ITEMCOMPRAS.STOCK%TYPE, w_precio IN ITEMCOMPRAS.PRECIO%TYPE, w_TipoCategoria IN ITEMCOMPRAS.TIPOCATEGORIA%TYPE ,salida_Esperada BOOLEAN);
  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_ID_I IN ITEMCOMPRAS.ID_I%TYPE, w_stock IN ITEMCOMPRAS.STOCK%TYPE, w_precio IN ITEMCOMPRAS.PRECIO%TYPE, w_TipoCategoria IN ITEMCOMPRAS.TIPOCATEGORIA%TYPE ,salida_Esperada BOOLEAN);
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_I IN ITEMCOMPRAS.ID_I%TYPE, salida_Esperada BOOLEAN);
  
END PRUEBAS_ITEMCOMPRAS;
/

--Combustibles
/*create or replace PACKAGE pruebas_combustibles AS
PROCEDURE eliminar (nombre_prueba VARCHAR2,w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE,salidaEsperada BOOLEAN);
PROCEDURE inicializar;
PROCEDURE actualizar(nombre_prueba VARCHAR2,w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE,
w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE,
w_ID_I IN COMBUSTIBLES.ID_I%TYPE,salidaEsperada BOOLEAN);
PROCEDURE insertar(nombre_prueba VARCHAR2,
w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE,
w_ID_I IN COMBUSTIBLES.ID_I%TYPE,salidaEsperada BOOLEAN);
END pruebas_combustibles;
/*/

CREATE OR REPLACE PACKAGE PRUEBAS_COMBUSTIBLES IS

  PROCEDURE inicializar;
  PROCEDURE insertar(nombre_prueba VARCHAR2, w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE, w_ID_I IN COMBUSTIBLES.ID_I%TYPE, salida_Esperada BOOLEAN);
  PROCEDURE actualizar(nombre_prueba  VARCHAR2, w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE,w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE, w_ID_I IN COMBUSTIBLES.ID_I%TYPE, salida_Esperada BOOLEAN);
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE, salida_Esperada BOOLEAN);
  
END PRUEBAS_COMBUSTIBLES;
/

--Almacenes
CREATE OR REPLACE 
PACKAGE pruebas_almacenes AS
  PROCEDURE inicializar;
  PROCEDURE insertar
    (nombre_prueba VARCHAR2,
    w_direccion in almacenes.direccion%TYPE,
    w_ciudad in almacenes.ciudad%TYPE,
    w_provincia in almacenes.provincia%TYPE,
    salidaEsperada BOOLEAN);
  PROCEDURE actualizar
    (nombre_prueba VARCHAR2,
    w_id_a in almacenes.id_a%TYPE,
    w_direccion in almacenes.direccion%TYPE,
    w_ciudad in almacenes.ciudad%TYPE,
    w_provincia in almacenes.provincia%TYPE,
    salidaEsperada BOOLEAN);
  PROCEDURE eliminar
  (nombre_prueba VARCHAR2,
  w_id_a in almacenes.id_a%TYPE,
  salidaEsperada BOOLEAN);
END;
/

--Proveedores
CREATE OR REPLACE 
PACKAGE pruebas_proveedores AS
  PROCEDURE inicializar;
  PROCEDURE insertar
    (nombre_prueba VARCHAR2,
    w_nombre in proveedores.nombre%TYPE,
    w_apellidos in proveedores.apellidos%TYPE,
    w_dni in proveedores.dni%TYPE,
    w_telefono in proveedores.telefono%TYPE,
    w_correo in proveedores.correo%TYPE,
    salidaEsperada BOOLEAN);
  PROCEDURE actualizar
    (nombre_prueba VARCHAR2,
    w_id_pro in proveedores.id_pro%TYPE,
    w_nombre in proveedores.nombre%TYPE,
    w_apellidos in proveedores.apellidos%TYPE,
    w_dni in proveedores.dni%TYPE,
    w_telefono in proveedores.telefono%TYPE,
    w_correo in proveedores.correo%TYPE,
    salidaEsperada BOOLEAN);
  PROCEDURE eliminar
  (nombre_prueba VARCHAR2,
  w_id_pro in proveedores.id_pro%TYPE,
  salidaEsperada BOOLEAN);
END;
/

--Productos
/*create or replace PACKAGE pruebas_productos AS
PROCEDURE eliminar (nombre_prueba VARCHAR2,w_ID_P IN PRODUCTOS.ID_P%TYPE, salidaEsperada BOOLEAN);
PROCEDURE inicializar;
PROCEDURE actualizar(nombre_prueba VARCHAR2,w_ID_P IN PRODUCTOS.ID_P%TYPE,
w_nombre IN PRODUCTOS.NOMBRE%TYPE,
w_codigo IN PRODUCTOS.CODIGO%TYPE,
w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE,
w_ID_I IN PRODUCTOS.ID_I%TYPE,
w_ID_A IN PRODUCTOS.ID_A%TYPE,
w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE,salidaEsperada BOOLEAN);
PROCEDURE insertar(nombre_prueba VARCHAR2,
w_nombre IN PRODUCTOS.NOMBRE%TYPE,
w_codigo IN PRODUCTOS.CODIGO%TYPE,
w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE,
w_ID_I IN PRODUCTOS.ID_I%TYPE,
w_ID_A IN PRODUCTOS.ID_A%TYPE,
w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE,salidaEsperada BOOLEAN);
END pruebas_productos;
*/

CREATE OR REPLACE PACKAGE PRUEBAS_PRODUCTOS IS

  PROCEDURE inicializar;
  PROCEDURE insertar(nombre_prueba VARCHAR2,w_nombre IN PRODUCTOS.NOMBRE%TYPE, w_codigo IN PRODUCTOS.CODIGO%TYPE, w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE, w_ID_I IN PRODUCTOS.ID_I%TYPE, w_ID_A IN PRODUCTOS.ID_A%TYPE, w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE, salida_Esperada BOOLEAN);
  PROCEDURE actualizar(nombre_prueba VARCHAR2,w_ID_P IN PRODUCTOS.ID_P%TYPE,w_nombre IN PRODUCTOS.NOMBRE%TYPE, w_codigo IN PRODUCTOS.CODIGO%TYPE, w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE, w_ID_I IN PRODUCTOS.ID_I%TYPE, w_ID_A IN PRODUCTOS.ID_A%TYPE, w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE, salida_Esperada BOOLEAN);
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_P IN PRODUCTOS.ID_P%TYPE, salida_Esperada BOOLEAN);
 
END PRUEBAS_PRODUCTOS; 
/

--Compras
CREATE OR REPLACE PACKAGE Pruebas_Compras IS

  PROCEDURE inicializar;
  
  PROCEDURE insertar(nombre_prueba VARCHAR2, w_fechaPedido IN COMPRAS.FECHAPEDIDO%TYPE, w_fechaRecogida IN compras.fechaRecogida%TYPE, w_Pagado IN compras.pagado%TYPE, w_preparado IN compras.Preparado%TYPE,
  w_Id_C IN compras.Id_C%TYPE, w_Id_T IN compras.Id_T%TYPE, salida_esperada BOOLEAN);
  
  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_Id_COM IN Compras.Id_COM%TYPE, w_fechaPedido IN COMPRAS.FECHAPEDIDO%TYPE, w_fechaRecogida IN compras.fechaRecogida%TYPE,
   w_Pagado IN compras.pagado%TYPE, w_preparado IN compras.Preparado%TYPE ,w_Id_C IN compras.Id_C%TYPE, w_Id_T IN compras.Id_T%TYPE, salida_esperada BOOLEAN);
  
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_COM IN Compras.Id_COM%TYPE, salida_esperada BOOLEAN);
  
END Pruebas_Compras;  
/
--LineaCompras
CREATE OR REPLACE PACKAGE Pruebas_LineaCompras IS

  PROCEDURE inicializar;
  
  PROCEDURE insertar(nombre_prueba VARCHAR2, w_cantidad IN lineaCompras.cantidad%TYPE, w_Id_I IN lineaCompras.Id_I%TYPE,w_Id_COM IN lineaCompras.Id_COM%TYPE, salida_esperada BOOLEAN);
  
  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_Id_L IN lineaCompras.Id_L%TYPE, w_cantidad IN lineaCompras.cantidad%TYPE, w_Id_I IN lineaCompras.Id_I%TYPE,w_Id_COM IN lineaCompras.Id_COM%TYPE, salida_esperada BOOLEAN);
  
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_L IN lineaCompras.Id_L%TYPE, salida_esperada BOOLEAN);
  
END Pruebas_LineaCompras;   
