<?php

session_start();

if (!isset($_SESSION['user_id']) && $_SESSION['user_id'] == null) {
	header("location: ../");
}

include "../config/config.php";


$id = $_SESSION['user_id'];
$status = 0;
if (isset($_POST['status'])) {
	$status = 1;
}

$username = $_POST['username'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$division = $_POST['division'];
$zona = $_POST['zona'];

$sql = mysqli_query($con, "SELECT * FROM user WHERE id = \"$id\" ;");
$result_user = mysqli_fetch_assoc($sql);
$userUsername = $result_user['username'];
$userName = $result_user['name'];
$userLastname = $result_user['lastname'];
$userEmail = $result_user['email'];
$userDivision = $result_user['division_id'];
$userZona = $result_user['zona_id'];

if (isset($_POST['upd_profile'])) {

	if ($username == $userUsername && $name == $userName && $lastname == $userLastname && $email == $userEmail) {
		header("Location: ../dashboard.php");
	}

	if ($username != $userUsername) {
		if ($username != "") {
			$sql_username = mysqli_query($con, "SELECT * FROM user WHERE username = '$username';");
			if (mysqli_fetch_assoc($sql_username)) {
				$error = "sameusername";
				header("location: ../dashboard.php?error=$error");
			} else {
				$update = mysqli_query($con, "UPDATE user SET username=\"$username\" WHERE id=$id");
				if ($update) {
					$success = sha1(md5("datos actualizados"));
					header("location: ../dashboard.php?success=$success");
				} else {
					$error = "upderr";
					header("location: ../dashboard.php?error=$error");
				}
			}
		} else {
			$error = "emptydata";
			header("location: ../dashboard.php?error=$error");
		}
	}

	if ($division != $userDivision) {
		if ($division != "") {
			$update = mysqli_query($con, "UPDATE user SET division_id=\"$division\" WHERE id=$id");
			if ($update) {
				$success = sha1(md5("datos actualizados"));
				header("location: ../dashboard.php?success=$success");
			} else {
				$error = "upderr";
				header("location: ../dashboard.php?error=$error");
			}
		} else {
			$error = "emptydata";
			header("location: ../dashboard.php?error=$error");
		}
	}

	if ($zona != $userZona) {
		if ($zona != "") {
			$update = mysqli_query($con, "UPDATE user SET zona_id=\"$zona\" WHERE id=$id");
			if ($update) {
				$success = sha1(md5("datos actualizados"));
				header("location: ../dashboard.php?success=$success");
			} else {
				$error = "upderr";
				header("location: ../dashboard.php?error=$error");
			}
		} else {
			$error = "emptydata";
			header("location: ../dashboard.php?error=$error");
		}
	}

	if ($name != $userName || $lastname != $userLastname) {
		if ($name != "" && $lastname != "") {
			$sql_name = mysqli_query($con, "SELECT * FROM user WHERE name = '$name' AND lastname = '$lastname' ;");
			if (mysqli_fetch_assoc($sql_name)) {
				$error = "samename";
				header("location: ../dashboard.php?error=$error");
			} else {
				$update = mysqli_query($con, "UPDATE user SET name=\"$name\",lastname=\"$lastname\" WHERE id=$id");
				if ($update) {
					$success = sha1(md5("datos actualizados"));
					header("location: ../dashboard.php?success=$success");
				} else {
					$error = "upderr";
					header("location: ../dashboard.php?error=$error");
				}
			}
		} else {
			$error = "emptydata";
			header("location: ../dashboard.php?error=$error");
		}
	}

	if ($email != $userEmail) {
		if ($email != "") {
			$sql_email = mysqli_query($con, "SELECT * FROM user WHERE email = '$email';");
			if (mysqli_fetch_assoc($sql_email)) {
				$error = "sameemail";
				header("location: ../dashboard.php?error=$error");
			} else {
				$update = mysqli_query($con, "UPDATE user SET email=\"$email\" WHERE id=$id");
				if ($update) {
					$success = sha1(md5("datos actualizados"));
					header("location: ../dashboard.php?success=$success");
				} else {
					$error = "upderr";
					header("location: ../dashboard.php?error=$error");
				}
			}
		} else {
			$error = "emptydata";
			header("location: ../dashboard.php?error=$error");
		}
	}

	// cambio de password
	if ($_POST['password'] != "") {

		$old_password = $_POST['password'];
		$new_password = $_POST['new_password'];
		$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
		$confirm_new_password = $_POST['confirm_new_password'];

		if ($_POST['new_password'] == $_POST['confirm_new_password']) {

			$sql = mysqli_query($con, "SELECT * FROM user WHERE id=$id");
			while ($row = mysqli_fetch_array($sql)) {
				$db_password = $row['password'];
			}

			if (password_verify($old_password, $db_password)) { //comprobamos que la contraseña sea igual ala anterior

				$error = "pwdErr";
				if (strlen($new_password) < 6) {
					header("location: ../dashboard.php?error=$error");
				} else if (strlen($new_password) > 16) {
					header("location: ../dashboard.php?error=$error");
				} else if (!preg_match('`[a-z]`', $new_password)) {
					header("location: ../dashboard.php?error=$error");
				} else if (!preg_match('`[A-Z]`', $new_password)) {
					header("location: ../dashboard.php?error=$error");
				} else if (!preg_match('`[0-9]`', $new_password)) {
					header("location: ../dashboard.php?error=$error");
				} else {
					$update_passwd = mysqli_query($con, "UPDATE user SET password=\"$new_hashed_password\" WHERE id=$id");
					if ($update_passwd) {
						$success_pass = sha1(md5("contraseña actualizada"));
						header("location: ../dashboard.php?success_pass=$success_pass");
					}
				}
			} else {
				$invalid = sha1(md5("la contraseña anterior no coincide con la registrada en la Base de Datos, favor de intentarlo nuevamente."));
				header("location: ../dashboard.php?invalid=$invalid");
			}
		} else {
			$error = sha1(md5("las nuevas contraseñas no coinciden"));
			header("location: ../dashboard.php?error=$error");
		}
	}
} else {
	header("location: ../");
}
