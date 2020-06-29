<?php
$title = "Usuarios | ";
include "head.php";


if ($rol == 3) {
?>

    <div class="" role="main">
        <!-- contenido -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    include("modal/new_user.php");
                    include("modal/upd_user.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Usuarios</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <!-- campo de búsqueda -->
                        <form class="form-horizontal" role="form" id="datos_cotizacion">
                            <div class="form-group row">
                                <label for="q" class="col-md-2 control-label">Nombre o E-mail</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="q" placeholder="Nombre, Apellidos o Correo Electrónico" onkeyup='load(1);'>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search"></span> Buscar</button>
                                    <!-- <span id="loader"></span> -->
                                </div>
                            </div>
                        </form>
                        <!-- fin de campo de búsqueda -->

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                <div id="resultados"></div><!-- Carga los datos ajax -->
                                <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /contenido -->

    <?php include "footer.php" ?>

    <script type="text/javascript" src="js/users.js"></script>

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

        // success

        $("#upd_user").submit(function(event) {
            $('#upd_data').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "action/upd_user.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#result_user2").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    $("#result_user2").html(datos);
                    $('#upd_data').attr("disabled", false);
                    load(1);
                }
            });
            event.preventDefault();
        })

        function obtener_datos(id) {
            var username = $("#username" + id).val();
            var name = $("#name" + id).val();
            var lastname = $("#lastname" + id).val();
            var email = $("#email" + id).val();
            var status = $("#status" + id).val();
            var rol = $("#rol" + id).val();

            $("#mod_username").val(username);
            $("#mod_id").val(id);
            $("#mod_name").val(name);
            $("#mod_lastname").val(lastname);
            $("#mod_email").val(email);
            $("#mod_status").val(status);
            $("#mod_rol").val(rol);
        }
    </script>

<?php
} else {
?>
    <h1 class="text-center">Página Restringida</h1>
<?php
}
