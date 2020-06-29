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
/*Inicia validacion del lado del servidor*/

if ($rol == 3) {
	if (empty($_POST['name'])) {
		$errors[] = "Nombre vacío";
	} else if (empty($_POST['division_id'])) {
		$errors[] = "División vacío";
	} else if (
		!empty($_POST['name']) &&
		!empty($_POST['division_id'])
	) {

		include "../config/config.php"; //Contiene funcion que conecta a la base de datos

		$name = $_POST["name"];
		$division_id = intval($_POST["division_id"]);
		$limite = intval($_POST["limite"]);


		$sql = "insert into zona (name, division_id, limite) value (\"$name\",\"$division_id\",\"$limite\")";
		$query_new_insert = mysqli_query($con, $sql);
		if ($query_new_insert) {
			$messages[] = "La zona ha sido registrada satisfactoriamente.";
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
} else {
	echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> No cuentas con los permisos para poder registrar una nueva Zona.
                </div>";
}
?>