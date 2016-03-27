<?php

	// JELM
	// 15/03/2016
	// Se define la clase serie
    //

require_once('conexion.php'); //Se requiere el archivo conexión.php, para conectarse a la base de datos


class Serie{

    function obtenerSerieByID($idSerie)
    {
              //Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

        if ($conexion){


		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idSerie!=0)
		{
			$sql= "SELECT Sr_ID, NumeroSerie, ( SELECT ts.Nombre FROM TipoSerie ts WHERE ts.TSr_ID = s.id_TipoSerie ) AS TipoSerie,
                            Repeticiones, PesoPropuesto,
                            (SELECT Abreviatura FROM UnidadesPeso up WHERE up.UP_ID = s.TipoPeso ) AS TipoPeso, Observaciones FROM Serie s
                    WHERE Sr_ID =$idSerie;";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){


                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["Sr_ID"]=$row["Sr_ID"];

                            $item["NumeroSerie"]=$row["NumeroSerie"];
                            if ($item["NumeroSerie"]==NULL){$item["NumeroSerie"]=0;}

                            $item["TipoSerie"]=$row["TipoSerie"];
                            if ($item["TipoSerie"]==NULL){$item["TipoSerie"]='';}

                            $item["Repeticiones"]=$row["Repeticiones"];
                            if ($item["Repeticiones"]==NULL){$item["Repeticiones"]=0;}

                            $item["PesoPropuesto"]=$row["PesoPropuesto"];
                            if ($item["PesoPropuesto"]==NULL){$item["PesoPropuesto"]=0;}

                            $item["TipoPeso"]=$row["TipoPeso"];
                            if ($item["TipoPeso"]==NULL){$item["TipoPeso"]='';}

                            $item["Observaciones"]=$row["Observaciones"];
                            if ($item["Observaciones"]==NULL){$item["Observaciones"]='';}

                        $response["serie"]= $item;
                        }
                        $response["success"]=0;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=1;
                        $response["message"]='El ejercicio no tiene series definidas';
                    }

                }
                else
                    {
                        $response["success"]=1;
                        $response["message"]='El ejercicio no tiene series definidas';
                    }
            }
            else
            {
                $response["success"]=4;
                $response["message"]='Se presento un error al ejecutar la consulta';
            }

        }
		else
		{
                $response["success"]=5;
                $response["message"]='El id de la subrutina debe ser diferente de cero';
		}
		desconectar($conexion); //desconectamos la base de datos
        }
        else
        {
            $response["success"]=3;
            $response["message"]='Se presentó un error en la conexión con la base de datos';
        }
		return ($response); //devolvemos el array
    }

    function updatePesoEnSerie ($idSerie,$NuevoPeso,$TipoDePeso)
	{
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();
 		//generamos la consulta
        if ($conexion){

            mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
            mysqli_autocommit($conexion, FALSE);

            mysqli_begin_transaction($conexion);
		    $sql="UPDATE `Serie` SET `PesoPropuesto`='$NuevoPeso', `TipoPeso`='$TipoDePeso' WHERE `Sr_ID`='$idSerie'";

			if($result = mysqli_query($conexion, $sql)){
                $hoy = date("Ymd");
                $sql2="INSERT INTO PesoAvances (`Peso`, `TipoPeso`, `id_Serie`,`Fecha`) VALUES ($NuevoPeso, $TipoDePeso, $idSerie, $hoy)";

                if($result = mysqli_query($conexion, $sql2)){
                    mysqli_commit($conexion);
                   // mysqli_close($conexion);

                    $serieDatos=$this->obtenerSerieByID($idSerie);

                    $response["serie"]=$serieDatos["serie"];
                    $response["success"]=0;
				    $response["message"]='Peso almacenado correctamente';
                }

                else{
                mysqli_rollback($conexion);
               // mysqli_close($conexion);
                $response["success"]=5;
				$response["message"]='El peso no pudo ser almacenado correctamente en el histórico';

                }


			}
			else{
                mysqli_rollback($conexion);
                //mysqli_close($conexion);
				$response["success"]=4;
				$response["message"]='El peso no pudo ser actualizado correctamente';

            }
		 desconectar($conexion); //desconectamos la base de datos
        }
        else{
            $response["success"]=3;
			$response["message"]='Se presentó un error al realizar la conexión con la base de datos';

        }
		return  ($response); //devolvemos el array
	}


}



 // $S = new Serie();
 // $Ss=$S->updatePesoEnSerie(5,5,1);
 // echo json_encode ($Ss);


?>
