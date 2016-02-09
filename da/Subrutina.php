<?php
require_once('conexion.php');

class Subrutina{

	function getsubrutinaByIdRutina($idRutina){ // Esta función nos regresa la subrutina de una rutina especifica (dividida por días)
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idRutina!=0)
		{
			$sql= "SELECT SR_ID, Orden, IdRutina, Nombre FROM enforma.subrutina where idRutina=$idRutina order by Orden ";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["subrutinas"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["Id"]=$row["SR_ID"];
                            $item["Orden"]=$row["Orden"];
                            $item["IdRutina"]=$row["IdRutina"];
                            $item["Nombre"]=$row["Nombre"];


                            array_push($response["subrutinas"], $item);
                        }
                        $response["success"]=1;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=0;
                        $response["message"]='La rutina no cuenta con una subrutina definida';
                    }

                }
                else
                    {
                        $response["success"]=0;
                        $response["message"]='La rutina no cuenta con una subrutina definida';
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
                $response["message"]='El id de la subrutina debe ser diferente de cero';
		}
		desconectar($conexion); //desconectamos la base de datos
		return ($response); //devolvemos el array
	}

    function getSubRutinaByIdIdUsuarioIdGym($idUsuario,$idGym){// Esta función nos regresa las diferentes subrutinas, de un socio especifico
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
        {
            if ($idGym!=0){
                $sql= "SELECT SR_ID, Orden, IdRutina, Nombre FROM enforma.subrutina where idRutina=
                           (SELECT  R_ID FROM rutina where Estatus=1  and id_Socio=
                                  (SELECT UG_Id FROM usuariogimnasio join socio on UG_Id=Id_UsuarioGym
                                  where usuariogimnasio.Estatus=1 and  socio.Estatus=1 and IdUsuario='$idUsuario' and IdGym='$idGym' LIMIT 1)
                          order  by FechaInicio desc  LIMIT 1)
                       order by Orden";

                if($result = mysqli_query($conexion, $sql))
                {
                    if($result!=null){
                        if ($result->num_rows>0){

                            $response["subrutinas"] = array();
                            while($row = mysqli_fetch_array($result))
                            {
                                $item = array();
                                $item["Id"]=$row["SR_ID"];
                                $item["Orden"]=$row["Orden"];
                                $item["IdRutina"]=$row["IdRutina"];
                                $item["Nombre"]=$row["Nombre"];


                                array_push($response["subrutinas"], $item);
                            }
                            $response["success"]=1;
                            $response["message"]='Consulta exitosa';
                        }
                        else{
                            $response["success"]=0;
                            $response["message"]='No se encontró una rutina para el usuario y gimnasio indicado';
                        }

                    }
                    else
                        {
                            $response["success"]=0;
                            $response["message"]='No se encontró una rutina para el usuario y gimnasio indicado';
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

  // $Rutina = new Subrutina();
  // $RutinaR=$Rutina->getSubRutinaByIdIdUsuarioIdGym(1,2);
  // echo json_encode ($RutinaR);


?>
