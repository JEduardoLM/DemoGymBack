<?php

require_once('conexion.php');

class UsuarioGym{

	function getUsuarioGymByIDU($idUsuario){ // Esta función nos regresa todos los registros de usuarioGym, que correspondan a un usuario
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
		{
			$sql="SELECT UG_Id, IdGym, gimnasio.Nombre as Gimnasio, IdUsuario, usuariogimnasio.Estatus, IdRol, rol.Nombre as Rol
            FROM usuariogimnasio join gimnasio on usuariogimnasio.IdGym=gimnasio.G_Id  join  rol on usuariogimnasio.idRol=rol.R_Id
            where IdUsuario='$idUsuario'";
		}
		else
		{
			$sql="SELECT UG_Id, IdGym, gimnasio.Nombre as Gimnasio, IdUsuario, usuariogimnasio.Estatus, IdRol, rol.Nombre as Rol
            FROM usuariogimnasio join gimnasio on usuariogimnasio.IdGym=gimnasio.G_Id join  rol on usuariogimnasio.idRol=rol.R_Id;";
		}

		if($result = mysqli_query($conexion, $sql))
		{
            if($result!=null){
                if ($result->num_rows>0){

                    $response["usuarioGyms"] = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        $item = array();
                        $item["Id"]=$row["UG_Id"];
                        $item["IdGym"]=$row["IdGym"];
                        $item["Gimnasio"]=$row["Gimnasio"];
                        $item["IdUsuario"]=$row["IdUsuario"];
                        $item["Estatus"]=$row["Estatus"];
                        $item["IdRol"]=$row["IdRol"];
                        $item["Rol"]=$row["Rol"];
                        array_push($response["usuarioGyms"], $item);
                    }
                    $response["success"]=1;
                    $response["message"]='Consulta exitosa';
                }
                else{
                    $response["success"]=0;
                    $response["message"]='No se encontró el usuario asociado con algún gimnasio';
                }

            }
            else
                {
                    $response["success"]=0;
                    $response["message"]='No se encontró el usuario asociado con algún gimnasio';
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

    //**********************************************************************

    	function getUsuarioGymByIDU_IDGym($idUsuario,$idGym){ // Esta función nos regresa todos los registros de usuarioGym, que correspondan a un usuario y gimnasio especifico
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
		{
            if ($idGym!=0){
                $sql="SELECT UG_Id, IdGym, gimnasio.Nombre as Gimnasio, IdUsuario, usuariogimnasio.Estatus, IdRol, rol.Nombre as Rol
                FROM usuariogimnasio join gimnasio on usuariogimnasio.IdGym=gimnasio.G_Id  join  rol on usuariogimnasio.idRol=rol.R_Id
                where IdUsuario='$idUsuario' and usuariogimnasio.idGym='$idGym'";

                if($result = mysqli_query($conexion, $sql))
                {
                    if($result!=null){
                        if ($result->num_rows>0){

                            $response["usuarioGyms"] = array();
                            while($row = mysqli_fetch_array($result))
                            {
                                $item = array();
                                $item["Id"]=$row["UG_Id"];
                                $item["IdGym"]=$row["IdGym"];
                                $item["Gimnasio"]=$row["Gimnasio"];
                                $item["IdUsuario"]=$row["IdUsuario"];
                                $item["Estatus"]=$row["Estatus"];
                                $item["IdRol"]=$row["IdRol"];
                                $item["Rol"]=$row["Rol"];
                                array_push($response["usuarioGyms"], $item);
                            }
                            $response["success"]=1;
                            $response["message"]='Consulta exitosa';
                        }
                        else{
                            $response["success"]=0;
                            $response["message"]='No se encontró el usuario asociado con el gimnasio indicado';
                        }

                    }
                    else
                        {
                            $response["success"]=0;
                            $response["message"]='No se encontró el usuario asociado con el gimnasio indicado';
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
                $response["message"]='El id del gimnasio debe ser diferente de cero';
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


}

 $UG = new UsuarioGym();
 $UGs=$UG->getUsuarioGymByIDU_IDGym(3,5);

 echo json_encode ($UGs);


?>
