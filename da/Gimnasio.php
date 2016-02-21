<?php

require_once('conexion.php');

class Gimnasio{

	function getGimnasios($idGimnasio){
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		//generamos la consulta
		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idGimnasio!=0)
		{
			$sql="select Nombre, Estatus from Gimnasio where G_Id='$idGimnasio'";
		}
		else
		{
			$sql="select Nombre  from Gimnasio";
		}

		if(!$result = mysqli_query($conexion, $sql)) die(); //si la conexión cancelar programa
		$rawdata = array(); //creamos un array
		//guardamos en un array multidimensional todos los datos de la consulta
		if($result!=null){
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$rawdata[$i] = $row;
				$i++;

			}

		}
		desconectar($conexion); //desconectamos la base de datos
		return json_encode($rawdata); //devolvemos el array
	}

    	function getConfiguracionByGymId($idGimnasio){
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();
        if ($conexion){  // Checamos que la conexión se haya realizado correctamente

		//generamos la consulta
		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

        $sql="SELECT C_Id, G_Id, Logo, ColorFondo, ColorComplementario, ColorFuenteTitulo, ColorFuenteTexto, TipoFuente FROM Configuracion where G_Id='$idGimnasio'";

                if($result = mysqli_query($conexion, $sql))
                {
                    if($result!=null){
                        if ($result->num_rows>0){

                            $response["configuracion"] = array();
                            while($row = mysqli_fetch_array($result))
                            {
                                $item = array();
                                $item["C_Id"]=$row["C_Id"];
                                $item["G_Id"]=$row["G_Id"];

                                $item["Logo"]=$row["Logo"];
                                if ($item["Logo"]==NULL){$item["Logo"]='';}

                                $item["ColorFondo"]=$row["ColorFondo"];
                                if ($item["ColorFondo"]==NULL){$item["ColorFondo"]='';}

                                $item["ColorComplementario"]=$row["ColorComplementario"];
                                if ($item["ColorComplementario"]==NULL){$item["ColorComplementario"]='';}

                                $item["ColorFuenteTitulo"]=$row["ColorFuenteTitulo"];
                                if ($item["ColorFuenteTitulo"]==NULL){$item["ColorFuenteTitulo"]='';}

                                $item["ColorFuenteTexto"]=$row["ColorFuenteTexto"];
                                if ($item["ColorFuenteTexto"]==NULL){$item["ColorFuenteTexto"]='';}

                                $item["TipoFuente"]=$row["TipoFuente"];
                                if ($item["TipoFuente"]==NULL){$item["TipoFuente"]='';}

                                array_push($response["configuracion"], $item);
                            }
                            $response["success"]=0;
                            $response["message"]='Consulta exitosa';
                        }
                        else{
                            $response["success"]=1;
                            $response["message"]='No se encontró una configuración para el gimnasio indicado';
                        }

                    }
                    else
                        {
                            $response["success"]=1;
                            $response["message"]='No se encontró una configuración para el gimnasio indicado';
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
		return $response; //devolvemos el array
	}
}

// $G = new Gimnasio();
// $Gyms=$G->getConfiguracionByGymId(1);
// echo json_encode($Gyms);

?>
