DROP SEQUENCE sec_lineaCompra;
DROP SEQUENCE sec_compra;
DROP SEQUENCE sec_producto;
DROP SEQUENCE sec_proveedor;
DROP SEQUENCE sec_almacen;
DROP SEQUENCE sec_combustible;
DROP SEQUENCE sec_itemCompra;
DROP SEQUENCE sec_embarcadero;
DROP SEQUENCE sec_trabajador;
DROP SEQUENCE sec_cliente;

CREATE SEQUENCE sec_cliente;

CREATE OR REPLACE TRIGGER crea_id_cliente
BEFORE INSERT ON clientes
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_cliente.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_C := valorSecuencia;
END;  
/

CREATE SEQUENCE sec_trabajador;

CREATE OR REPLACE TRIGGER crea_id_trabajador
BEFORE INSERT ON trabajadores
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_trabajador.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_T := valorSecuencia;
END;
/

CREATE SEQUENCE sec_embarcadero;

CREATE OR REPLACE TRIGGER crea_id_embarcadero
BEFORE INSERT ON embarcaderos
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_embarcadero.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_E := valorSecuencia;
END;
/

CREATE SEQUENCE sec_itemCompra;

CREATE OR REPLACE TRIGGER crea_id_itemCompra
BEFORE INSERT ON itemCompras
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_itemCompra.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_I := valorSecuencia;
END;  
/

CREATE SEQUENCE sec_combustible;

CREATE OR REPLACE TRIGGER crea_id_combustible
BEFORE INSERT ON combustibles
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_combustible.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_COMB := valorSecuencia;
END;  
/

CREATE SEQUENCE sec_almacen;

CREATE OR REPLACE TRIGGER crea_id_almacen
BEFORE INSERT ON Almacenes
FOR EACH ROW
BEGIN
  SELECT sec_almacen.currval INTO :NEW.Id_A FROM DUAL;
END;
/

CREATE SEQUENCE sec_proveedor;

CREATE OR REPLACE TRIGGER crea_id_proveedores
BEFORE INSERT ON Proveedores
FOR EACH ROW
BEGIN
  SELECT sec_proveedor.CURRVAL INTO :NEW.Id_PRO FROM DUAL;
END;
/

CREATE SEQUENCE sec_producto;

CREATE OR REPLACE TRIGGER crea_id_producto
BEFORE INSERT ON productos
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_producto.currval INTO valorSecuencia FROM DUAL;
  :NEW.Id_P := valorSecuencia;
END;  
/

CREATE SEQUENCE sec_compra;

CREATE OR REPLACE TRIGGER crea_id_compra
BEFORE INSERT ON compras
REFERENCING NEW AS NEW 
FOR EACH ROW 
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_compra.CURRVAL INTO valorSecuencia FROM DUAL;
  :NEW.Id_COM := valorSecuencia;
END;  
/
CREATE SEQUENCE sec_lineaCompra;

CREATE OR REPLACE TRIGGER crea_id_lineaCompra
BEFORE INSERT ON lineaCompras
REFERENCING NEW AS NEW 
FOR EACH ROW
DECLARE valorSecuencia NUMBER := 0;
BEGIN
  SELECT sec_lineaCompra.CURRVAL INTO valorSecuencia FROM DUAL;
  :NEW.Id_L := valorSecuencia;
END;  
