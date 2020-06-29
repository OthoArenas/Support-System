<?php
session_start();
if (empty($_POST['mod_id_end'])) {
	$errors[] = "ID vacío";
} else if (empty($_POST['title'])) {
	$errors[] = "Titulo vacío";
} else if (empty($_POST['description'])) {
	$errors[] = "Description vacío";
} else if (
	!empty($_POST['title']) &&
	!empty($_POST['description'])
) {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos


	$status_id = 2;
	$id = $_POST['mod_id_end'];

	$sql = "update ticket set status_id=\"$status_id\",attended_at=NOW() where id=$id";

	$query_update = mysqli_query($con, $sql);
	if ($query_update) {

		$query_ticket = mysqli_query($con, "SELECT * FROM ticket WHERE id=\"$id\";");
		while ($row = mysqli_fetch_array($query_ticket)) {
			$attended_at_ticket = $row['attended_at'];
			$ticket_id = $row['ticket_id'];
			$user_id = $row['user_id'];
			$kind_id = $row['kind_id'];
		}

		$query = mysqli_query($con, "SELECT * FROM user WHERE id=\"$user_id\";");
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

		$query_kind = mysqli_query($con, "SELECT * FROM kind WHERE id=\"$kind_id\";");
		while ($row = mysqli_fetch_array($query_kind)) {
			$kind_name = $row['name'];
		}

		$to = $email;
		$subject = "$kind_name #$ticket_id En Atención";
		$message = "<p>Hola $name $lastname, El $kind_name #$ticket_id se encuentra ahora En Atención con fecha $attended_at_ticket.</p>";
		$message .= "<p>Se te enviará un correo cuando este haya sido terminado junto con la información de cierre brindada.</p></br>";
		$message .= "<p>De igual manera puedes darle seguimiento ingresando a la Sección Tickets dentro de tu perfil de Golfo Ticket.</p></br>";
		$message .= "<p>¡Gracias por utilizar Golfo Ticket!</p></br>";

		$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
		$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$messages[] = "El ticket ha sido actualizado satisfactoriamente. El ticket ha cambiado de estatus a \"En Atención\" ";
	} else {
		$errors[] = "Lo sentimos, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
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