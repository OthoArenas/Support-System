<?php
$title = "Divisiones | ";
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
                    include("modal/new_division.php");
                    include("modal/upd_division.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Divisiones </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <!-- campo de búsqueda -->
                        <form class="form-horizontal" role="form" id="division_expence">
                            <div class="form-group row">
                                <label for="q" class="col-md-2 control-label">Nombre de la División</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="q" placeholder="Nombre de la División" onkeyup='load(1);'>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search"></span> Buscar</button>
                                    <span id="loader"></span>
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

    <script type="text/javascript" src="js/division.js"></script>

    <script>
        $("#add").submit(function(event) {
            $('#save_data').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "action/add_division.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#result").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    $("#result").html(datos);
                    $('#save_data').attr("disabled", false);
                    load(1);
                }
            });
            event.preventDefault();
        })

        // success

        $("#upd").submit(function(event) {
            $('#upd_data').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "action/upd_division.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#result2").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    $("#result2").html(datos);
                    $('#upd_data').attr("disabled", false);
                    load(1);
                }
            });
            event.preventDefault();
        })

        function obtener_datos(id) {
            var name = $("#name" + id).val();
            $("#mod_id").val(id);
            $("#mod_name").val(name);
        }
    </script>
<?php
} else {
?>
    <h1 class="text-center">Página Restringida</h1>
<?php
}
