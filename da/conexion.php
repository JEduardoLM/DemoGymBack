<?php

//require_once('config.php');

	define('SERVIDOR', 'localhost');
	define('USUARIO', 'admin');
	define('CONTRASENA','enforma123');
	define('BASEDEDATOS','enforma');


function obtenerConexion(){

   $conexion = mysqli_connect(SERVIDOR,USUARIO,CONTRASENA,BASEDEDATOS) or die('Unable to Connect');

    if($conexion){
      //  echo 'La conexión de la base de datos se ha hecho satisfactoriamente';
    }
    else{
        echo 'Ha sucedido un error inesperado en la conexión de la base de datos';
    }
    return $conexion;
}

function desconectar($conexion){

    $close = mysqli_close($conexion);

    if($close){
       // echo 'La desconexión de la base de datos se ha hecho satisfactoriamente';
    }
	else{
        echo 'Ha sucedido un error inesperado en la desconexión de la base de datos';
    }

    return $close;
}

?>
