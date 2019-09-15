-- PROCEDIMIENTOS - CUERPOS --

--Clientes
CREATE OR REPLACE PACKAGE BODY Pruebas_clientes IS

  PROCEDURE inicializar
  IS BEGIN
    DELETE FROM clientes;
  END inicializar;
  
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_nombre IN clientes.nombre%TYPE, w_apellidos IN clientes.apellidos%TYPE,
  w_dni IN clientes.dni%TYPE, w_telefono IN clientes.telefono%TYPE, w_correo IN clientes.correo%TYPE, w_fechaNacimiento IN clientes.fechaNacimiento%TYPE,
  w_contrasena IN clientes.contrasena%TYPE, w_token IN clientes.token%TYPE ,salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    cliente clientes%ROWTYPE;
    w_Id_C NUMBER;
    BEGIN
      /*Insertar clientes*/ 
      INSERT INTO clientes
      VALUES (sec_cliente.nextval,w_nombre,w_apellidos,w_dni,w_telefono,w_correo,w_fechaNacimiento,w_contrasena,w_token);
      /*Seleccionar cliente y comprobar que los datos se insertaron correctamente*/
      w_Id_C := sec_cliente.currval;
      SELECT * INTO cliente FROM clientes WHERE Id_C = w_Id_C;
      IF(cliente.nombre<>w_nombre OR cliente.apellidos<>w_apellidos OR cliente.dni<>w_dni OR cliente.telefono<>w_telefono OR cliente.correo<>w_correo 
      OR cliente.fechaNacimiento<>w_fechaNacimiento OR cliente.contrasena<>w_contrasena OR cliente.token<>w_token) THEN
        salida := false;
      END IF;  
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
      ROLLBACK;
  END insertar;

  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_Id_C IN clientes.Id_C%TYPE, w_nombre IN clientes.nombre%TYPE, w_apellidos IN clientes.apellidos%TYPE,
  w_dni IN clientes.dni%TYPE, w_telefono IN clientes.telefono%TYPE, w_correo IN clientes.correo%TYPE, w_fechaNacimiento IN clientes.fechaNacimiento%TYPE,
  w_contrasena IN clientes.contrasena%TYPE, w_token IN clientes.token%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    cliente clientes%ROWTYPE;
    BEGIN
      /*Actualizar clientes*/
      UPDATE clientes SET nombre = w_nombre, apellidos = w_apellidos, dni = w_dni, telefono = w_telefono, correo = w_correo, fechaNacimiento = w_fechaNacimiento, contrasena = w_contrasena, token = w_token
      WHERE Id_C = w_Id_C;
      /*Seleccionar cliente y comprobar que los campos se actualizan correctamente*/
      SELECT * INTO cliente FROM clientes WHERE Id_C = w_Id_C;
      IF (cliente.nombre<>w_nombre OR cliente.apellidos<>w_apellidos OR cliente.dni<>w_dni OR cliente.telefono<>w_telefono OR cliente.correo<>w_correo 
      OR cliente.fechaNacimiento<>w_fechaNacimiento OR cliente.contrasena<>w_contrasena OR cliente.token<>w_token) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
   END actualizar;
   
   PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_C IN CLIENTES.ID_C%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_clientes INTEGER;
    BEGIN
      /*Eliminar clientes*/
      DELETE FROM clientes WHERE Id_C=w_Id_C;
      /*Verificar que el clientes no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_clientes FROM clientes WHERE Id_C=w_Id_C;
      IF(n_clientes<>0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
   END eliminar;     
END Pruebas_clientes;  
/

--Trabajadores
CREATE OR REPLACE PACKAGE BODY pruebas_trabajadores AS

PROCEDURE inicializar AS
BEGIN
    /* Borrar contenido de la tabla */
    DELETE FROM trabajadores;
END inicializar;


PROCEDURE insertar
 (nombre_prueba       VARCHAR2,
 w_nombre            IN trabajadores.nombre%TYPE,
 w_apellidos         IN trabajadores.apellidos%TYPE,
 w_dni               IN trabajadores.dni%TYPE,
 w_telefono          IN trabajadores.telefono%TYPE,
 w_salario           IN trabajadores.salario%TYPE,
 w_tipoEmpleado      IN trabajadores.tipoEmpleado%TYPE,
 w_contrasena        IN trabajadores.contrasena%TYPE,
 salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
trabajador trabajadores%ROWTYPE;
w_id_T INTEGER;

BEGIN
    
    /* Insertar trabajador */
    INSERT INTO trabajadores 
    VALUES(sec_trabajador.nextval, w_nombre, w_apellidos, w_dni, w_telefono, w_salario, w_tipoEmpleado, w_contrasena);
    
    /* Seleccionartrabajador y comprobar que los datos se insertan correctamente */
    w_id_T := sec_trabajador.currval;
    SELECT * INTO trabajador FROM trabajadores WHERE id_T=w_id_T;
    IF (trabajador.nombre<>w_nombre OR
    trabajador.apellidos<>w_apellidos OR
    trabajador.dni<>w_dni OR
    trabajador.telefono<>w_telefono OR
    trabajador.salario<>w_salario OR
    trabajador.tipoEmpleado<>w_tipoEmpleado OR
    trabajador.contrasena<>w_contrasena) THEN
        salida := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END insertar;



PROCEDURE actualizar
 (nombre_prueba       VARCHAR2,
  w_id_T              IN trabajadores.id_T%TYPE,
  w_nombre            IN trabajadores.nombre%TYPE,
  w_apellidos         IN trabajadores.apellidos%TYPE,
  w_dni               IN trabajadores.dni%TYPE,
  w_telefono          IN trabajadores.telefono%TYPE,
  w_salario           IN trabajadores.salario%TYPE,
  w_tipoEmpleado      IN trabajadores.tipoEmpleado%TYPE,
  w_contrasena        IN trabajadores.contrasena%TYPE,
  salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
trabajador trabajadores%ROWTYPE;

BEGIN
    
    /* Actualizar trabajador */
    UPDATE trabajadores SET nombre=w_nombre                        WHERE id_T=w_id_T;
    UPDATE trabajadores SET apellidos=w_apellidos                  WHERE id_T=w_id_T;
    UPDATE trabajadores SET dni=w_dni                              WHERE id_T=w_id_T;
    UPDATE trabajadores SET telefono=w_telefono                    WHERE id_T=w_id_T;
    UPDATE trabajadores SET salario=w_salario                      WHERE id_T=w_id_T;
    UPDATE trabajadores SET tipoEmpleado=w_tipoEmpleado            WHERE id_T=w_id_T;
    UPDATE trabajadores SET contrasena=w_contrasena                WHERE id_T=w_id_T;
    
    /* Seleccionar trabajador y comprobar que los campos se han actualizado correctamente */
    SELECT * INTO trabajador FROM trabajadores WHERE id_T=w_id_T;
    IF(trabajador.nombre<>w_nombre OR
    trabajador.apellidos<>w_apellidos OR
    trabajador.dni<>w_dni OR
    trabajador.telefono<>w_telefono OR
    trabajador.salario<>w_salario OR
    trabajador.tipoEmpleado<>w_tipoEmpleado OR
    trabajador.contrasena<>w_contrasena) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END actualizar;


PROCEDURE eliminar
 (nombre_prueba       VARCHAR2,
  w_id_T              IN trabajadores.id_T%TYPE,
  salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
n_trabajadores INTEGER;

BEGIN

    /* Eliminar empleado */
    DELETE FROM trabajadores WHERE id_T=w_id_T;
    
    /* Verificar que el trabajador no se encuentra en la BD */
    SELECT COUNT (*) INTO n_trabajadores FROM trabajadores WHERE id_T=w_id_T;
    IF(n_trabajadores<>0) THEN
      SALIDA := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END eliminar;

END pruebas_trabajadores;
/

--Embarcaderos
CREATE OR REPLACE PACKAGE BODY pruebas_embarcaderos AS

PROCEDURE inicializar AS
BEGIN
    /* Borrar contenido de la tabla */
    DELETE FROM embarcaderos;
END inicializar;


PROCEDURE insertar
 (nombre_prueba      VARCHAR2,
 w_disponible        IN embarcaderos.disponible%TYPE,
 salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
embarcadero embarcaderos%ROWTYPE;
w_id_E INTEGER;

BEGIN
    
    /* Insertar embarcadero */
    INSERT INTO embarcaderos 
    VALUES(sec_embarcadero.nextval, w_disponible);
    
    /* Seleccionartrabajador y comprobar que los datos se insertan correctamente */
    w_id_E := sec_embarcadero.currval;
    SELECT * INTO embarcadero FROM embarcaderos WHERE id_E=w_id_E;
    IF (embarcadero.disponible<>w_disponible) THEN
        salida := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END insertar;



PROCEDURE actualizar
 (nombre_prueba       VARCHAR2,
  w_id_E              IN embarcaderos.id_E%TYPE,
  w_disponible        IN embarcaderos.disponible%TYPE,
  salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
embarcadero embarcaderos%ROWTYPE;

BEGIN
    
    /* Actualizar trabajador */
    UPDATE embarcaderos SET disponible=w_disponible            WHERE id_E=w_id_E;
    
    /* Seleccionar trabajador y comprobar que los campos se han actualizado correctamente */
    SELECT * INTO embarcadero FROM embarcaderos WHERE id_E=w_id_E;
    IF(embarcadero.disponible<>w_disponible) THEN
      salida := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END actualizar;


PROCEDURE eliminar
 (nombre_prueba       VARCHAR2,
  w_id_E              IN embarcaderos.id_E%TYPE,
  salidaEsperada      BOOLEAN)
AS

salida BOOLEAN := true;
n_embarcaderos INTEGER;

BEGIN

    /* Eliminar empleado */
    DELETE FROM embarcaderos WHERE id_E=w_id_E;
    
    /* Verificar que el trabajador no se encuentra en la BD */
    SELECT COUNT (*) INTO n_embarcaderos FROM embarcaderos WHERE id_E=w_id_E;
    IF(n_embarcaderos<>0) THEN
      SALIDA := false;
    END IF;
    COMMIT WORK;
    
/* Mostrar resultados de la prueba */
DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
EXCEPTION
WHEN OTHERS THEN 
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
    ROLLBACK;
END eliminar;

END pruebas_embarcaderos;
/ 

--ItemCompras
CREATE OR REPLACE PACKAGE BODY Pruebas_ITEMCOMPRAS IS

  PROCEDURE inicializar
  IS BEGIN
    DELETE FROM itemCompras;
  END inicializar;
  
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_stock IN ITEMCOMPRAS.STOCK%TYPE, w_precio IN ITEMCOMPRAS.PRECIO%TYPE, w_TipoCategoria IN ITEMCOMPRAS.TIPOCATEGORIA%TYPE ,salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    itemCompra itemCompras%ROWTYPE;
    w_Id_I NUMBER;
    BEGIN
      /*Insertar itemCompra*/ 
      INSERT INTO ItemCompras
      VALUES (sec_itemCompra.nextval,w_stock,w_precio,w_TipoCategoria);
      /*Seleccionar cliente y comprobar que los datos se insertaron correctamente*/
      w_Id_I := sec_itemCompra.currval;
      SELECT * INTO itemCompra FROM itemCompras WHERE Id_I = w_Id_I;
      IF(itemCompra.stock<>w_stock OR itemCompra.precio<>w_precio OR itemCompra.TipoCategoria<>w_TipoCategoria) THEN
        salida := false;
      END IF;  
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
      ROLLBACK;
  END insertar;

  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_ID_I IN ITEMCOMPRAS.ID_I%TYPE, w_stock IN ITEMCOMPRAS.STOCK%TYPE, w_precio IN ITEMCOMPRAS.PRECIO%TYPE, w_TipoCategoria IN ITEMCOMPRAS.TIPOCATEGORIA%TYPE ,salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    itemCompra itemCompras%ROWTYPE;
    BEGIN
      /*Actualizar itemCompras*/
      UPDATE itemCompras SET stock=w_stock, precio=w_precio, TipoCategoria=w_TipoCategoria WHERE Id_I = w_Id_I;
      /*Seleccionar itemCompra y comprobar que los campos se actualizan correctamente*/
      SELECT * INTO itemCompra FROM itemCompras WHERE Id_I = w_Id_I;
      IF (itemCompra.stock<>w_stock OR itemCompra.precio<>w_precio OR itemCompra.TipoCategoria<>w_TipoCategoria) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
   END actualizar;
   
   PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_I IN ITEMCOMPRAS.ID_I%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_itemCompras INTEGER;
    BEGIN
      /*Eliminar clientes*/
      DELETE FROM itemCompras WHERE Id_I=w_Id_I;
      /*Verificar que el itemCompras no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_itemCompras FROM itemCompras WHERE Id_I=w_Id_I;
      IF(n_itemCompras<>0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
   END eliminar;     
END Pruebas_ITEMCOMPRAS;  
/


--Combustible
CREATE OR REPLACE PACKAGE BODY Pruebas_COMBUSTIBLES IS

  PROCEDURE inicializar
  IS BEGIN
    DELETE FROM combustibles;
  END inicializar;
  
  PROCEDURE insertar (nombre_prueba VARCHAR2, w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE, w_ID_I IN COMBUSTIBLES.ID_I%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    combustible combustibles%ROWTYPE;
    w_Id_COMB NUMBER;
    BEGIN
      /*Insertar COMBUSTIBLE*/ 
      INSERT INTO Combustibles
      VALUES (sec_combustible.nextval,w_tipoCombustible,w_ID_I);
      /*Seleccionar combustible y comprobar que los datos se insertaron correctamente*/
      w_Id_COMB := sec_combustible.currval;
      SELECT * INTO combustible FROM combustibles WHERE Id_COMB = w_Id_COMB;
      IF(combustible.tipoCombustible<>w_tipoCombustible OR combustible.ID_I<>w_ID_I) THEN
        salida := false;
      END IF;  
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
      ROLLBACK;
  END insertar;

  PROCEDURE actualizar(nombre_prueba  VARCHAR2, w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE,w_TipoCombustible IN COMBUSTIBLES.TIPOCOMBUSTIBLE%TYPE, w_ID_I IN COMBUSTIBLES.ID_I%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    combustible combustibles%ROWTYPE;
    BEGIN
      /*Actualizar combustible*/
      UPDATE combustibles SET tipoCombustible=w_tipoCombustible, ID_I=w_ID_I WHERE Id_COMB = w_Id_COMB;
      /*Seleccionar combustible y comprobar que los campos se actualizan correctamente*/
      SELECT * INTO combustible FROM combustibles WHERE Id_COMB = w_Id_COMB;
      IF (combustible.tipoCombustible<>w_tipoCombustible OR combustible.ID_I<>w_ID_I) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
   END actualizar;
   
   PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_COMB IN COMBUSTIBLES.ID_COMB%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_combustibles INTEGER;
    BEGIN
      /*Eliminar clientes*/
      DELETE FROM combustibles WHERE Id_COMB=w_Id_COMB;
      /*Verificar que el combustibles no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_combustibles FROM combustibles WHERE Id_COMB=w_Id_COMB;
      IF(n_combustibles<>0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
   END eliminar;     
END Pruebas_COMBUSTIBLES;  
/


--Almacenes
CREATE OR REPLACE
PACKAGE BODY pruebas_almacenes AS
  /*Inicializacion*/
  PROCEDURE inicializar AS
  BEGIN 
    /*Borrar contenido de la tabla*/
    DELETE FROM almacenes;
  END inicializar;
  /*Prueba para la insercion de almacenes*/
  PROCEDURE insertar 
   (nombre_prueba VARCHAR2,
   w_direccion in almacenes.direccion%TYPE,
   w_ciudad in almacenes.ciudad%TYPE,
   w_provincia in almacenes.provincia%TYPE,
   salidaEsperada BOOLEAN) AS
  
   salida BOOLEAN :=true;
   almacen almacenes%ROWTYPE;
   w_id_a INTEGER;
  BEGIN
  
    /*Insertar almacen*/
    INSERT INTO almacenes VALUES (sec_almacen.NEXTVAL, w_direccion, w_ciudad, w_provincia);
    
    /*Seleccionar almacen y comprobar que los datos se insertaron bien*/
    w_id_a := sec_almacen.currval;
    SELECT * INTO almacen FROM almacenes WHERE id_a = w_id_a;
    IF (almacen.direccion<>w_direccion
      OR almacen.ciudad<>w_ciudad
      OR almacen.provincia<> w_provincia)THEN
      salida:=false;
    END IF;
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
      ROLLBACK;
  END insertar;
  /*Prueba para la actualizacion de almacenes*/
  PROCEDURE actualizar (nombre_prueba VARCHAR2,
    w_id_a in almacenes.id_a%TYPE,
    w_direccion in almacenes.direccion%TYPE,
    w_ciudad in almacenes.ciudad%TYPE,
    w_provincia in almacenes.provincia%TYPE,
    salidaEsperada BOOLEAN) AS
    
    almacen almacenes%ROWTYPE;
    salida BOOLEAN :=true;
  BEGIN
    /*Actualizar almacen*/
    UPDATE almacenes SET direccion = w_direccion, ciudad = w_ciudad, provincia = w_provincia
      WHERE id_a = w_id_a;
    /*Seleccionar almacen y comprobar que los campos se actualizaron correctamente*/
    SELECT * INTO almacen FROM almacenes WHERE id_a = w_id_a;
    IF (almacen.direccion<>w_direccion OR almacen.ciudad<>w_ciudad OR almacen.provincia<>w_provincia)
      THEN salida := false;
    END IF;
    COMMIT WORK;
      /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
      ROLLBACK;
  END actualizar;
  /*Prueba para la eliminacion de almacenes*/
  PROCEDURE eliminar (nombre_prueba VARCHAR2,
    w_id_a in almacenes.id_a%TYPE,
    salidaEsperada BOOLEAN) AS
    
    salida BOOLEAN := true;
    n_almacenes INTEGER;
  BEGIN
    /*Eliminar almacen*/
    DELETE FROM almacenes WHERE id_a = w_id_a;
    /*Verificar que el almacen no se encuentre en la bd*/
    SELECT COUNT (*) INTO n_almacenes FROM almacenes WHERE id_a = w_id_a;
    IF (n_almacenes<> 0) 
      THEN salida :=true ; 
    END IF;
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
          ROLLBACK;
  END eliminar;

END;
/

--Proveedores
CREATE OR REPLACE
PACKAGE BODY pruebas_proveedores AS
  /*Inicializacion*/
  PROCEDURE inicializar AS
  BEGIN 
    /*Borrar contenido de la tabla*/
    DELETE FROM proveedores;
  END inicializar;
  /*Prueba para la insercion de proveedores*/
  PROCEDURE insertar 
   (nombre_prueba VARCHAR2,
   w_nombre in proveedores.nombre%TYPE,
    w_apellidos in proveedores.apellidos%TYPE,
    w_dni in proveedores.dni%TYPE,
    w_telefono in proveedores.telefono%TYPE,
    w_correo in proveedores.correo%TYPE,
   salidaEsperada BOOLEAN) AS
  
   salida BOOLEAN :=true;
   proveedor proveedores%ROWTYPE;
   w_id_pro INTEGER;
  BEGIN
  
    /*Insertar proveedor*/
    INSERT INTO proveedores VALUES (sec_proveedor.nextval, w_nombre, w_apellidos, w_dni, w_telefono, w_correo);
    
    /*Seleccionar almacen y comprobar que los datos se insertaron bien*/
    w_id_pro := sec_proveedor.currval;
    SELECT * INTO proveedor FROM proveedores WHERE id_pro = w_id_pro;
    IF (proveedor.nombre<>w_nombre
      OR proveedor.apellidos<>w_apellidos
      OR proveedor.dni<> w_dni
      OR proveedor.telefono<>w_telefono
      OR proveedor.correo<>w_correo)THEN
      salida:=false;
    END IF;
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
      ROLLBACK;
  END insertar;
  /*Prueba para la actualizacion de proveedores*/
  PROCEDURE actualizar (nombre_prueba VARCHAR2,
    w_id_pro in proveedores.id_pro%TYPE,
    w_nombre in proveedores.nombre%TYPE,
    w_apellidos in proveedores.apellidos%TYPE,
    w_dni in proveedores.dni%TYPE,
    w_telefono in proveedores.telefono%TYPE,
    w_correo in proveedores.correo%TYPE,
    salidaEsperada BOOLEAN) AS
    proveedor proveedores%ROWTYPE;
    salida BOOLEAN := true;
  BEGIN
    /*Actualizar proveedor*/
    UPDATE proveedores SET nombre = w_nombre, apellidos = w_apellidos, dni = w_dni, telefono = w_telefono, correo = w_correo
      WHERE id_pro = w_id_pro;
    /*Seleccionar proveedor y comprobar que los campos se actualizaron correctamente*/
    SELECT * INTO proveedor FROM proveedores WHERE id_pro = w_id_pro;
    IF (proveedor.nombre<>w_nombre
      OR proveedor.apellidos<>w_apellidos
      OR proveedor.dni<> w_dni
      OR proveedor.telefono<>w_telefono
      OR proveedor.correo<>w_correo)
        THEN salida:=false;
    END IF;
    COMMIT WORK;
     /*Mostrar resultado de la prueba*/
   DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salidaEsperada));
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
      ROLLBACK;
  END actualizar;
  /*Prueba para la eliminacion de proveedores*/
  PROCEDURE eliminar (nombre_prueba VARCHAR2,
    w_id_pro in proveedores.id_pro%TYPE,
    salidaEsperada BOOLEAN) AS
    
    salida BOOLEAN := true;
    n_proveedores INTEGER;
  BEGIN
    /*Eliminar proveedor*/
    DELETE FROM proveedores WHERE id_pro = w_id_pro;
    /*Verificar que el proveedor no se encuentre en la bd*/
    SELECT COUNT (*) INTO n_proveedores FROM proveedores WHERE id_pro = w_id_pro;
    IF (n_proveedores<> 0) 
      THEN salida :=false;
    END IF;
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
    EXCEPTION
    WHEN OTHERS THEN
          DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false, salidaEsperada));
          ROLLBACK;
  END eliminar;

END;
/

--Productos
CREATE OR REPLACE PACKAGE BODY Pruebas_PRODUCTOS IS

  PROCEDURE inicializar
  IS BEGIN
    DELETE FROM productos;
  END inicializar;
  
  PROCEDURE insertar (nombre_prueba VARCHAR2,w_nombre IN PRODUCTOS.NOMBRE%TYPE, w_codigo IN PRODUCTOS.CODIGO%TYPE, w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE, w_ID_I IN PRODUCTOS.ID_I%TYPE, w_ID_A IN PRODUCTOS.ID_A%TYPE, w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    producto productos%ROWTYPE;
    w_Id_P NUMBER;
    BEGIN
      /*Insertar productos*/ 
      INSERT INTO productos
      VALUES (sec_producto.nextval,w_nombre,w_codigo,w_direccionImagen,w_ID_I,w_ID_A,w_ID_PRO);
      /*Seleccionar productos y comprobar que los datos se insertaron correctamente*/
      w_Id_P := sec_producto.currval;
      SELECT * INTO producto FROM productos WHERE Id_P = w_Id_P;
      IF(producto.nombre<>w_nombre OR producto.codigo<>w_codigo OR producto.direccionImagen<>w_direccionImagen OR producto.ID_I<>w_ID_I OR producto.ID_A<>w_ID_A OR producto.ID_PRO<>w_ID_PRO) THEN
        salida := false;
      END IF;  
    COMMIT WORK;
    
    /*Mostrar resultado de la prueba*/
    DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
    
    EXCEPTION
    WHEN OTHERS THEN
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
      ROLLBACK;
  END insertar;

  PROCEDURE actualizar(nombre_prueba VARCHAR2,w_ID_P IN PRODUCTOS.ID_P%TYPE,w_nombre IN PRODUCTOS.NOMBRE%TYPE, w_codigo IN PRODUCTOS.CODIGO%TYPE, w_direccionImagen IN PRODUCTOS.DIRECCIONIMAGEN%TYPE, w_ID_I IN PRODUCTOS.ID_I%TYPE, w_ID_A IN PRODUCTOS.ID_A%TYPE, w_ID_PRO IN PRODUCTOS.ID_PRO%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    producto productos%ROWTYPE;
    BEGIN
      /*Actualizar productos*/
      UPDATE productos SET nombre=w_nombre, codigo=w_codigo, direccionImagen=w_direccionImagen, ID_I=w_ID_I , ID_A=w_ID_A, ID_PRO=w_ID_PRO WHERE Id_P = w_Id_P;
      /*Seleccionar productos y comprobar que los campos se actualizan correctamente*/
      SELECT * INTO producto FROM productos WHERE Id_P = w_Id_P;
      IF (producto.nombre<>w_nombre OR producto.codigo<>w_codigo OR producto.direccionImagen<>w_direccionImagen OR producto.ID_I<>w_ID_I OR producto.ID_A<>w_ID_A OR producto.ID_PRO<>w_ID_PRO) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
   END actualizar;
   
   PROCEDURE eliminar(nombre_prueba VARCHAR2, w_ID_P IN PRODUCTOS.ID_P%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_productos INTEGER;
    BEGIN
      /*Eliminar productos*/
      DELETE FROM productos WHERE Id_P=w_Id_P;
      /*Verificar que el producto no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_productos FROM productos WHERE Id_P=w_Id_P;
      IF(n_productos<>0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
   END eliminar;     
END Pruebas_PRODUCTOS;  
/

--Compras
CREATE OR REPLACE PACKAGE BODY Pruebas_Compras IS
  
  PROCEDURE inicializar
  IS BEGIN
    DELETE FROM compras;
  END inicializar;
 
  PROCEDURE insertar(nombre_prueba VARCHAR2,w_fechaPedido IN COMPRAS.FECHAPEDIDO%TYPE, w_fechaRecogida IN compras.fechaRecogida%TYPE, w_Pagado IN compras.pagado%TYPE, w_preparado IN compras.preparado%TYPE ,w_Id_C IN compras.Id_C%TYPE, w_Id_T IN compras.Id_T%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    compra compras%ROWTYPE;
    w_Id_COM NUMBER;
    BEGIN
    
      /*Insertar compra*/
       INSERT INTO Compras VALUES (sec_compra.nextval,w_fechaPedido,w_fechaRecogida,W_Pagado,w_preparado,w_Id_C,w_Id_T);
 
      /*Seleccionar compra y comprobar que los datos se insertaron correctamente*/
      w_Id_COM := sec_compra.currval;
      SELECT * INTO compra FROM compras WHERE Id_COM = w_Id_COM;
      IF(compra.fechaPedido<>w_fechaRecogida OR compra.fechaRecogida<>w_fechaRecogida OR compra.pagado<>w_pagado OR compra.preparado<>w_preparado OR compra.Id_C<>w_Id_C OR compra.Id_T<>w_Id_T)THEN
        salida := true;
      END IF;  
      COMMIT WORK;
  
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
  END insertar;
  
  PROCEDURE actualizar(nombre_prueba VARCHAR2,w_Id_COM IN Compras.Id_COM%TYPE, w_fechaPedido IN COMPRAS.FECHAPEDIDO%TYPE, w_fechaRecogida IN compras.fechaRecogida%TYPE, w_Pagado IN compras.pagado%TYPE, w_preparado IN compras.preparado%TYPE ,w_Id_C IN compras.Id_C%TYPE, w_Id_T IN compras.Id_T%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    compra compras%ROWTYPE;
    BEGIN
      /*Actualizar compra*/
      UPDATE Compras SET fechaPedido = w_fechaPedido, fechaRecogida = w_fechaRecogida, Pagado =w_pagado, Preparado = w_preparado ,Id_C = w_Id_C, Id_T = w_Id_T WHERE Id_COM = w_Id_COM;
      
      /*Seleccionar compra y comprobar que los campos se actualizan correctamente*/
      SELECT * INTO compra FROM compras WHERE Id_COM = w_Id_COM;
      IF(compra.fechaPedido<>w_fechaRecogida OR compra.fechaRecogida<>w_fechaRecogida OR compra.pagado<>w_pagado OR compra.preparado<>w_preparado OR compra.Id_C<>w_Id_C OR compra.Id_T<>w_Id_T)THEN
        salida := true;
      END IF;  
      COMMIT WORK; 

     /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
  END actualizar;
  
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_COM IN compras.Id_COM%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_compras INTEGER;
    BEGIN
    
      /*Eliminar compra*/
      DELETE FROM compras WHERE Id_COM = w_Id_COM;
      
      /*Verificar que la compra no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_compras FROM compras WHERE Id_COM=w_Id_COM;
      IF(n_compras<>0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida,salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
   END eliminar;     
      
END Pruebas_Compras;
/
--LineaCompras
CREATE OR REPLACE PACKAGE BODY Pruebas_lineaCompras IS

  PROCEDURE inicializar IS
    BEGIN 
      /*borrar contenido de la tabla*/
      DELETE FROM lineaCompras;
  END inicializar;  
  
  PROCEDURE insertar(nombre_prueba VARCHAR2,  w_cantidad IN lineaCompras.cantidad%TYPE, w_Id_I IN lineaCompras.Id_I%TYPE,w_Id_COM IN lineaCompras.Id_COM%TYPE, salida_esperada BOOLEAN) IS
    salida BOOLEAN := true;
    lineaCompra lineaCompras%ROWTYPE;
    w_Id_L NUMBER;
    BEGIN
      /*Insertar lineaCompra*/
      INSERT INTO lineaCompras VALUES(sec_lineaCompra.nextval,w_cantidad, w_Id_I, w_Id_COM);
      
      /*Seleccionar lineaCompra y comprobar que los datos se insertaron correctamente*/
      w_Id_L := sec_lineaCompra.currval;
      SELECT * INTO lineaCompra FROM lineaCompras WHERE Id_L = w_Id_L;
      IF(lineaCompra.cantidad<>w_cantidad OR lineaCompra.Id_I<>w_Id_I OR lineaCompra.Id_COM<>w_Id_COM)THEN
        salida := false;
      END IF;  
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salida_esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
  END insertar;  
  
  PROCEDURE actualizar(nombre_prueba VARCHAR2, w_Id_L IN lineaCompras.Id_L%TYPE, w_cantidad IN lineaCompras.cantidad%TYPE, w_Id_I IN lineaCompras.Id_I%TYPE, w_Id_COM IN lineaCompras.Id_COM%TYPE, salida_esperada BOOLEAN) IS
    salida BOOLEAN := true;
    lineaCompra lineaCompras%ROWTYPE;
    BEGIN
      
      /*Actualizar lineaCompra*/
      UPDATE lineaCompras SET Cantidad = w_cantidad, Id_I =w_Id_I, Id_COM =w_Id_COM WHERE  Id_L = w_Id_L;
      
      /*Seleccionar lineaCompra y comprobar que los campos se actualizaron correctamente*/
      SELECT * INTO lineaCompra FROM lineaCompras WHERE Id_L = w_Id_L;
      IF(lineaCompra.cantidad<>w_cantidad OR lineaCompra.Id_I<>w_Id_I OR lineaCompra.Id_COM<>w_Id_COM)THEN
        salida := false;
      END IF;  
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salida_esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salida_Esperada));
        ROLLBACK;
  END actualizar;
  
  PROCEDURE eliminar(nombre_prueba VARCHAR2, w_Id_L IN lineaCompras.Id_L%TYPE, salida_Esperada BOOLEAN) IS
    salida BOOLEAN := true;
    n_lineaCompras INTEGER;
    BEGIN
    
      /*Eliminar lineaCompra*/
      DELETE FROM lineaCompras WHERE Id_L = w_Id_L;
      
      /*Verificar que la lineaCompra no se encuentra en la BD*/
      SELECT COUNT(*) INTO n_lineaCompras FROM lineaCompras WHERE Id_L = w_Id_L;
      IF(n_lineaCompras <> 0) THEN
        salida := false;
      END IF;
      COMMIT WORK;
      
      /*Mostrar resultado de la prueba*/
      DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salida_Esperada));
      
      EXCEPTION
      WHEN OTHERS THEN
        DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salida_Esperada));
        ROLLBACK;
  END eliminar;
  
END Pruebas_lineaCompras;
/