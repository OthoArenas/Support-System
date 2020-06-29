<?php
session_start();

if (isset($_POST['login']) && $_POST['login'] !== '') {

	//Contiene las variables de configuracion para conectar a la base de datos
	include "../config/config.php";

	$email = mysqli_real_escape_string($con, (strip_tags($_POST["email"], ENT_QUOTES)));
	$password = mysqli_real_escape_string($con, (strip_tags($_POST['password'], ENT_QUOTES)));

	$query_email = mysqli_query($con, "SELECT * FROM user WHERE email ='$email' OR username = '$email' ");
	$row_email = mysqli_fetch_assoc($query_email);

	if (!$row_email) {
		$invalid = sha1(md5("El usuario ingresado no se encuentra en nuestra Base de Datos. Puede registrarse dando click al botón \"Registrarse\"."));
		header("location: ../index.php?invalid=$invalid");
	} else {
		$query_active = mysqli_query($con, "SELECT * FROM user WHERE email =\"$email\" AND is_active = 1 OR username=\"$email\" AND is_active = 1 ;");
		$row_active = mysqli_fetch_assoc($query_active);
		if (!$row_active) {
			$invalid = sha1(md5("El usuario ingresado no se encuentra Activo. Por favor verifique su correo electrónico para la activación o póngase en contacto con el administrador."));
			header("location: ../index.php?invalid=$invalid");
		} else {
			$query = mysqli_query($con, "SELECT * FROM user WHERE email =\"$email\" OR username=\"$email\" ;");
			$result = mysqli_fetch_assoc($query);
			$dbPassword = $result['password'];

			if (!password_verify($password, $dbPassword)) {
				$invalid = sha1(md5("contraseña y/o email incorrectos"));
				header("location: ../index.php?invalid=$invalid");
			} else {
				$_SESSION['user_id'] = $result['id'];
				header("location: ../dashboard.php");
			}
		}
	}
} else {
	header("location: ../");
}
