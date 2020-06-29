<?php

include("../config/config.php");

if (isset($_POST['reset-password-submit'])) {

    $userEmail = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email = ?;";

    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Ocurrió un error con la Base de Datos";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) <= 0) {
            header("Location: ../reset-password.php?reset=notindb");
        } else {
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $url = "https://support.dsignstudio.com.mx/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
            $expires = date("U") + 7200; /* Formato U toma los segundos desde enero de 1970, se le agregan 7200 segundos para un total de 2 horas */

            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ? ;";
            /* Se utilizan placeholders para hacer los querys seguros */

            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Ocurrió un error con la Base de Datos";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $userEmail);
                mysqli_stmt_execute($stmt);
            }

            $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES(?,?,?,?) ;";

            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Ocurrió un error con la Base de Datos";
                exit();
            } else {
                $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($con);

            $to = $userEmail;
            $subject = "Restablezca su Password de Golfo Ticket";
            $message = "<p>Recibimos una solicitud para restablecer su contraseña del Sistema Golfo Ticket. El siguiente enlace le redirigirá al sitio para restablecerla. En el caso de que ud no haya hecho la solicitud, favor de omitir este mensaje.</p>";
            $message .= "<p>Aquí está el enlace para restablecer su contraseña: </br>";
            $message .= '<a href="' . $url . '"> Haga Click aquí</a></p>';

            $headers = "From: Golfo Ticket Support <golfoticketsupport@golfoticket.com>\r\n";
            $headers .= "Reply-To: golfoticketsupport@golfoticket.com\r\n";
            $headers .= "Content-type: text/html\r\n";

            mail($to, $subject, $message, $headers);
            header("Location: ../index.php?reset=success&url=$url");
        }
    }
} else {
    header("Location:../index.php");
}
