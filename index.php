<?php
session_start();

include "config/config.php";
include("scripts.php");

if (isset($_SESSION['user_id']) && $_SESSION !== null) {
    header("location: dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar Sesión </title>

    <link rel="icon" type="image/ico" href="images/favicon.ico" sizes="32x32">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Materialize -->
    <link rel="stylesheet" href="css/materialize/css/materialize.min.css">
    <!-- Font Awesome -->
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="css/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="css/animate.css/animate.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <?php
                /* Mensajes de error y éxito */
                $invalid = sha1(md5("contraseña y/o email incorrectos"));
                $invalid2 = sha1(md5("El usuario ingresado no se encuentra Activo. Por favor verifique su correo electrónico para la activación o póngase en contacto con el administrador."));
                $invalid3 = sha1(md5("El usuario ingresado no se encuentra en nuestra Base de Datos. Puede registrarse dando click al botón \"Registrarse\"."));
                if (isset($_GET['invalid']) && $_GET['invalid'] == $invalid) {
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> Contraseña y/o Correo Electrónico incorrectos
                                </div>";
                }
                if (isset($_GET['invalid']) && $_GET['invalid'] == $invalid2) {
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> El usuario ingresado no se encuentra Activo. Por favor verifique su correo electrónico para la activación o póngase en contacto con el administrador.
                                </div>";
                }
                if (isset($_GET['invalid']) && $_GET['invalid'] == $invalid3) {
                    echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> El usuario ingresado no se encuentra en nuestra Base de Datos. Puede registrarse dando click al botón \"Registrarse\".
                                </div>";
                }
                if (isset($_GET['invalid']) && $_GET['invalid'] != $invalid  && $_GET['invalid'] != $invalid2 && $_GET['invalid'] != $invalid3) {
                    echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                                <strong>¡Éxito!</strong> Bienvenido
                                </div>";
                }
                if (isset($_GET['newpwd'])) {
                    if ($_GET['newpwd'] == 'passwordupdated') {
                        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                                <strong>¡Éxito!</strong> Tu contraseña ha sido restablecida.
                                </div>";
                    }
                }
                if (isset($_GET['reset'])) {
                    if ($_GET['reset'] == "success") {
                        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                    <strong>¡Éxito!</strong> Revisa tu email para restablecer su contraseña.</div>";
                    } else if ($_GET['reset'] == "notindb") {
                        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'>
                        <strong>¡Error!</strong> El email ingresado no se encuentra en nuestra base de datos. Por favor verifique la información proporcionada.
                        </div>";
                    }
                }
                ?>
                <section class="login_content">
                    <form action="action/login.php" method="post">
                        <h1>Iniciar Sesión</h1>
                        <div>
                            <input type="text" name="email" class="form-control text-center" placeholder="Nombre de usuario / Correo Electrónico" />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control text-center" placeholder="Contraseña" />
                        </div>
                        <div>
                            <button type="submit" name="login" value="Login" class="btn btn-primary mb-4">Iniciar Sesión</button>
                        </div>
                        <a class="reset_pass" href="reset-password.php">¿Olvidaste tu contraseña?</a>
                        <div class="clearfix"></div>
                        <br>
                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-ticket"></i> SUPPORT SYSTEM</h1>
                                <p><a target="_blank" style="text-decoration: underline;" href="http://dsignstudio.com.mx">D-Sign Studio | Web Solutions</a></p>
                            </div>
                        </div>
                    </form>
                    <button data-toggle="modal" data-target=".bs-example-modal-lg-add" id="register_button" class="btn btn-primary">Registrarse</button>
                </section>
            </div>
        </div>
    </div>
    <div class="container" style="position: fixed; bottom: 10px; right: -10px">
        <a href="https://www.itil.com.mx/" target="_blank"><img src="images/ITILV3.png" alt="ITIL Logo" id="itil_logo_login" width="100"></a>
    </div>
    <?php
    include("modal/register_user.php");
    ?>

    <script>
        $("#add_user").submit(function(event) {
            $('#save_data').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "action/add_user.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#result_user").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    $("#result_user").html(datos);
                    $('#save_data').attr("disabled", false);
                    load(1);
                }
            });
            event.preventDefault();
        })
    </script>
</body>

</html>