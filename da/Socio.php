<?php

require_once('conexion.php');

class Socio{

	function getSocioByIdUsuarioIdGym($idUsuario,$idGym){ // Esta función nos regresa los socios que esten asociados a un usuario/gymnasio (en teoría sólo debe haber un registro así)
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
		{
			$sql= "SELECT UG_Id, IdUsuario, IdGym, So_Id, socio.Estatus, id_Sucursal as sucursal  FROM usuariogimnasio join socio on UG_Id=Id_UsuarioGym
            where IdUsuario='$idUsuario' and IdGym='$idGym'";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["socios"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["Id"]=$row["UG_Id"];
                            $item["IdUsuario"]=$row["IdUsuario"];
                            $item["IdGym"]=$row["IdGym"];
                            $item["IdSocio"]=$row["So_Id"];
                            $item["Estatus"]=$row["Estatus"];
                            $item["IdSucursal"]=$row["sucursal"];

                            array_push($response["socios"], $item);
                        }
                        $response["success"]=1;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=0;
                        $response["message"]='No existe un socio registrado del usuario en el gimnasio indicado';
                    }

                }
                else
                    {
                        $response["success"]=0;
                        $response["message"]='No existe un socio registrado del usuario en el gimnasio indicado';
                    }
            }
            else
            {
                $response["success"]=0;
                $response["message"]='Se presento un error al ejecutar la consulta';
            }

        }
		else
		{
                $response["success"]=0;
                $response["message"]='El id del usuario debe ser diferente de cero';
		}
		desconectar($conexion); //desconectamos la base de datos
		return ($response); //devolvemos el array
	}



//********************************************************************************************************************
//********************************************************************************************************************
//********************************************************************************************************************


	function getSociosBySucursalId($idSucursal){ // Esta función nos regresa los socios que esten asociados a un usuario/gymnasio (en teoría sólo debe haber un registro así)
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
		$sql= "SELECT ue.Id as UsuarioEnformaId, ug.UG_ID as UsuarioGymId, s.So_Id as SocioId, CodigoEnforma, ue.Nombre as NombreUsuario, Apellidos, Correo, IdFacebook, s.Estatus, ug.IdRol, r.Nombre as NombreRol, Id_Sucursal
	               FROM UsuarioEnforma ue join UsuarioGimnasio ug on ue.id=ug.idUsuario join Rol r on ug.IdRol=r.R_id join socio s on ug.UG_Id=s.Id_UsuarioGym where s.Id_Sucursal=$idSucursal";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["socios"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["UsuarioEnformaId"]=$row["UsuarioEnformaId"];
                            $item["UsuarioGymId"]=$row["UsuarioGymId"];
                            $item["SocioId"]=$row["SocioId"];

                            $item["CodigoEnforma"]=$row["CodigoEnforma"];

                            $item["NombreUsuario"]=$row["NombreUsuario"];
                            if ($item["NombreUsuario"]==NULL){$item["NombreUsuario"]='';}

                            $item["Apellidos"]=$row["Apellidos"];
                            if ($item["Apellidos"]==NULL){$item["Apellidos"]='';}

                            $item["Correo"]=$row["Correo"];
                            if ($item["Correo"]==NULL){$item["Correo"]='';}

                            $item["IdFacebook"]=$row["IdFacebook"];
                            if ($item["IdFacebook"]==NULL){$item["IdFacebook"]='';}

                            $item["Estatus"]=$row["Estatus"];

                            $item["NombreRol"]=$row["NombreRol"];
                            if ($item["NombreRol"]==NULL){$item["NombreRol"]='';}

                            $item["Id_Sucursal"]=$row["Id_Sucursal"];

                            array_push($response["socios"], $item);
                        }
                        $response["success"]=1;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=0;
                        $response["message"]='No existe un socio registrado del usuario en el gimnasio indicado';
                    }

                }
                else
                    {
                        $response["success"]=0;
                        $response["message"]='No existe un socio registrado del usuario en el gimnasio indicado';
                    }
            }
            else
            {
                $response["success"]=0;
                $response["message"]='Se presento un error al ejecutar la consulta';
            }


		desconectar($conexion); //desconectamos la base de datos
		return ($response); //devolvemos el array

    }

//********************************************************************************************************************
//********************************************************************************************************************
//********************************************************************************************************************

function asociarSocioGimnasio($idUsuario, $idGimnasio, $idSucursal){

    //Creamos la conexión con la función anterior
	$conexion = obtenerConexion();

    //generamos la consulta
    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

    /* deshabilitar autocommit */
    if ($conexion){


    mysqli_autocommit($conexion, FALSE);


			$sql="INSERT INTO UsuarioGimnasio (`IdGym`, `IdUsuario`, `Estatus`, `IdRol`) VALUES ($idGimnasio, $idUsuario , '1', '1');";

			if($result = mysqli_query($conexion, $sql)){

                $idUsuarioGym=mysqli_insert_id($conexion);

                $hoy = date("Y-m-d");

                $sql2="INSERT INTO Socio (`Id_Sucursal`, `Id_UsuarioGym`, `FechaIngreso`, `Estatus`) VALUES ($idSucursal, $idUsuarioGym , '$hoy' , '1')";

                if($result = mysqli_query($conexion, $sql2)){

                    mysqli_commit($conexion);

                    $response["socios"]=$this->getSociosBySucursalId($idSucursal);
                    $response["success"]=0;
				    $response["message"]='Socio registrado correctamente';
                }
                else{

                    $response["success"]=5;
					$response["message"]='No se logró registrar correctamente el socio';
                    /* Revertir */
                    mysqli_rollback($link);
                }
            }
			else {
				//return 'El aparato no pudo ser almacenado correctamente';
					$response["success"]=4;
					$response["message"]='No se logró registrar correctamente el UsuarioGym';
                    /* Revertir */
                    mysqli_rollback($link);

				}
		  desconectar($conexion); //desconectamos la base de datos
        }
    else
    {
       	$response["success"]=3;
		$response["message"]='Se presentó un error con la conexión a la BD';
    }
		return  ($response); //devolvemos el array

    }
}


//$UG = new Socio();
//$UGs=$UG->getSociosBySucursalId(2);
//echo json_encode ($UGs);


?>
