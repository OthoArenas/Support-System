<?php
session_start();
if (empty($_POST['mod_id_end2'])) {
	$errors[] = "ID vacío";
} else if (
	!empty($_POST['mod_id_end2'])
) {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos


	$status_id = 3;
	$closed_comments = $_POST['closed_comments'];
	$closed_comments = str_replace("\r", "", $closed_comments);
	$id = $_POST['mod_id_end2'];

	$sql = "update ticket set status_id=\"$status_id\",closed_at=NOW(),closed_comments=\"$closed_comments\" where id=$id";

	$query_update = mysqli_query($con, $sql);
	if ($query_update) {

		$query_ticket = mysqli_query($con, "SELECT * FROM ticket WHERE id=\"$id\";");
		while ($row = mysqli_fetch_array($query_ticket)) {
			$closed_at_ticket = $row['closed_at'];
			$ticket_id = $row['ticket_id'];
			$user_id = $row['user_id'];
			$kind_id = $row['kind_id'];
			$comments_ticket = $row['closed_comments'];
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

		$golfoUrl = "<a href='https://support.dsignstudio.com.mx/index.php'>Golfo Ticket</a>";

		$to = $email;
		$subject = "$kind_name #$ticket_id Terminado";
		$message = "<p>Hola $name $lastname, El $kind_name #$ticket_id ya ha sido terminado con fecha $closed_at_ticket.</p>";
		$message .= "<p>La información de cierre es la siguiente:</p></br>";
		$message .= "<p>\"$closed_comments\"</p></br>";
		$message .= "<p>Recuerda que si requieres nuevamente de un servicio de Soporte, puedes dirigirte a $golfoUrl</p></br>";
		$message .= "<p>¡Gracias!</p></br>";

		$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
		$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$messages[] = "El ticket ha sido actualizado satisfactoriamente. El ticket ha sido \"Terminado\" ";
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