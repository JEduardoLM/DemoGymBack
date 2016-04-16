<?php

	// JELM
	// 08/04/2016
	// Creación de archivo PHP, el cual permite ingresar a las funcionalidades de la aplicación FORZA Instructor

	$data = json_decode(file_get_contents('php://input'), true);  //Recibimos un objeto json por medio del método POST, y lo decodificamos

    // Se indican los archivos PHP que se utilizarán
	require('../da/Rutina.php');
    require('../da/Asesor.php');

	//Extraemos la información del método POST, y lo asignamos a diferentes variables
	$metodoBl = $data["metodo"];
	$idGimnasioBl = $data["IdGym"];
    $idUsuarioBl = $data["IdUsuario"];
    $idSucursalBl = $data["IdSucursal"];

    $idRutinaBl = $data["IdRutina"];
	$idSocioBl = $data["IdSocio"];
    $fechaBl = $data["Fecha"];
    $numeroSemanasBl = $data["NumeroSemanas"];
	$objetivoBl = $data["Objetivo"];
	$idInstructorBl = $data["IdInstructor"];





    //$metodoBl="duplicarRutina";
	//$idGimnasioBl=2;
    //$idUsuarioBl=5;
    //$idSucursalBl=2;
    //$idRutinaBl =3;
	//$idSocioBl = 'asdasd';
    //$fechaBl = '2015-12-14';
    //$numeroSemanasBl = 4;
	//$objetivoBl = NULL;
	//$idInstructorBl = 1;




	//***************************************************************************************************************************************
	//***************************************************************************************************************************************
	//**********                          AQUI INICIA LA DEFINICIÓN DE FUNCIONES DE LA APLICACIÓN DEL INSTRUCTOR                  ***********
	//***************************************************************************************************************************************
	//***************************************************************************************************************************************

        function validarTextoNulo($Texto,$Valor,$numeroError){
		if ($Texto!==NULL){
			if (trim($Texto)!=''){
				$Rvalidacion["success"]=1;
			}
			else{
				$Rvalidacion["success"]=$numeroError+1;
				$Rvalidacion["message"]=$Valor.' debe ser diferente de cadena vacia';
			}
		}
		else{
			$Rvalidacion["success"]=$numeroError;
			$Rvalidacion["message"]=$Valor.' debe ser diferente de NULO';
		}
		return $Rvalidacion;
	}

    //***************************************************************************************************************************************

	function getAsesorByIdUsuarioIdGym ($idGimnasio, $idUsuario)
	{

		if ($idGimnasio!=NULL or $idGimnasio!=0){

            if (is_int($idGimnasio)){
                if ($idGimnasio>=0){

                    //Si el dato de gimnasio se encuentra correctamente, procedemos a validar el id del usuario
                    if ($idUsuario!=NULL or $idUsuario!=0){
                            if (is_int($idUsuario)){
                                    if ($idUsuario>=0){
                                        $asesor = new Asesor();
                                        $response = $asesor->getAsesorByIdUsuarioIdGym($idUsuario,$idGimnasio);
                                    }
                                    else{
                                        $response["success"]=10;
                                        $response["message"]='El id del usuario no puede ser un valor negativo';
                                    }
                                }
                                else {
                                    $response["success"]=9;
                                    $response["message"]='El id del usuario debe ser un valor numérico';
                                }
                            }
                    else {
                                    $response["success"]=8;
                                    $response["message"]='El id del Usuario debe ser diferente de NULO o cero';
                    }


                }
                else{
                    $response["success"]=7;
                    $response["message"]='El id del gimnasio no puede ser un valor negativo';
                }
            }
            else {
                $response["success"]=6;
                $response["message"]='El id del gimnasio debe ser un valor numérico';
            }
        }
        else {
                $response["success"]=5;
                $response["message"]='El id del Gimnasio debe ser diferente de NULO o cero';
        }
		return $response;
	}


	//***************************************************************************************************************************************

	function getRutinasByIdSucursal ($idSucursal)
	{

		if ($idSucursal!=NULL or $idSucursal!=0){

            if (is_int($idSucursal)){
                if ($idSucursal>=0){

                    $rutina = new Rutina();
                    $response = $rutina->getRutinasGenericasBySucursal($idSucursal);


                }
                else{
                    $response["success"]=7;
                    $response["message"]='El id de la sucursal no puede ser un valor negativo';
                }
            }
            else {
                $response["success"]=6;
                $response["message"]='El id de la sucursal debe ser un valor numérico';
            }
        }
        else {
                $response["success"]=5;
                $response["message"]='El id de la sucursal debe ser diferente de NULO o cero';
        }
		return $response;
	}


    //***************************************************************************************************************************************

	function duplicarRutina($idRutina, $idSocio, $fecha, $numeroSemanas, $objetivo, $idInstructor)
	{

		if ($idRutina!=NULL or $idRutina!=0){

            if (is_int($idRutina)){
                if ($idRutina>=0){




                    if ($idSocio!=NULL or $idSocio!=0){

                        if (is_int($idSocio)){
                            if ($idSocio>=0){

                                $rutina = new Rutina();
                                $response = $rutina->duplicarRutina($idRutina, $idSocio, $fecha, $numeroSemanas, $objetivo, $idInstructor);


                            }
                            else{
                                $response["success"]=13;
                                $response["message"]='El id del socio no puede ser un valor negativo';
                            }
                        }
                        else {
                            $response["success"]=12;
                            $response["message"]='El id del socio debe ser un valor numérico';
                        }
                    }
                    else {
                            $response["success"]=11;
                            $response["message"]='El id del socio debe ser diferente de NULO o cero';
                    }



                }
                else{
                    $response["success"]=13;
                    $response["message"]='El id de la rutina no puede ser un valor negativo';
                }
            }
            else {
                $response["success"]=12;
                $response["message"]='El id de la rutina debe ser un valor numérico';
            }
        }
        else {
                $response["success"]=11;
                $response["message"]='El id de la rutina debe ser diferente de NULO o cero';
        }
		return $response;
	}

    //***************************************************************************************************************************************

    function getRutinaById($idRutina){

    }

	//*************************************************************************************************************************************************
	//*************************************************************************************************************************************************
	//** AQUI INICIA EL SWICH UTILIZADO PARA MANDAR A LLAMAR A LAS FUNCIONES DEFINIDAS PREVIAMENTE DE ACUERDO A LO INDICADO EN LA VARIABLE $METODO  ***
	//*************************************************************************************************************************************************
	//*************************************************************************************************************************************************

	switch ($metodoBl) {
		case "getAsesorByIdUsuarioIdGym": // Este método lo utilizaremos para obtener el id del instructor
			$response=getAsesorByIdUsuarioIdGym($idGimnasioBl,$idUsuarioBl);
		break;

        case "getRutinasByIdSucursal": // Este método lo utilizaremos para obtener el id del instructor
			$response=getRutinasByIdSucursal($idSucursalBl);
		break;

        case "duplicarRutina": // Este método lo utilizaremos para obtener el id del instructor
			$response=duplicarRutina($idRutinaBl, $idSocioBl, $fechaBl, $numeroSemanasBl, $objetivoBl, $idInstructorBl);
		break;

		default:
		{
			$response["success"]=2;
			$response["message"]='El método indicado no se encuentra registrado';
		}

	}

	echo json_encode ($response)


?>
