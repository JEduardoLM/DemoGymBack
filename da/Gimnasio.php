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
}

 $G = new Gimnasio();
 $Gyms=$G->getGimnasios(0);
 echo $Gyms;

?>
