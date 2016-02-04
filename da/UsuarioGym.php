<?php

require_once('conexion.php');

class UsuarioGym{

	function getUsuarioGymByIDU($idUsuario){
		//Creamos la conexión con la función anterior
		$conexion = obtenerConexion();

		mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

		if ($idUsuario!=0)
		{
			$sql="SELECT UG_Id, IdGym, gimnasio.Nombre as Gimnasio, IdUsuario, usuariogimnasio.Estatus, IdRol  FROM usuariogimnasio join gimnasio on usuariogimnasio.IdGym=gimnasio.G_Id where IdUsuario='$idUsuario'";
		}
		else
		{
			$sql="SELECT UG_Id, IdGym, gimnasio.Nombre as Gimnasio, IdUsuario, usuariogimnasio.Estatus, IdRol  FROM usuariogimnasio join gimnasio on usuariogimnasio.IdGym=gimnasio.G_Id;";
		}

		if($result = mysqli_query($conexion, $sql))
		{
            if($result!=null){
                if ($result->num_rows>0){

                    $response["usuarioGyms"] = array();
                    while($row = mysqli_fetch_array($result))
                    {
                        $item = array();
                        $item["Id"]=$row["UG_Id"];
                        $item["IdGym"]=$row["IdGym"];
                        $item["Gimnasio"]=$row["Gimnasio"];
                        $item["IdUsuario"]=$row["IdUsuario"];
                        $item["Estatus"]=$row["Estatus"];
                        $item["IdRol"]=$row["IdRol"];
                        array_push($response["usuarioGyms"], $item);
                    }
                    $response["success"]=1;
                    $response["message"]='Consulta exitosa';
                }
                else{
                    $response["success"]=0;
                    $response["message"]='No se encontró el usuario asociado con algún gimnasio';
                }

            }
            else
                {
                    $response["success"]=0;
                    $response["message"]='No se encontró el usuario asociado con algún gimnasio';
                }
		}
		else
		{
			$response["success"]=0;
			$response["message"]='Se presento un error al ejecutar la consulta';
		}
		desconectar($conexion); //desconectamos la base de datos
		return ($response); //devolvemos el array
	}
}

$UG = new UsuarioGym();
 //echo json_encode($A->updateAparatoByID(14,'Barra yX','Barra yX descripción',1));
// echo json_encode($A->addAparato('TEST EDUARDO EDD','TEST_ 2'));
$UGs=$UG->getUsuarioGymByIDU(0);
//$Aparatos=$A->buscarAparatoPorNombre('BANCO DECLINADO');
echo json_encode ($UGs);


?>
