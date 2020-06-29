<?php
include "config/config.php";
include("scripts.php");
?>
<title>Crear Nueva Contraseña </title>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <?php
            $selector = $_GET['selector'];
            $validator = $_GET['validator'];

            /* Mensajes de error y éxito */

            if (isset($_GET['reset'])) {
                if ($_GET['reset'] == "success") {
                    echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                                <strong>¡Éxito!</strong> Revisa tu email para restablecer su contraseña.
                                </div>";
                }
            }
            if (isset($_GET['newpwd'])) {
                if ($_GET['newpwd'] == "empty") {
                    echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> No has ingresado correctamente alguno de los campos. Por favor ingresa la nueva contraseña y su comprobación en los campos correspondientes.
                                </div>";
                } else if ($_GET['newpwd'] == "pwdnotsame") {
                    echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> Las contraseñas ingresadas no coinciden.
                                </div>";
                } else if ($_GET['newpwd'] == "pwderror") {
                    echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
                                <strong>¡Error!</strong> La contraseña debe tener las siguientes características:
                                <li>Mayor a 6 caracteres y menor a 16 caracteres</li>
                                <li>Debe contener al menos una letra mayúscula y al menos una minúscula</li>
                                <li>Debe contener al menos un dígito numérico</li>
                                </div>";
                }
            }

            if (empty($selector) || empty($validator)) {
                echo "No es posible validar su solicitud de restablecimiento de contraseña";
            } else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>

                    <!-- Formulario de creación de nueva contraseña -->
                    <section class="login_content">
                        <form action="action/reset-password-action.php" method="post">
                            <h1>Crear Contraseña</h1>
                            <div>
                                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                <input type="password" class="form-control text-center" name="new_password" placeholder="Ingresa tu nueva contraseña">
                                <input type="password" class="form-control text-center" name="new_password_confirm" placeholder="Confirma tu nueva contraseña">
                                <button type="submit" name="new-password-submit" class="btn btn-success">Restablecer Contraseña</button>
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
            <?php
                }
            }
            ?>

        </div>
    </div>
</body>