<?php

// JELM
// 27/01/2016
// Se define la clase UsuarioEnforma, utilizada para acceder a la base de datos y realizar operaciones sobre la tabla Usuario Enforma

require('conexion.php'); //Se requiere el archivo conexión.php, para conectarse a la base de datos

class UsuarioEnforma{

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

	function getUsuarioEnformaByID($idUsuarioEnforma) //Esta función permite consultar la información de un Usuario_Enforma por Id
	{												  // en caso, de que el id sea cero, el sistema regresará todos los Usuarios ENFORMA

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();
		mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8

		if ($idUsuarioEnforma!=0) //Si el id es igual a cero, obtenemos todos Usuarios, en caso contrario, vamos por el UsuarioEnforma especifico.
		{
			$sql="select * from UsuarioEnforma where Id='$idUsuarioEnforma'";
		}
		else
		{
			$sql="select *  from UsuarioEnforma";
		}

		if($result = mysqli_query($conexion, $sql))
		{
		if($result!=null){
			if ($result->num_rows>0){
                    $response["Usuario"] = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        $item = array();
                        $item["Id"]=$row["Id"];
                        $item["CodigoEnforma"]=$row["CodigoEnforma"];
                        $item["Nombre"]=$row["Nombre"];
                        $item["Apellidos"]=$row["Apellidos"];
                        $item["Correo"]=$row["Correo"];
                        $item["idFacebook"]=$row["IdFacebook"];
                        $item["Password"]=$row["Password"];
                        $item["Estatus"]=$row["Estatus"];
                        $response["Usuario"]=$item;
                       // array_push($response["Usuarios"], $item);
                    }
                    $response["success"]=0;
                    $response["message"]='Consulta exitosa';
			}
			else{
				$response["success"]=0;
				$response["message"]='No se encontró UsuarioEnforma con el Id indicado';
			}

		}
		else
			{
				$response["success"]=0;
				$response["message"]='No se encontró UsuarioEnforma con el Id indicado';
			}
		}
		else
		{
			$response["success"]=0;
			$response["message"]='Se presento un error al ejecutar la consulta';
		}

		desconectar($conexion); //desconectamos la base de datos
		return  ($response); //devolvemos el array
	}

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

	function buscarUsuarioEnformaCorreoPassword($correo,$password){

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();

        if ($conexion){
            mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8
            $sql="select * from UsuarioEnforma where Correo='$correo'";

            if($result = mysqli_query($conexion, $sql))
            {
            if($result!=null){
                if ($result->num_rows==1){
                    $response["Usuario"] = array();
                    $bandera=0;
                    while($row = mysqli_fetch_array($result))
                    {
                        $item = array();
                        $item["Id"]=$row["Id"];
                        $item["CodigoEnforma"]=$row["CodigoEnforma"];
                        $item["Nombre"]=$row["Nombre"];
                        $item["Apellidos"]=$row["Apellidos"];
                        $item["Correo"]=$row["Correo"];
                        $item["idFacebook"]=$row["IdFacebook"];
                        $contrasena=$row["Password"];
                        $item["Estatus"]=$row["Estatus"];
                        if ($item["Estatus"]==0){
                            $bandera=1;
                        } elseif ($contrasena!=$password){
                            $bandera=2;
                        }

                    }

                    if ($bandera==0){
                        //array_push($response["Usuarios"], $item);
                        $response["Usuario"]=$item;
                        $response["success"]=0;
                        $response["message"]='Consulta exitosa';

                    }
                    if ($bandera==1){
                        $response["success"]=9;
                        $response["message"]='El Usuario ENFORMA con el correo '.$correo.' no se encuentra activo';
                    }
                    if ($bandera==2){
                        $response["success"]=6;
                        $response["message"]='La contraseña no es correcta';
                    }
                }
                else{
                    $response["success"]=5;
                    $response["message"]='El correo indicado no se encuentra registrado';
                }

            }
            else
                {
                    $response["success"]=5;
                    $response["message"]='El correo indicado no se encuentra registrado';
                }
            }
            else
            {
                $response["success"]=4;
                $response["message"]='Se presento un error al ejecutar la consulta';
            }

            desconectar($conexion); //desconectamos la base de datos
        }
        else
        {

            $response["success"]=3;
			$response["message"]='Se presentó un error en la conexión con la base de datos';
        }

		return  ($response); //devolvemos el array
	}

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

    function buscarUsuarioEnformaCorreo($correo){

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();
        if ($conexion){

            mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8


            $sql="select * from UsuarioEnforma where Correo='$correo'";

            if($result = mysqli_query($conexion, $sql))
            {
                if($result!=null){
                    if ($result->num_rows==1){
                        $response["Usuario"] = array();
                        $bandera=0;
                        while($row = mysqli_fetch_array($result))
                        {
                            $item = array();
                            $item["Id"]=$row["Id"];
                            $item["CodigoEnforma"]=$row["CodigoEnforma"];
                            $item["Nombre"]=$row["Nombre"];
                            $item["Apellidos"]=$row["Apellidos"];
                            $item["Correo"]=$row["Correo"];
                            $item["idFacebook"]=$row["IdFacebook"];
                            $contrasena=$row["Password"];
                            $item["Estatus"]=$row["Estatus"];
                            if ($item["Estatus"]==0){
                                $bandera=1;
                            }

                        }

                        if ($bandera==0){
                            //array_push($response["Usuarios"], $item);
                            $response["Usuario"]=$item;
                            $response["success"]=0;
                            $response["message"]='Consulta exitosa';

                        }
                        if ($bandera==1){
                            $response["success"]=6;
                            $response["message"]='El Usuario ENFORMA con el correo '.$correo.' no se encuentra activo';
                        }

                    }
                    else{
                        $response["success"]=5;
                        $response["message"]='El correo indicado no se encuentra registrado';
                    }

                }
            else
                {
                    $response["success"]=5;
                    $response["message"]='El correo indicado no se encuentra registrado';
                }
            }
            else
            {
                $response["success"]=4;
                $response["message"]='Se presento un error al ejecutar la consulta';
            }

            desconectar($conexion); //desconectamos la base de datos
        }
        else
        {
            $response["success"]=3;
			$response["message"]='Se presentó un error en la conexión con la base de datos';
        }
		return  ($response); //devolvemos el array
	}

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

    function buscarUsuarioEnformaFacebook($facebook){

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();

        if ($conexion){

            mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8


            $sql="select * from UsuarioEnforma where IdFacebook='$facebook'";

            if($result = mysqli_query($conexion, $sql))
            {
            if($result!=null){
                if ($result->num_rows==1){
                    $response["Usuario"] = array();
                    $bandera=0;
                    while($row = mysqli_fetch_array($result))
                    {
                        $item = array();
                        $item["Id"]=$row["Id"];
                        $item["CodigoEnforma"]=$row["CodigoEnforma"];
                        $item["Nombre"]=$row["Nombre"];
                        $item["Apellidos"]=$row["Apellidos"];
                        $item["Correo"]=$row["Correo"];
                        $item["idFacebook"]=$row["IdFacebook"];
                        $contrasena=$row["Password"];
                        $item["Estatus"]=$row["Estatus"];
                        if ($item["Estatus"]==0){
                            $bandera=1;
                        }

                    }

                    if ($bandera==0){
                        $response["Usuario"]=$item;
                        //array_push($response["Usuarios"], $item);
                        $response["success"]=0;
                        $response["message"]='Consulta exitosa';

                    }
                    if ($bandera==1){
                        $response["success"]=6;
                        $response["message"]='El Usuario ENFORMA con el id de facebook: '.$facebook.' no se encuentra activo';
                    }

                }
                else{
                    $response["success"]=5;
                    $response["message"]='El id de facebook indicado no se encuentra registrado';
                }

            }
            else
                {
                    $response["success"]=5;
                    $response["message"]='El id de facebook indicado no se encuentra registrado';
                }
            }
            else
            {
                $response["success"]=4;
                $response["message"]='Se presentó un error al ejecutar la consulta';
            }

            desconectar($conexion); //desconectamos la base de datos
            }
        else
        {
            $response["success"]=3;
            $response["message"]='Se presentó un error en la conexión con la base de datos';
        }
		return  ($response); //devolvemos el array
	}

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

    function validarFacebookRepetido($facebook)
    {

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();
		mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8

        $sql="select * from UsuarioEnforma where idFacebook='$facebook'";

		if($result = mysqli_query($conexion, $sql))
		{
            if($result!=null){
                if ($result->num_rows!=0){
                        $response["success"]=10;
                        $response["message"]='El facebook '.$facebook.' ya se encuentra registrado';
                }
                else{
                    $response["success"]=0;
                    $response["message"]='El facebook se encuentra disponible';
                }

            }
            else
                {
                    $response["success"]=0;
                    $response["message"]='El facebook se encuentra disponible';
                }
		}
		else
		{
			$response["success"]=4;
			$response["message"]='Se presentó un error al ejecutar la consulta';
		}

		desconectar($conexion); //desconectamos la base de datos
		return  ($response); //devolvemos el array
    }

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************

        function validarCorreoRepetido($correo)
    {

		//Creamos la conexión a la base de datos
		$conexion = obtenerConexion();
		mysqli_set_charset($conexion, "utf8"); //Formato de datos utf8


		$sql="select * from UsuarioEnforma where Correo='$correo'";

		if($result = mysqli_query($conexion, $sql))
		{
            if($result!=null){
                if ($result->num_rows!=0){
                        $response["success"]=9;
                        $response["message"]='El correo '.$correo.' ya se encuentra registrado';


                }
                else{
                    $response["success"]=0;
                    $response["message"]='El correo se encuentra disponible';
                }

            }
            else
                {
                    $response["success"]=0;
                    $response["message"]='El correo se encuentra disponible';
                }
		}
		else
		{
			$response["success"]=4;
			$response["message"]='Se presento un error al ejecutar la consulta';
		}

		desconectar($conexion); //desconectamos la base de datos

		return  ($response); //devolvemos el array
    }

	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
    function addUsuarioEnforma($nombre,$apellido,$correo, $facebook, $password)
	{
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();
 		//generamos la consulta
		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

			$sql=$conexion->prepare("CALL nuevoUsuario(?,?,?,?,?);");
			$sql->bind_param("sssss",$nombre,$apellido,$correo, $facebook, $password);

            if ($sql->execute()){
                $response["Usuario"]= array();
                $arregloUsuarios=$this->getUsuarioEnformaByID(0);
                $response["Usuario"]=$arregloUsuarios["Usuario"];
                $response["success"]=1;
                $response["message"]='Usuario almacenado correctamente';

            }
			else {
				    //return 'El Usuario no pudo ser almacenado correctamente';
					$response["success"]=0;
					$response["message"]='El Usuario no pudo ser almacenado correctamente';

				}
		desconectar($conexion); //desconectamos la base de datos
		return  ($response); //devolvemos el array

	}

   	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
	//******************************************************************************************************************************************************
    function RegistroUsuarioEnforma($nombre,$apellido,$correo, $facebook, $password)
	{
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();
 		//generamos la consulta
        if ($conexion){


		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

			$sql=$conexion->prepare("CALL nuevoUsuario(?,?,?,?,?);");
			$sql->bind_param("sssss",$nombre,$apellido,$correo, $facebook, $password);

            if ($sql->execute()){

                $sql->close();

                $response["Usuario"]= array();
                $arregloUsuarios=$this->buscarUsuarioEnformaCorreo($correo);
                $response["Usuario"]=$arregloUsuarios["Usuario"];
                $response["success"]=0;
                $response["message"]='Usuario almacenado correctamente';

            }
			else {
				    //return 'El Usuario no pudo ser almacenado correctamente';
					$response["success"]=4;
					$response["message"]='El Usuario no pudo ser almacenado correctamente';

				}
		desconectar($conexion); //desconectamos la base de datos
        }
        else
        {
           $response["success"]=3;
           $response["message"]='Se presentó un error en la conexión con la base de datos';
        }
		return  ($response); //devolvemos el array

	}


}

    //$UE=new UsuarioEnforma();
	//echo json_encode($UE->getUsuarioEnformaByID(1));
	//echo json_encode($UE->buscarUsuarioEnformaCorreoPassword("PRUEBA311","PRUEBA"));
    //echo json_encode($UE->buscarUsuarioEnformaFacebook("2387320587iutyoiuy387@facebook.com14"));
	//echo json_encode($UE->addUsuarioEnforma('NUEVO Usuario TEST ', 'Romero Luna','TEST.NUEVO.RL@correo.com',NULL, NULL));
    //echo json_encode($UE->validarFacebookRepetido('face1',0));



?>
