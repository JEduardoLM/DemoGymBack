<?php

require_once('conexion.php');

class Instructor{

    function getInsutrctorByIdUsuarioIdGym($idUsuario,$idGym){ // Esta función me permite obtener la información del instructor en base a su idUsuario y idGym
		//Creamos la conexión con la base de datos, (la información se encuentra en el archivo conexion.php)
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
		{
            if ($idGym!=0){
                $sql="SELECT I_ID, FechaIngreso, Matricula, Id_UsuarioGym, Estatus, IdRol FROM Instructor I join UsuarioGimnasio UG on I.Id_UsuarioGym=UG.UG_Id
                where IdUsuario='$idUsuario' and UG.idGym='$idGym'";

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
                            $response["message"]='No se encontró el usuario asociado con el Gimnasio indicado';
                        }

                    }
                    else
                        {
                            $response["success"]=0;
                            $response["message"]='No se encontró el usuario asociado con el Gimnasio indicado';
                        }
                }
                else
                {
                    $response["success"]=0;
                    $response["message"]='Se presentó un error al ejecutar la consulta';
                }
            }
            else
		      {
                $response["success"]=0;
                $response["message"]='El id del Gimnasio debe ser diferente de cero';
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

 // $UG = new UsuarioGym();
 // $UGs=$UG->getUsuarioGymByIDU(2);
 // echo json_encode ($UGs);


?>
