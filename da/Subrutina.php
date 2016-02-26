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

        if ($conexion)
        {


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
                            $response["success"]=0;
                            $response["message"]='Consulta exitosa';
                        }
                        else{
                            $response["success"]=1;
                            $response["message"]='No se encontró una rutina para el usuario y gimnasio indicado';
                        }

                    }
                    else
                        {
                            $response["success"]=1;
                            $response["message"]='No se encontró una rutina para el usuario y gimnasio indicado';
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
                $response["message"]='El id del gimnasio debe ser diferente de cero';

            }
        }
		else
		{
            $response["success"]=6;
            $response["message"]='El id del usuario debe ser diferente de cero';

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

    //***********************************************************************************************************************************

    function getSerieByEjercicioSubrutina($idEjercicio){
        //Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

        if ($conexion){


		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idEjercicio!=0)
		{
			$sql= "SELECT NumeroSerie, ( SELECT ts.Nombre FROM TipoSerie ts WHERE ts.TSr_ID = s.id_TipoSerie ) AS TipoSerie,
                            Repeticiones, PesoPropuesto,
                            (SELECT Abreviatura FROM UnidadesPeso up WHERE up.UP_ID = s.TipoPeso ) AS TipoPeso, Observaciones FROM Serie s
                    WHERE id_SubrutinaEjercicio =$idEjercicio;";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows>0){

                        $response["series"] = array();
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
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

                        array_push($response["series"], $item);
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




    function getDetalleSubrutina ($idSubrutina){// Esta función nos regresa el detalle de ejercicios contenidos en una subrutina
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

        if ($conexion){



            mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

            if ($idSubrutina!=0)
            {

                    $sql= "(SELECT sec.SEC_ID as ID, sec.Orden, sec.Id_EjercicioCardio as IdEjercicio,
                            e.Explicacion as NombreEjercicio,
                            sc.Alias as AliasEjercicio,
                            e.CodigoImagen1,
                            e.CodigoImagen2,
                            e.ImagenGenerica1,
                            e.ImagenGenerica2,
                            e.TipoFuenteImagen,
                            0 as Superserie,
                            0 as NumeroSeries,
                            0 as Repeticiones,
                            0 as PesoPropuesto,
                            0 AS UnidadPeso,
                            sec.TiempoTotal,
                            sec.VelocidadPromedio,
                            (select abreviatura from UnidadesVelocidad where UV_ID= sec.TipoDeVelocidad) as UnidadVelocidad,
                            sec.RitmoCardiaco, sec.Nivel, sec.Observaciones, 0 as TiempoDescansoEntreSerie,
                            1 as TipoDeEjercicio
                        FROM SubRutinaEjercicioCardio sec JOIN SucursalEjercicioCardio sc on sec.Id_EjercicioCardio=sc.SEC_ID
                        join EjercicioCardio e on sc.Id_EjercicioCardio=e.EC_ID
                        where Id_Subrutina=$idSubrutina)
                        UNION ALL
                        (Select sep.SEP_ID as ID, sep.Orden, sep.Id_EjercicioPeso as IdEjercicio,
							p.Explicacion as NombreEjercicio,
                            sp.Alias as AliasEjercicio,
                            p.CodigoImagen1,
                            p.CodigoImagen2,
                            p.ImagenGenerica1,
                            p.ImagenGenerica2,
                            p.TipoFuenteImagen,
                            Superserie,
                            (SELECT COUNT(Sr_ID) FROM Serie where id_SubrutinaEjercicio=sep.SEP_ID) as NumeroSeries,
                            (Select group_concat(Repeticiones) as Repeticiones FROM Serie where id_SubrutinaEjercicio=sep.SEP_ID) as Repeticiones,
                            (Select group_concat(DISTINCT PesoPropuesto) as PesoPropuesto FROM Serie where id_SubrutinaEjercicio=sep.SEP_ID) as PesoPropuesto,
                            (SELECT u.Abreviatura FROM Serie s join UnidadesPeso u ON s.TipoPeso=u.UP_ID where id_SubrutinaEjercicio=10 LIMIT 1) AS UnidadPeso,
                            0 as TiempoTotal, 0 as VelocidadPromedio, 0 as UnidadVelocidad,  0 as RitmoCardiaco, 0 as Nivel, Observaciones, TiempoDescansoEntreSerie,
                            2 as TipoDeEjercicio

                    from SubRutinaEjercicioPeso sep JOIN SucursalEjercicioPesa sp on sep.id_EjercicioPeso=sp.SEP_ID
                        join EjercicioPesa p on sp.id_EjercicioPesa=p.EP_ID
                    where Id_Subrutina=$idSubrutina
                    )
                    order by Orden";

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
                                    if ($item["Orden"]==NULL){$item["Orden"]=0;}

                                    $item["IdEjercicio"]=$row["IdEjercicio"];
                                    if ($item["IdEjercicio"]==NULL){$item["IdEjercicio"]=0;}

                                    $item["NombreEjercicio"]=$row["NombreEjercicio"];
                                    if ($item["NombreEjercicio"]==NULL){$item["NombreEjercicio"]='';}

                                    $item["AliasEjercicio"]=$row["AliasEjercicio"];
                                    if ($item["AliasEjercicio"]==NULL){$item["AliasEjercicio"]='';}

                                    $item["CodigoImagen1"]=$row["CodigoImagen1"];
                                    if ($item["CodigoImagen1"]==NULL){$item["CodigoImagen1"]=0;}

                                    $item["CodigoImagen2"]=$row["CodigoImagen2"];
                                    if ($item["CodigoImagen2"]==NULL){$item["CodigoImagen2"]=0;}

                                    $item["ImagenGenerica1"]=$row["ImagenGenerica1"];
                                    if ($item["ImagenGenerica1"]==NULL){$item["ImagenGenerica1"]='';}

                                    $item["ImagenGenerica2"]=$row["ImagenGenerica2"];
                                    if ($item["ImagenGenerica2"]==NULL){$item["ImagenGenerica2"]='';}

                                    $item["TipoFuenteImagen"]=$row["TipoFuenteImagen"];
                                    if ($item["TipoFuenteImagen"]==NULL){$item["TipoFuenteImagen"]='';}

                                    $item["SuperSerie"]=$row["SuperSerie"];
                                    if ($item["SuperSerie"]==NULL){$item["SuperSerie"]=0;}

                                    $item["NumeroSeries"]=$row["NumeroSeries"];
                                    if ($item["NumeroSeries"]==NULL){$item["NumeroSeries"]=0;}

                                    $item["Repeticiones"]=$row["Repeticiones"];
                                    if ($item["Repeticiones"]==NULL){$item["Repeticiones"]=0;}

                                    $item["PesoPropuesto"]=$row["PesoPropuesto"];
                                    if ($item["Repeticiones"]==NULL){$item["Repeticiones"]=0;}

                                    $item["UnidadPeso"]=$row["UnidadPeso"];
                                    if ($item["UnidadPeso"]==NULL){$item["UnidadPeso"]=0;}

                                    $item["TiempoTotal"]=$row["TiempoTotal"];
                                    if ($item["TiempoTotal"]==NULL){$item["TiempoTotal"]=0;}

                                    $item["VelocidadPromedio"]=$row["VelocidadPromedio"];
                                    if ($item["VelocidadPromedio"]==NULL){$item["VelocidadPromedio"]=0;}

                                    $item["UnidadVelocidad"]=$row["UnidadVelocidad"];
                                    if ($item["UnidadVelocidad"]==NULL){$item["UnidadVelocidad"]='';}

                                    $item["RitmoCardiaco"]=$row["RitmoCardiaco"];
                                    if ($item["RitmoCardiaco"]==NULL){$item["RitmoCardiaco"]=0;}

                                    $item["Nivel"]=$row["Nivel"];
                                    if ($item["Nivel"]==NULL){$item["Nivel"]=0;}

                                    $item["Observaciones"]=$row["Observaciones"];
                                    if ($item["Observaciones"]==NULL){$item["Observaciones"]='';}

                                    $item["TipoDeEjercicio"]=$row["TipoDeEjercicio"];
                                    if ($item["TipoDeEjercicio"]==NULL){$item["TipoDeEjercicio"]=0;}
                                    //****************************************************

                                    if ($item["TipoDeEjercicio"]==2){ //Si es un ejercicio de pesas, hay que agregar las
                                        $Series=array();
                                        $Series=$this->getSerieByEjercicioSubrutina( $item["ID"]);
                                        $item["Series"]=$Series;
                                    }

                                    //****************************************************
                                    array_push($response["ejercicios"], $item);
                                }
                                $response["success"]=0;
                                $response["message"]='Consulta exitosa';
                            }
                            else{
                                $response["success"]=1;
                                $response["message"]='No se encontró detalle de la subrutina indicada';
                            }

                        }
                        else
                            {
                                $response["success"]=1;
                                $response["message"]='No se encontró detalle de la subrutina indicada';
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


}

     //$Rutina = new Subrutina();
     //$RutinaR=$Rutina->getSubRutinaByIdIdUIdGymCompleta(1,2);
     //echo json_encode ($RutinaR);


?>
