<?php
require_once('conexion.php');

class Rutina{

	function getRutinaByIdSocio($idSocio){ // Esta función nos regresa la rutina activa de un socio especifico
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idSocio!=0)
		{
			$sql= "SELECT  R_ID, Nombre, FechaInicio, FechaFin, Estatus, Objetivo, id_Socio, id_Instructor FROM rutina where Estatus=1  and id_Socio=$idSocio order  by FechaInicio desc  LIMIT 1";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["Rutina"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["Id"]=$row["R_ID"];
                            $item["Nombre"]=$row["Nombre"];
                            $item["FechaInicio"]=$row["FechaInicio"];
                            $item["FechaFin"]=$row["FechaFin"];
                            $item["Estatus"]=$row["Estatus"];
                            $item["Objetivo"]=$row["Objetivo"];
                            $item["id_Socio"]=$row["id_Socio"];
                            $item["id_Instructor"]=$row["id_Instructor"];

                            array_push($response["Rutina"], $item);
                        }
                        $response["success"]=1;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=0;
                        $response["message"]='El socio no cuenta con una rutina activa';
                    }

                }
                else
                    {
                        $response["success"]=0;
                        $response["message"]='El socio no cuenta con una rutina activa';
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

 //$Rutina = new Rutina();
 //$RutinaR=$Rutina->getRutinaByIdSocio(29);
 //echo json_encode ($RutinaR);


?>
