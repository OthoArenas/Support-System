<?php
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

if ($rol == 3 || !isset($_SESSION['user_id'])) {
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['name'])) {
		$errors[] = "Nombre vacío";
	} else if (empty($_POST['username'])) {
		$errors[] = "Nombre de usuario vacío";
	} else if (empty($_POST['lastname'])) {
		$errors[] = "Apellidos vacíos";
	} else if (empty($_POST['email'])) {
		$errors[] = "Correo vacío";
	} else if ($_POST['status'] == "") {
		$errors[] = "Selecciona el estado";
	} else if (empty($_POST['password'])) {
		$errors[] = "Contraseña vacía";
	} else if (empty($_POST['password_2'])) {
		$errors[] = "Comprueba la contraseña";
	} else if (($_POST['password']) != ($_POST['password_2'])) {
		$errors[] = "Las contraseñas no coinciden";
	} else if (strlen($_POST['password']) < 6) {
		$errors[] = "<li>El password debe tener al menos 6 caracteres.</li>";
	} else if (strlen($_POST['password']) > 16) {
		$errors[] = "<li>El password no puede tener más de 16 caracteres.</li>";
	} else if (!preg_match('`[a-z]`', $_POST['password'])) {
		$errors[] = "<li>El password debe tener al menos una letra minúscula.</li>";
	} else if (!preg_match('`[A-Z]`', $_POST['password'])) {
		$errors[] = "<li>El password debe tener al menos una letra mayúscula.</li>";
	} else if (!preg_match('`[0-9]`', $_POST['password'])) {
		$errors[] = "<li>El password debe tener al menos un número.</li>";
	} else if (empty($_POST['rol'])) {
		$errors[] = "Selecciona el rol de usuario";
	} else if (
		!empty($_POST['name']) &&
		!empty($_POST['lastname']) &&
		$_POST['status'] != "" &&
		!empty($_POST['password'])
	) {

		include "../config/config.php"; //Contiene funcion que conecta a la base de datos

		$name = mysqli_real_escape_string($con, (strip_tags($_POST["name"], ENT_QUOTES)));
		$username = mysqli_real_escape_string($con, (strip_tags($_POST["username"], ENT_QUOTES)));
		$lastname = mysqli_real_escape_string($con, (strip_tags($_POST["lastname"], ENT_QUOTES)));
		$email = $_POST["email"];
		$rol = $_POST["rol"];
		$zona_id = $_POST["zona"];
		$division_id = $_POST["division"];
		$password = mysqli_real_escape_string($con, (strip_tags($_POST["password"], ENT_QUOTES)));
		$status = intval($_POST['status']);
		$end_name = $name . " " . $lastname;
		$created_at = date("Y-m-d H:i:s");
		$user_id = $_SESSION['user_id'];
		$profile_pic = "default.png";

		$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
		$token .= $email . time();
		$token = str_shuffle($token);
		$token = substr($token, 0, 10);

		$sql_email = "SELECT id FROM user WHERE email = \"$email\" ";
		$result_email = mysqli_query($con, $sql_email);
		$sql_name = "SELECT id FROM user WHERE name = \"$name\" AND lastname = \"$lastname\" ";
		$result_name = mysqli_query($con, $sql_name);
		$sql_username = "SELECT id FROM user WHERE username = \"$username\" ";
		$result_username = mysqli_query($con, $sql_username);

		if (mysqli_num_rows($result_email) > 0) {
			$errors[] = "Lo sentimos, el email ingresado ya existe en la base de datos.";
		} else if (mysqli_num_rows($result_name) > 0) {
			$errors[] = "Lo sentimos, el Nombre y Apellidos ingresados ya están registrados en la base de datos.";
		} else if (mysqli_num_rows($result_username) > 0) {
			$errors[] = "Lo sentimos, el nombre de usuario ingresado ya existe en la base de datos.";
		} else {

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$sql = "INSERT INTO user ( name, lastname, username, rol, password, email, zona_id, division_id, profile_pic, is_active, created_at, token) VALUES ('$name', '$lastname', '$username', '$rol', '$hashed_password','$email','$zona_id','$division_id','$profile_pic', '$status','$created_at','$token')";
			$query_new_insert = mysqli_query($con, $sql);
			if ($query_new_insert) {
				$messages[] = "El usuario ha sido ingresado exitosamente. <br> Un correo de verificación será enviado al correo: <strong>$email</strong>";
				/* El enlace se deberá enviar por email al usuario para que al dar click verifique el registro y permita iniciar sesión */
				$activationUrl = "<a href='https://support.dsignstudio.com.mx/confirmation.php?email=$email&token=$token'>Haz Click</a>";
				$to = $email;
				$subject = "Código de Activación de su cuenta en Golfo Ticket";
				$message = "<p>Bienvenid@ $name $lastname, a Golfo Ticket. Aquí podrás generar Tickets o Reportes para Soporte Técnico.</p>";
				$message .= "<p>A continuación se muestra un link para la Activación de tu cuenta en Golfo Ticket. </p></br>";
				$message .= $activationUrl;

				$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
				$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
				$headers .= "Content-type: text/html\r\n";

				mail($to, $subject, $message, $headers);
			} else {
				$errors[] = "Lo sentimos, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
			}
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
} else {
	echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> No cuentas con los permisos para poder registrar un nuevo usuario.
                </div>";
}
?>