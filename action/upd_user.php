<?php

//upd user by abisoft https://github.com/amnersaucedososa
session_start();
include("../config/config.php");

$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * FROM user WHERE id=\"$id\";");
while ($row = mysqli_fetch_array($query)) {
	$username = $row['username'];
	$name = $row['name'];
	$lastname = $row['lastname'];
	$is_active = $row['is_active'];
	$rol = $row['rol'];
	$email = $row['email'];
	$profile_pic = $row['profile_pic'];
	$created_at = $row['created_at'];
}

if (!empty($_POST['mod_password']) && empty($_POST['mod_password_2'])) {
	$errors[] = "<li>Comprueba la contraseña</li>";
} else if (($_POST['mod_password']) != ($_POST['mod_password_2'])) {
	$errors[] = "<li>Las contraseñas no coinciden</li>";
} else if (!empty($_POST['mod_password']) && strlen($_POST['mod_password']) < 6) {
	$errors[] = "<li>El password debe tener al menos 6 caracteres.</li>";
} else if (strlen($_POST['mod_password']) > 16) {
	$errors[] = "<li>El password no puede tener más de 16 caracteres.</li>";
} else if (!empty($_POST['mod_password']) && !preg_match('`[a-z]`', $_POST['mod_password'])) {
	$errors[] = "<li>El password debe tener al menos una letra minúscula.</li>";
} else if (!empty($_POST['mod_password']) && !preg_match('`[A-Z]`', $_POST['mod_password'])) {
	$errors[] = "<li>El password debe tener al menos una letra mayúscula.</li>";
} else if (!empty($_POST['mod_password']) && !preg_match('`[0-9]`', $_POST['mod_password'])) {
	$errors[] = "<li>El password debe tener al menos un número.</li>";
} else if (empty($_POST['mod_name'])) {
	$errors[] = "Nombre vacío";
} else if (empty($_POST['mod_email'])) {
	$errors[] = "Correo Vacio vacío";
} else if (empty($_POST['mod_username'])) {
	$errors[] = "Nombre de usuario vacío";
} else if (empty($_POST['mod_email'])) {
	$errors[] = "Correo vacío";
} else if (
	!empty($_POST['mod_name']) &&
	!empty($_POST['mod_email']) &&
	$_POST['mod_status'] != ""
) {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	$username = mysqli_real_escape_string($con, (strip_tags($_POST["mod_username"], ENT_QUOTES)));
	$name = mysqli_real_escape_string($con, (strip_tags($_POST["mod_name"], ENT_QUOTES)));
	$lastname = mysqli_real_escape_string($con, (strip_tags($_POST["mod_lastname"], ENT_QUOTES)));
	$email = $_POST["mod_email"];
	$zona_id = $_POST["mod_zona"];
	$division_id = $_POST["mod_division"];
	$password = mysqli_real_escape_string($con, (strip_tags($_POST["mod_password"], ENT_QUOTES)));
	$status = intval($_POST['mod_status']);
	$rol = intval($_POST['mod_rol']);
	$id = $_POST['mod_id'];

	$sql = "UPDATE user SET name=\"$name\", lastname=\"$lastname\", username=\"$username\", zona_id=\"$zona_id\",division_id=\"$division_id\", updated_at=NOW() WHERE id=$id";

	if ($id != 1) {
		$sql = "UPDATE user SET rol=$rol, is_active=$status, email=\"$email\" WHERE id=$id";
	}

	$query_update = mysqli_query($con, $sql);
	if ($query_update) {

		$query_user = mysqli_query($con, "SELECT * FROM user WHERE id=\"$id\";");
		while ($row = mysqli_fetch_array($query_user)) {
			$updated_at_user = $row['updated_at'];
		}

		$query_rol = mysqli_query($con, "SELECT * FROM rol WHERE id=\"$rol\";");
		while ($row = mysqli_fetch_array($query_rol)) {
			$rol_name = $row['name'];
		}

		if ($status == 1) {
			$status_name = "Activo";
		} else {
			$status_name = "Inactivo";
		}

		$golfoUrl = "<a href='https://support.dsignstudio.com.mx/index.php'>Golfo Ticket</a>";

		$to = $email;
		$subject = "Datos de usuario modificados | Golfo Ticket";
		$message = "<p>Hola $name $lastname, tus datos han sido modificados con fecha $updated_at_user.</p>";
		$message .= "<p>Los datos de tu cuenta son los siguientes:</p></br>";
		$message .= "<ul>";
		$message .= "<li>Nombre de usuario: $username</li>";
		$message .= "<li>Nombre: $name</li>";
		$message .= "<li>Apellidos: $lastname</li>";
		$message .= "<li>Email: $email</li>";
		$message .= "<li>Estatus: $status_name</li>";
		$message .= "<li>Rol de usuario: $rol_name</li>";
		$message .= "</ul>";
		$message .= "<p>Si los datos de tu cuenta no son correctos favor de contactar al administrador</p></br>";
		$message .= "<p>¡Gracias por utilizar $golfoUrl!</p></br>";

		$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
		$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$messages[] = "Datos actualizados exitosamente.";

		// actualizar password
		if ($_POST["mod_password"] != "") {
			if (empty($_POST['mod_password_2'])) {
				$errors[] = "Comprueba la contraseña";
			} else if (($_POST['mod_password']) != ($_POST['mod_password_2'])) {
				$errors[] = "Las contraseñas no coinciden";
			} else if (strlen($_POST['mod_password']) < 6) {
				$errors[] = "<li>El password debe tener al menos 6 caracteres.</li>";
			} else if (strlen($_POST['mod_password']) > 16) {
				$errors[] = "<li>El password no puede tener más de 16 caracteres.</li>";
			} else if (!preg_match('`[a-z]`', $_POST['mod_password'])) {
				$errors[] = "<li>El password debe tener al menos una letra minúscula.</li>";
			} else if (!preg_match('`[A-Z]`', $_POST['mod_password'])) {
				$errors[] = "<li>El password debe tener al menos una letra mayúscula.</li>";
			} else if (!preg_match('`[0-9]`', $_POST['mod_password'])) {
				$errors[] = "<li>El password debe tener al menos un número.</li>";
			} else {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$update_passwd = mysqli_query($con, "UPDATE user SET password=\"$hashed_password\" WHERE id=$id");
				if ($update_passwd) {
					$messages[] = " La Contraseña ha sido actualizada.";
				}
			}
		}
	} else {
		$errors[] = "Lo sentimos. Algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {

?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}

?>