<?php

	/*Datos de conexion a la base de datos*/
	define('DB_HOST', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
	define('DB_USER', 'wedding4_dssdb');//Usuario de tu base de datos
	define('DB_PASS', 'Saao911001"!');//Contraseña del usuario de la base de datos
	define('DB_NAME', 'wedding4_Support_System');//Nombre de la base de datos

	$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        @die("<h2 style='text-align:center'>!Imposible conectarse a la base de datos! </h2>".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        @die("Conexi贸n fall贸: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
?>