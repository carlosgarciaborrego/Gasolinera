create or replace FUNCTION ASSERT_EQUALS (salida BOOLEAN, salida_esperada BOOLEAN)
  RETURN VARCHAR2 AS
BEGIN
  IF (salida = salida_esperada) THEN
    RETURN 'EXITO';
  ELSE
    RETURN 'FALLO';
  END IF;
END ASSERT_EQUALS;