<?php
require_once('conexion.php');

class Subrutina{

	function getsubrutinaByIdRutina($idRutina){ // Esta función nos regresa la subrutina de una rutina especifica (dividida por días)
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idRutina!=0)
		{
			$sql= "SELECT SR_ID, Orden, IdRutina, Nombre FROM Subrutina where idRutina=$idRutina order by Orden ";

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
                $sql= "SELECT SR_ID, Orden, IdRutina, Nombre
                        FROM Subrutina WHERE idRutina =
                            (SELECT R_ID FROM Rutina WHERE Estatus =1 AND id_Socio =
                                (SELECT UG_Id FROM UsuarioGimnasio JOIN Socio ON UG_Id = Id_UsuarioGym WHERE
                                UsuarioGimnasio.Estatus =1 AND Socio.Estatus =1 AND IdUsuario =$idUsuario AND IdGym =$idGym LIMIT 1 )
                            ORDER BY FechaInicio DESC  LIMIT 1 )
                        ORDER BY Orden
                        ";

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

    //***********************************************************************************************************************************

     function getSubRutinaByIdIdUIdGymCompleta($idUsuario,$idGym){// Esta función nos regresa las diferentes subrutinas, de un socio especifico
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
        {
            if ($idGym!=0){
                $sql= "SELECT SR_ID, Orden, IdRutina, Nombre
                        FROM Subrutina WHERE idRutina =
                            (SELECT R_ID FROM Rutina WHERE Estatus =1 AND id_Socio =
                                (SELECT UG_Id FROM UsuarioGimnasio JOIN Socio ON UG_Id = Id_UsuarioGym WHERE
                                UsuarioGimnasio.Estatus =1 AND Socio.Estatus =1 AND IdUsuario =$idUsuario AND IdGym =$idGym LIMIT 1 )
                            ORDER BY FechaInicio DESC  LIMIT 1 )
                        ORDER BY Orden
                        ";

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
                                $detalleSubrutina=$this->getDetalleSubrutina($item["Id"]);
                                $item["Ejercicios"]=$detalleSubrutina;
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

    //***********************************************************************************************************************************

    function getSerieByEjercicioSubrutina($idEjercicio){
        //Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idEjercicio!=0)
		{
			$sql= "SELECT  NumeroSerie, (SELECT ts.Nombre FROM tiposerie ts where ts.TSr_ID=s.id_TipoSerie) as TipoSerie, Repeticiones, PesoPropuesto, (SELECT Abreviatura
                    FROM unidadespeso up where up.UP_ID=s.TipoPeso) as TipoPeso, Observaciones   FROM serie s where id_SubrutinaEjercicio=$idEjercicio;";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["series"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["NumeroSerie"]=$row["NumeroSerie"];
                            $item["TipoSerie"]=$row["TipoSerie"];
                            $item["Repeticiones"]=$row["Repeticiones"];
                            $item["PesoPropuesto"]=$row["PesoPropuesto"];
                            $item["TipoPeso"]=$row["TipoPeso"];
                            $item["Observaciones"]=$row["Observaciones"];

                        array_push($response["series"], $item);
                        }
                        $response["success"]=1;
                        $response["message"]='Consulta exitosa';
                    }
                    else{
                        $response["success"]=0;
                        $response["message"]='El ejercicio no tiene series definidas';
                    }

                }
                else
                    {
                        $response["success"]=0;
                        $response["message"]='El ejercicio no tiene series definidas';
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

    function getDetalleSubrutina ($idSubrutina){// Esta función nos regresa el detalle de ejercicios contenidos en una subrutina
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idSubrutina!=0)
        {
                $sql= "(SELECT SEC_ID as ID, Orden, Id_EjercicioCardio as IdEjercicio,
                            (Select Explicacion from SucursalEjercicioCardio s join EjercicioCardio e on s.Id_EjercicioCardio=e.EC_ID where s.SEC_ID=sec.Id_EjercicioCardio) as Ejercicio,
                            0 as SuperSerie,
                            0 as NumeroSeries,
                            0 as Repeticiones,
                            0 as PesoPropuesto,
                            0 AS UnidadPeso,
                            TiempoTotal,
                            VelocidadPromedio,
                            (select abreviatura from UnidadesVelocidad where UV_ID= sec.TipoDeVelocidad) as UnidadVelocidad,
                            RitmoCardiaco, Observaciones, 0 as TiempoDescansoEntreSerie,
                            1 as TipoDeEjercicio
                        FROM SubRutinaEjercicioCardio sec
                        where Id_Subrutina=$idSubrutina)
                    UNION ALL
                    (Select SEP_ID as ID, Orden, Id_EjercicioPeso as IdEjercicio,
                            (Select Explicacion from SucursalEjercicioPesa s join EjercicioPesa e on s.Id_EjercicioPesa=e.EP_ID where s.SEP_ID=sep.Id_EjercicioPeso) as Ejercicio,
                            SuperSerie,
                            (SELECT COUNT(Sr_ID) FROM Serie where id_SubrutinaEjercicio=SEP_ID) as NumeroSeries,
                            (Select group_concat(Repeticiones) as Repeticiones FROM Serie where id_SubrutinaEjercicio=SEP_ID) as Repeticiones,
                            (Select group_concat(DISTINCT PesoPropuesto) as PesoPropuesto FROM Serie where id_SubrutinaEjercicio=SEP_ID) as PesoPropuesto,
                            (SELECT u.Abreviatura FROM Serie s join UnidadesPeso u ON s.TipoPeso=u.UP_ID where id_SubrutinaEjercicio=10 LIMIT 1) AS UnidadPeso,
                            0 as TiempoTotal, 0 as VelocidadPromedio, 0 as UnidadVelocidad,  0 as RitmoCardiaco, Observaciones, TiempoDescansoEntreSerie,
                            2 as TipoDeEjercicio
                        from SubRutinaEjercicioPeso sep
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
                                $item["SuperSerie"]=$row["SuperSerie"];
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

                                if ($item["TipoDeEjercicio"]==2){ //Si es un ejercicio de pesas, hay que agregar las
                                    $Series=array();
                                    $Series=$this->getSerieByEjercicioSubrutina( $item["IdEjercicio"]);
                                    $item["Series"]=$Series;
                                }

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

    //$Rutina = new Subrutina();
    //$RutinaR=$Rutina->getSubRutinaByIdIdUIdGymCompleta(1,2);
    //echo json_encode ($RutinaR);


?>
