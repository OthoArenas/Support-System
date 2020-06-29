<?php

//function de alertas by abisoft https://github.com/amnersaucedososa
function profile()
{
    $success = sha1(md5("datos actualizados"));
    if (isset($_GET['success']) && $_GET['success'] == $success) {
        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> Datos Actualizados Correctamente
                </div>";
    }
    $success_pass = sha1(md5("contraseña actualizada"));
    if (isset($_GET['success_pass']) && $_GET['success_pass'] == $success_pass) {
        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button> Datos y contraseña actualizados correctamente.
                </div>";
    }
    $invalid = sha1(md5("la contraseña anterior no coincide con la registrada en la Base de Datos, favor de intentarlo nuevamente."));
    if (isset($_GET['invalid']) && $_GET['invalid'] == $invalid) {
        echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> La contraseña anterior no coincide con la registrada en la Base de Datos, favor de intentarlo nuevamente.
                </div>";
    }
    $error = sha1(md5("las nuevas contraseñas no coinciden"));
    if (isset($_GET['error']) && $_GET['error'] == $error) {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> Las nuevas contraseñas no coinciden
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'samename') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> El nombre que has tratado de ingresar ya existe en la Base de Datos y por lo tanto no puede ser registrado.
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'sameusername') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> El nombre de usuario que has tratado de ingresar ya existe en la Base de Datos y por lo tanto no puede ser registrado. Favor de intentar con otro.
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'sameemail') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> El correo electrónico que has ingresado ya está en uso. Si deseas actualizarlo favor de intentar con otro.
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'upderr') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> Ha ocurrido un problema al actualizar tus datos. Favor de intentarlo nuevamente.
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'emptydata') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> Has ingresado algún campo vacío. Favor de intentarlo nuevamente.
                </div>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'pwdErr') {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button><strong>¡Aviso!</strong> El nuevo password debe contar con las siguientes características:
				<li>Al menos 6 caracteres.</li>
				<li>No puede tener más de 16 caracteres.</li>
				<li>Al menos una letra minúscula.</li>
				<li>Al menos una letra mayúscula.</li>
				<li>Al menos un dígito nunmérico.</li>
                </div>";
    }
}
