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


}

// $UG = new Socio();
// $UGs=$UG->getSocioByIdUsuarioIdGym(2,2);
// echo json_encode ($UGs);


?>
