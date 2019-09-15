create or replace trigger email_clientes
before insert or update of CORREO on CLIENTES
for each row
begin
if (:NEW.CORREO not like '%@%.%' ) 
then raise_application_error(-20001,'El correo debe contener @ y .');
end if;
end;
/
create or replace trigger email_proveedores
before insert or update of CORREO on PROVEEDORES
for each row
begin
if (:NEW.CORREO not like '%@%.%') 
then raise_application_error(-20001,'El correo debe contener @ y .');
end if;
end;
/
create or replace trigger linea_compras_eliminar
after delete on LINEACOMPRAS
for each row
begin
UPDATE ITEMCOMPRAS SET STOCK = STOCK + :OLD.CANTIDAD where ID_I = :OLD.ID_I;
end;
/
create or replace trigger linea_compras_insertar
before insert on LINEACOMPRAS
for each row
declare
stock ITEMCOMPRAS.STOCK%TYPE;
n NUMBER;
idl LINEACOMPRAS.ID_L%TYPE;
begin
select COUNT(*) into n from LINEACOMPRAS where CANTIDAD = 0;
LOOP
if(n<=0)then EXIT; end if;
select ID_L into idl from LINEACOMPRAS where (CANTIDAD = 0 and rownum = 1);
delete from LINEACOMPRAS where ID_L = idl;
n := n-1;
END LOOP;
if(:NEW.CANTIDAD > stock or :NEW.CANTIDAD <= 0) then 
raise_application_error (-20001,'La cantidad de una linea compra no puede ser 0 o superar el stock, actualmente es de '|| stock ||'.');
else UPDATE ITEMCOMPRAS SET STOCK = STOCK - :NEW.CANTIDAD where ID_I = :NEW.ID_I;
end if;
end;
/
create or replace trigger linea_compras_modificar
before update of CANTIDAD on LINEACOMPRAS
for each row
declare
stock ITEMCOMPRAS.STOCK%TYPE;
begin
select STOCK into stock from ITEMCOMPRAS where ID_I = :NEW.ID_I;
if(:NEW.CANTIDAD > stock) then 
raise_application_error (-20001,'La cantidad de una linea compra no puede superar el stock, actualmente es de '|| stock ||'.');
else UPDATE ITEMCOMPRAS SET STOCK = STOCK - (:NEW.CANTIDAD - :OLD.CANTIDAD) where ID_I = :NEW.ID_I;
end if;
end;
/*/
create or replace trigger venta_no_pagada
after update of FECHARECOGIDA on COMPRAS
for each row declare
begin
if(:NEW.FECHARECOGIDA - :NEW.FECHAPEDIDO >=2 and :NEW.PAGADO = 'NO') then
update lineacompras set cantidad = 0 where ID_COMP = :NEW.ID_COMP;
DBMS_OUTPUT.PUT_LINE('Se a cumplido el plazo.');
end if;
end;*/
/
create or replace trigger fecha_nacimiento
before insert or update of FECHANACIMIENTO on CLIENTES
for each row
begin
if (:NEW.FECHANACIMIENTO >= SYSDATE)
then raise_application_error(-20001,'La fecha de nacimiento no puede ser mayor que la fecha actual.');
end if;
end;