<?php

	// JELM
	// 27/01/2016
	// Creación de archivo PHP, el cual permite obtener acceder a la clase UsuarioEnforma

	$data = json_decode(file_get_contents('php://input'), true);  //Recibimos un objeto json por medio del método POST, y lo decodificamos

	require('../da/UsuarioEnforma.php'); //Se requiere el archivo de acceso a la base de datos

	//Extraemos la información del método POST, y lo asignamos a diferentes variables
	$metodoBl = $data["metodo"];
	$CodigoEnformaBl= $data["CodigoEnforma"];
	$NombreBl= $data["Nombre"];
	$apellidosBl= $data["Apellidos"];
	$correoBl= $data["Correo"];
	$idFacebookBl= $data["IdFacebook"];
	$passwordBl= $data["Password"];
	$estatusBl= $data["Estatus"];

	//$metodoBl='logueoCorreoPassword';
	//$correoBl='PRUEBA338';
	//$passwordBl=NULL;

		function validarTextoNulo($Texto,$Valor){
		if ($Texto!==NULL){
			if (trim($Texto)!=''){
				$Rvalidacion["success"]=1;
			}
			else{
				$Rvalidacion["success"]=0;
				$Rvalidacion["message"]=$Valor.' debe ser diferente de cadena vacia';
			}
		}
		else{
			$Rvalidacion["success"]=0;
			$Rvalidacion["message"]=$Valor.' debe ser diferente de NULO';
		}
		return $Rvalidacion;
	}


	function logueoCorreoPassword($correo,$password){

		$correoValidado= validarTextoNulo($correo, "El correo del usuario");
		if ($correoValidado["success"]==1){
			$passwordValidado= validarTextoNulo($password, "El password del usuario");
			if ($passwordValidado["success"]==1){
				$usuario = new UsuarioEnforma();
				$respuesta= $usuario->buscarUsuarioEnformaCorreoPassword($correo,$password);
			}
			else{$respuesta=$passwordValidado;}
		}
		else{$respuesta=$correoValidado;}
		return $respuesta;
	}


		switch ($metodoBl) {
		case "logueoCorreoPassword": // Mandar cero, para obtener todos los aparatos, o el id del aparatado especifico.
			$response=logueoCorreoPassword($correoBl,$passwordBl);
		break;

		default:
		{
			$response["success"]=0;
			$response["message"]='El método indicado no se encuentra registrado';
		}

	}

	echo json_encode ($response)


?>
