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


    function getDetalleSubrutina ($idSubrutina){// Esta función nos regresa el detalle de ejercicios contenidos en una subrutina
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idSubrutina!=0)
        {
                $sql= "(SELECT SEC_ID as ID, Orden, Id_EjercicioCardio as IdEjercicio,
                            (Select Explicacion from sucursalejerciciocardio s join ejerciciocardio e on s.Id_EjercicioCardio=e.EC_ID where s.SEC_ID=sec.Id_EjercicioCardio) as Ejercicio,
                            NULL as Id_Superserie,
                            NULL as NumeroSeries,
                            NULL as Repeticiones,
                            NULL as PesoPropuesto,
                            NULL AS UnidadPeso,
                            TiempoTotal,
                            VelocidadPromedio,
                            (select abreviatura from unidadesvelocidad where UV_ID= sec.TipoDeVelocidad) as UnidadVelocidad,
                            RitmoCardiaco, 1 as TipoDeEjercicio
                        FROM subrutinaejerciciocardio sec
                        where Id_Subrutina=$idSubrutina)
                    UNION ALL
                    (Select SEP_ID as ID, Orden, Id_EjercicioPeso as IdEjercicio,
                            (Select Explicacion from sucursalejerciciopesa s join ejerciciopesa e on s.Id_EjercicioPesa=e.EP_ID where s.SEP_ID=sep.Id_EjercicioPeso) as Ejercicio,
                            Id_Superserie,
                            (SELECT COUNT(Sr_ID) FROM serie where id_SubrutinaEjercicio=SEP_ID) as NumeroSeries,
                            (Select group_concat(Repeticiones) as Repeticiones FROM serie where id_SubrutinaEjercicio=SEP_ID) as Repeticiones,
                            (Select group_concat(DISTINCT PesoPropuesto) as PesoPropuesto FROM serie where id_SubrutinaEjercicio=SEP_ID) as PesoPropuesto,
                            (SELECT u.Abreviatura FROM serie s join unidadespeso u ON s.TipoPeso=u.UP_ID where id_SubrutinaEjercicio=10 LIMIT 1) AS UnidadPeso,
                            NULL as TiempoTotal, NULL as VelocidadPromedio, NULL as UnidadVelocidad,  NULL as RitmoCardiaco, 2 as TipoDeEjercicio
                    from subrutinaejerciciopeso sep
                    where Id_Subrutina=$idSubrutina)order by Orden";

                if($result = mysqli_query($conexion, $sql))
                {
                    if($result!=null){
                        if ($result->num_rows>0){

                            $response["ejercicios"] = array();
                            while($row = mysqli_fetch_array($result))
                            {
                                $item = array();
                                $item["ID"]=$row["ID"];
                                $item["Orden"]=$row["Orden"];
                                $item["IdEjercicio"]=$row["IdEjercicio"];
                                $item["Ejercicio"]=$row["Ejercicio"];
                                $item["Id_Superserie"]=$row["Id_Superserie"];
                                $item["NumeroSeries"]=$row["NumeroSeries"];
                                $item["Repeticiones"]=$row["Repeticiones"];
                                $item["PesoPropuesto"]=$row["PesoPropuesto"];
                                $item["UnidadPeso"]=$row["UnidadPeso"];
                                $item["TiempoTotal"]=$row["TiempoTotal"];
                                $item["VelocidadPromedio"]=$row["VelocidadPromedio"];
                                $item["UnidadVelocidad"]=$row["UnidadVelocidad"];
                                $item["RitmoCardiaco"]=$row["RitmoCardiaco"];
                                $item["TipoDeEjercicio"]=$row["TipoDeEjercicio"];
                                //****************************************************

                                $item["Series"]=array();
                                array_push($item["Series"], 1);
                                array_push($item["Series"], 2);
                                array_push($item["Series"], 3);
                                array_push($item["Series"], 4);

                                //****************************************************
                                array_push($response["ejercicios"], $item);
                            }
                            $response["success"]=1;
                            $response["message"]='Consulta exitosa';
                        }
                        else{
                            $response["success"]=0;
                            $response["message"]='No se encontró detalle de la subrutina indicada';
                        }

                    }
                    else
                        {
                            $response["success"]=0;
                            $response["message"]='No se encontró detalle de la subrutina indicada';
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


}

   $Rutina = new Subrutina();
   $RutinaR=$Rutina->getDetalleSubrutina(5);
    echo json_encode ($RutinaR);


?>
