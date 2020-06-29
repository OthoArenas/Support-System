<?php
include "config/config.php";
include("scripts.php");
?>
<title>Recuperar Contraseña </title>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <?php
            /* Mensajes de error y éxito */
            $invalid = sha1(md5("contraseña y/o email incorrectos"));
            $invalid2 = sha1(md5("El usuario ingresado no se encuentra Activo. Por favor verifique su correo electrónico para la activación o póngase en contacto con el administrador."));
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
            if (isset($_GET['invalid']) && $_GET['invalid'] != $invalid  && $_GET['invalid'] != $invalid2) {
                echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                <strong>¡Éxito!</strong> Bienvenido
                </div>";
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
                <form action="action/reset-request-action.php" method="post">
                    <h1>Recuperar Contraseña</h1>
                    <div>
                        <input type="email" name="email" class="form-control text-center" placeholder="Ingresa tu correo electrónico" required />
                    </div>
                    <div>
                        <button type="submit" name="reset-password-submit" value="reset_password_submit" class="btn btn-success">Recuperar</button>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1><i class="fa fa-ticket"></i> GOLFO TICKET!</h1>
                            <p><a target="_blank" style="text-decoration: underline;" href="http://dsignstudio.com.mx">D-Sign Studio | Web Solutions</a></p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>