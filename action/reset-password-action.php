<?php

if (isset($_POST['new-password-submit'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['new_password'];
    $password_confirm = $_POST['new_password_confirm'];

    if (empty($password) || empty($password_confirm)) {
        header("Location: ../create-new-password.php?newpwd=empty&selector=$selector&validator=$validator");
        exit();
    } else if ($password != $password_confirm) {
        header("Location: ../create-new-password.php?newpwd=pwdnotsame&selector=$selector&validator=$validator");
    } else if (strlen($password) < 6 || strlen($password) > 16 || !preg_match('`[a-z]`', $password) || !preg_match('`[A-Z]`', $password) || !preg_match('`[0-9]`', $password)) {
        header("Location: ../create-new-password.php?newpwd=pwderror&selector=$selector&validator=$validator");
    } else {
        $currentDate = date("U");

        include("../config/config.php");

        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";

        $stmt = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "Ocurrió un error con la Base de Datos";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
                echo "Debe enviar nuevamente su solicitud de restablecimiento de contraseña";
                exit();
            } else {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

                if ($tokenCheck === false) {
                    echo "Debe enviar nuevamente su solicitud de restablecimiento de contraseña";
                    exit();
                } else if ($tokenCheck === true) {
                    $tokenEmail = $row['pwdResetEmail'];

                    $sql = "SELECT * FROM user WHERE email = ?;";

                    $stmt = mysqli_stmt_init($con);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "Ocurrió un error con la Base de Datos";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            echo "Ocurrió un error con la Base de Datos";
                            exit();
                        } else {

                            $sql = "UPDATE user SET password=? WHERE email=?;";

                            $stmt = mysqli_stmt_init($con);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "Ocurrió un error con la Base de Datos";
                                exit();
                            } else {
                                $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $newHashedPassword, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
                                $stmt = mysqli_stmt_init($con);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "Ocurrió un error con la Base de Datos";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../index.php?newpwd=passwordupdated");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    header("Location: ../index.php");
}
