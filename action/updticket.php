<?php
session_start();
if (empty($_POST['mod_id'])) {
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

	$title = $_POST["title"];
	$description = $_POST["description"];
	$category_id = $_POST["category_id"];
	$project_id = $_POST["project_id"];
	$priority_id = $_POST["priority_id"];
	$user_id = $_SESSION["user_id"];
	$status_id = $_POST["status_id"];
	$kind_id = $_POST["kind_id"];
	$id = $_POST['mod_id'];
	$isupdated = 2;

	$sql_admin = mysqli_query($con, "SELECT email FROM user WHERE rol=3");
	$datas = array();
	if (mysqli_num_rows($sql_admin) > 0) {
		while ($row = mysqli_fetch_assoc($sql_admin)) {
			$datas[] = $row;
		}
	}

	$admin_emails;
	foreach ($datas as $data) {
		$admin_emails .= $data['email'] . ',';
	}

	if ($project_id == "" || $kind_id == "" || $priority_id == "") {
		$sql = mysqli_query($con, "SELECT * FROM ticket WHERE id = '$id';");
		$resultado = mysqli_fetch_assoc($sql);
		$project_id = $resultado['project_id'];
		$kind_id = $resultado['kind_id'];
		$priority_id = $resultado['priority_id'];
	}

	$sql = "update ticket set title=\"$title\",category_id=\"$category_id\",project_id=\"$project_id\",priority_id=\"$priority_id\",description=\"$description\",status_id=\"$status_id\",isupdated=\"$isupdated\",kind_id=\"$kind_id\",updated_at=NOW() where id=$id";

	$query_update = mysqli_query($con, $sql);
	if ($query_update) {

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
		$query_ticket = mysqli_query($con, "SELECT * FROM ticket WHERE id=\"$id\";");
		while ($row = mysqli_fetch_array($query_ticket)) {
			$updated_at_ticket = $row['updated_at'];
			$ticket_id = $row['ticket_id'];
		}

		$query_kind = mysqli_query($con, "SELECT * FROM kind WHERE id=\"$kind_id\";");
		while ($row = mysqli_fetch_array($query_kind)) {
			$kind_name = $row['name'];
		}

		$to = $email;
		$subject = "$kind_name #$ticket_id modificado";
		$message = "<p>Hola $name $lastname, El $kind_name #$ticket_id ha sido modificado exitosamente con la fecha $updated_at_ticket.</p>";
		$message .= "<p>Se te enviará un correo cuando este se encuentre en Atención así como cuando ya haya sido terminado.</p></br>";
		$message .= "<p>De igual manera puedes darle seguimiento ingresando a la Sección Tickets dentro de tu perfil de Golfo Ticket.</p></br>";
		$message .= "<p>¡Gracias por utilizar Golfo Ticket!</p></br>";

		$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
		$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$to = $admin_emails;
		$subject = "$kind_name #$ticket_id modificado";
		$message = "<p>El usuario $name $lastname ($email) ha modificado el $kind_name #$ticket_id con la fecha $updated_at_ticket.</p>";
		$message .= "<p>Ya le fue notificado via email sobre su pronta atención.</p></br>";
		$message .= "<p>Para ofrecer la Atención favor de dirigirse a la sección Tickets con una cuenta nivel Administrado o Agente.</p></br>";
		$message .= "<p>¡Gracias por utilizar Golfo Ticket!</p></br>";

		$headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
		$headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$messages[] = "El ticket ha sido actualizado satisfactoriamente.";
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