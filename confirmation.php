<?php

include "config/config.php";

function redirect()
{
    header('Location: index.php');
    exit();
}

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    redirect();
} else {

    $email = $con->real_escape_string($_GET['email']);
    $token = $con->real_escape_string($_GET['token']);

    $sql = $con->query("SELECT id FROM user WHERE email='$email' AND token='$token' AND is_active=0");

    if ($sql->num_rows > 0) {
        $con->query("UPDATE user SET is_active=1, token='' WHERE email='$email'");
        echo 'El correo ha sido verificado. Ya puedes iniciar sesión';
        echo "</br>";
        echo "<a href='index.php'>Iniciar Sesión</a>";
    } else
        redirect();
}
?>

<title>Confirmación de usuario </title>