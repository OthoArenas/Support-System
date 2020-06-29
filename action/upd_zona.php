<?php
session_start();
include("../config/config.php");

$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * FROM user WHERE id=\"$id\";");
while ($row = mysqli_fetch_array($query)) {
	$username = $row['username'];
	$name = $row['name'];
	$password = $row['password'];
	$lastname = $row['lastname'];
	$is_active = $row['is_active'];
	$rol = $row['rol'];
	$email = $row['email'];
	$profile_pic = $row['profile_pic'];
	$created_at = $row['created_at'];
}

if ($rol == 3) {
	if (empty($_POST['mod_id'])) {
		$errors[] = "ID vacío";
	} else if (empty($_POST['mod_division_id'])) {
		$errors[] = "División vacío";
	} else if (empty($_POST['mod_name'])) {
		$errors[] = "Nombre Vacio";
	} else if (
		!empty($_POST['mod_name']) &&
		!empty($_POST['mod_division_id'])
	) {

		include "../config/config.php"; //Contiene funcion que conecta a la base de datos

		$name = $_POST["mod_name"];
		$division_id = $_POST["mod_division_id"];
		$limite = intval($_POST["mod_limite"]);
		$mod_password = $_POST["mod_password"];

		$id = $_POST['mod_id'];

		if (password_verify($mod_password, $password)) {
			$sql = "update zona set name=\"$name\",division_id=\"$division_id\",limite=\"$limite\" where id=$id";
			$query_update = mysqli_query($con, $sql);
			if ($query_update) {
				$messages[] = "La Zona ha sido actualizada satisfactoriamente.";
			} else {
				$errors[] = "Lo sentimos, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
			}
		} else {
			$errors[] = "Lo sentimos, la contraseña que ha ingresado no es correcta. Intente nuevamente.";
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
                </button><strong>¡Aviso!</strong> No cuentas con los permisos necesarios.
                </div>";
}
?>