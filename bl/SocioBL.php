<?php


	// JELM
	// 08/02/2016
	// Creación de archivo PHP, el cual permite obtener la información de un socio especifico:
    // Id del socio
    // Rutina
    // Subrutina

	$data = json_decode(file_get_contents('php://input'), true);  //Recibimos un objeto json por medio del método POST, y lo decodificamos

	require('../da/UsuarioGym.php'); //Se requiere el archivo de acceso a la base de datos
    require('../da/Socio.php'); //Se requiere el archivo de acceso a la base de datos
    require('../da/Rutina.php'); //Se requiere el archivo de acceso a la base de datos
    require('../da/Subrutina.php'); //Se requiere el archivo de acceso a la base de datos


	//Extraemos la información del método POST, y lo asignamos a diferentes variables
	$metodoBl = $data["metodo"];
	$idUsuarioBl = $data["idUsuario"];
    $idGimnasioBl = $data["idGimnasio"];
    $idSocioBl = $data["idSocio"];
    $idRutinaBl = $data["idRutina"];



	    // $metodoBl="obtenerGimnasiosDeUsuario";
        // $idUsuarioBl=2;
        // $idGimnasioBl=2;
        // $idSocioBl=2;
        // $idRutinaBl=3;

	function getUsuarioGymByIDU($idUsuario){

        if ($idUsuario!=NULL){  //Validamos que el id envíado sea diferente de NULO

            if (is_numeric($idUsuario)){
                $gymsocio = new UsuarioGym();
                $response= $gymsocio->getUsuarioGymByIDU($idUsuario);

            }
            else
            {
            $response["success"]=5;
			$response["message"]='El id del usuario debe ser un dato numérico';
            }
        }
        else
        {
            $response["success"]=6;
			$response["message"]='El id del usuario debe ser diferente de NULO';
        }
        return $response;

    }

    function getSocioByIdUIdG($idUsuario,$idGym){

        if ($idUsuario!=NULL){  //Validamos que el id envíado sea diferente de NULO
            if ($idGym!=NULL){
                if (is_numeric($idUsuario)){
                    if (is_numeric($idGym)){
                        $socio = new Socio();
                        $response= $socio->getSocioByIdUsuarioIdGym($idUsuario,$idGym);
                    }
                    else
                    {
                        $response["success"]=0;
                        $response["message"]='El id del gimnasio debe ser un dato numérico';
                    }
                }
                else
                {
                    $response["success"]=0;
                    $response["message"]='El id del usuario debe ser un dato numérico';
                }
            }
            else{
                $response["success"]=0;
			     $response["message"]='El id del gimnasio debe ser diferente de NULO';
            }

        }
        else
        {
            $response["success"]=0;
			$response["message"]='El id del usuario debe ser diferente de NULO';
        }
        return $response;
    }

    function getRutinaBySocio($idSocio){
        if ($idSocio!=NULL){  //Validamos que el id envíado sea diferente de NULO

            if (is_numeric($idSocio)){
                $rutina = new Rutina();
                $response= $rutina->getRutinaByIdSocio($idSocio);

            }
            else
            {
            $response["success"]=0;
			$response["message"]='El id del socio debe ser un dato numérico';
            }
        }
        else
        {
            $response["success"]=0;
			$response["message"]='El id del socio debe ser diferente de NULO';
        }
        return $response;
    }

    function getSubrutinasByRutina($idRutina){
        if ($idRutina!=NULL){  //Validamos que el id envíado sea diferente de NULO
            if (is_numeric($idRutina)){
                $subrutina = new subrutina();
                $response= $subrutina->getsubrutinaByIdRutina($idRutina);

            }
            else
            {
                $response["success"]=0;
                $response["message"]='El id de la rutina debe ser un dato numérico';
            }
        }
        else
        {
            $response["success"]=0;
			$response["message"]='El id de la rutina debe ser diferente de NULO';
        }
        return $response;
    }

    function getSubrutinasByIdUsuarioIdGym($idUsuario, $idGym)
    {

        if ($idUsuario!=NULL){  //Validamos que el id envíado sea diferente de NULO
            if ($idGym!=NULL){
                if (is_numeric($idUsuario)){
                    if (is_numeric($idGym)){
                        $subrutina = new Subrutina();
                        $response= $subrutina->getSubRutinaByIdIdUsuarioIdGym($idUsuario,$idGym);
                    }
                    else
                    {
                        $response["success"]=0;
                        $response["message"]='El id del gimnasio debe ser un dato numérico';
                    }
                }
                else
                {
                    $response["success"]=0;
                    $response["message"]='El id del usuario debe ser un dato numérico';
                }
            }
            else{
                $response["success"]=0;
			     $response["message"]='El id del gimnasio debe ser diferente de NULO';
            }

        }
        else
        {
            $response["success"]=0;
			$response["message"]='El id del usuario debe ser diferente de NULO';
        }
        return $response;
    }


    function getSubrutinasByIdUsuarioIdGymCompleta($idUsuario, $idGym)
    {

        if ($idUsuario!=NULL){  //Validamos que el id envíado sea diferente de NULO
            if ($idGym!=NULL){
                if (is_numeric($idUsuario)){
                    if (is_numeric($idGym)){
                        $subrutina = new Subrutina();
                        $response= $subrutina->getSubRutinaByIdIdUIdGymCompleta($idUsuario,$idGym);
                    }
                    else
                    {
                        $response["success"]=0;
                        $response["message"]='El id del gimnasio debe ser un dato numérico';
                    }
                }
                else
                {
                    $response["success"]=0;
                    $response["message"]='El id del usuario debe ser un dato numérico';
                }
            }
            else{
                $response["success"]=0;
			     $response["message"]='El id del gimnasio debe ser diferente de NULO';
            }

        }
        else
        {
            $response["success"]=0;
			$response["message"]='El id del usuario debe ser diferente de NULO';
        }
        return $response;
    }

	switch ($metodoBl) {
		case "obtenerGimnasiosDeUsuario": // Mandar cero, para obtener todos los aparatos, o el id del aparatado especifico.
			$response=getUsuarioGymByIDU($idUsuarioBl);
		break;
		case "obtenerSocioByIdUIdG":
            $response=getSocioByIdUIdG($idUsuarioBl, $idGimnasioBl);
		break;
        case "obtenerRutinaBySocio":
            $response=getRutinaBySocio($idSocioBl);
		break;
        case "ObtenerSubrutinasByRutina":
            $response=getSubrutinasByRutina($idRutinaBl);
		break;
        case "ObtenerSubrutinasByIdU_IdGym":
            $response=getSubrutinasByIdUsuarioIdGym($idUsuarioBl, $idGimnasioBl);
		break;
        case "ObtenerSubrutinasByIdUIdGymCompleta":
            $response=getSubrutinasByIdUsuarioIdGymCompleta($idUsuarioBl, $idGimnasioBl);
		break;
		default:
		{
			$response["success"]=2;
			$response["message"]='El método indicado no se encuentra registrado';
		}

	}

	echo json_encode ($response)




?>
