
CREATE procedure crearCliente(

In p_nombre varchar(100),
in p_direccion varchar(100),
in p_noTelefono varchar(15),
in P_sexo enum(9),
in p_ingresosAnuales int

)
begin
 If exists ( select 1 from Clientes c where c.noTelefono = p_noTelefono ) then
 select 'Numero de telefo existente' as Mensaje ;
  else
  
  

INSERT INTO clientes (

    nombre,
    direccion,
    noTelefono,
    sexo,
    ingresosAnuales
  )
VALUES (
    p_nombre,
    p_direccion,
    p_noTelefono,
    P_sexo,
    p_ingresosAnuales
    
  );
  end if;

end
