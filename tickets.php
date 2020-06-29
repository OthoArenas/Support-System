<?php
$title = "Tickets | ";
include "head.php";

$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con,  "select * from priority");
$statuses = mysqli_query($con, "select * from status");
$kinds = mysqli_query($con, "select * from kind");
?>

<div class="" role="main">
    <!-- contenido -->
    <div class="">
        <div class="page-title">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
                include("modal/new_ticket.php");
                include("modal/upd_ticket.php");
                include("modal/end_ticket.php");
                ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tickets</h2>
                        <ul class="nav navbar-right panel_toolbox">

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <!-- campo de búsqueda -->
                    <form class="form-horizontal" role="form" id="gastos">
                        <div class="form-group row">
                            <label for="q" class="col-md-2 control-label" style="display:none">Nombre/Estatus</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="q" placeholder="Nombre del Asunto/Estatus (1-4)" onkeyup='load(1);' style="display:none">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-default" onclick='load(1);' style="display:none">
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

<script type="text/javascript" src="js/ticket.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script>
    $("#add").submit(function(event) {
        $('#save_data').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/addticket.php",
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


    $("#upd").submit(function(event) {
        $('#upd_data').attr("disabled", true);
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/updticket.php",
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

    $("#aten").submit(function(event) {
        $('#aten_ticket').attr("disabled", true);
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/attendticket.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#result3").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $("#result3").html(datos);
                load(1);
            }
        });

        $('#aten_ticket').text("En Atención").attr('disabled', true).addClass("btn-warning").removeClass("btn-danger btn-success");
        $('#end_comments_container').show();
        $('#end_button_container').show();
        $('#end_ticket_button').addClass("btn-success").removeClass("btn-danger btn-warning");
        event.preventDefault();
    })

    $("#end").submit(function(event) {
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "action/endticket.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#result3").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                $("#result3").html(datos);
                load(1);
            }
        });

        $('#aten_ticket').text("En Atención").attr('disabled', true).addClass("btn-warning").removeClass("btn-danger btn-success");
        $('#end_comments_container').show();
        $('#end_button_container').show();
        $('#end_ticket_button').addClass("btn-success").removeClass("btn-danger btn-warning");
        event.preventDefault();
    })

    function obtener_datos(id) {

        var id = id.split(',');

        var title = id[1].replace(/;/g, ',');
        var description = id[2].replace(/;/g, ',');
        var rol = id[11];

        if (rol == 2 || rol == 3) {
            $("#mod_id").val(id[0]).attr('disabled', false);
            $("#mod_title").val(title).attr('readonly', false);
            $("#mod_description").val(description).attr('readonly', false);
            $("#mod_project_id").val(id[3]).attr('disabled', false);
            $("#mod_priority_id").val(id[4]).attr('disabled', false);
            $("#mod_status_id").val(id[5]).attr('disabled', false);
            $("#mod_category_id").val(id[6]).attr('disabled', false);
            $("#mod_kind_id").val(id[7]).attr('disabled', false);
            $("#spanKind").text(id[9]).attr('disabled', false);
            $("#spanModal").text("#" + id[8]).attr('disabled', false);
            $('#upd_data').attr('disabled', false);
            $('#mod_comments_end').attr('readonly', false);
        } else if (rol == 1 || rol == 4) {
            $("#mod_id").val(id[0]).attr('disabled', false);
            $("#mod_title").val(title).attr('readonly', false);
            $("#mod_description").val(description).attr('readonly', false);
            $("#mod_project_id").val(id[3]).prop('disabled', true);
            $("#mod_priority_id").val(id[4]).prop('disabled', true);
            $("#mod_status_id").val(id[5]).attr('disabled', false);
            $("#mod_category_id").val(id[6]).attr('disabled', false);
            $("#mod_kind_id").val(id[7]).prop('disabled', true);
            $("#spanKind").text(id[9]).attr('disabled', false);
            $("#spanModal").text("#" + id[8]).attr('disabled', false);
            $('#upd_data').attr('disabled', false);
            $('#mod_comments_end').attr('readonly', false);
        }

        if (id[5] == 3 || id[5] == 4) {
            $("#mod_id").attr('disabled', true);
            $("#mod_title").attr('readonly', true);
            $("#mod_description").attr('readonly', true);
            $("#mod_project_id").attr('disabled', true);
            $("#mod_priority_id").attr('disabled', true);
            $("#mod_status_id").attr('disabled', true);
            $("#mod_category_id").attr('disabled', true);
            $("#mod_kind_id").attr('disabled', true);
            $("#spanKind").attr('disabled', true);
            $("#spanModal").attr('disabled', true);
            $("#mod_status_id").attr('disabled', true);
            $('#upd_data').attr('disabled', true);
        }

        id = NULL;
        title = NULL;
        description = NULL;
    }

    /* 
    Para deshabilitar escritura en campo de texto -> $("#mod_description").val(id[2]).attr('readonly', true);
    Para deshabilitar selección de menú dropdown -> $("#mod_project_id").val(id[3]).attr('disabled', true);
    */

    function obtener_datos_terminar(id) {

        var id = id.split(',');

        var title = id[1].replace(/;/g, ',');
        var description = id[2].replace(/;/g, ',');

        $("#mod_id_end").val(id[0]);
        $("#mod_id_end2").val(id[0]);
        $("#mod_title_end").val(title).attr('readonly', true);
        $("#mod_description_end").val(description).attr('readonly', true);
        $("#mod_project_id_end").val(id[3]).attr('disabled', true);
        $("#mod_priority_id_end").val(id[4]).attr('disabled', true);
        $("#mod_status_id_end").val(id[5]).attr('disabled', true);
        $("#mod_category_id_end").val(id[6]).attr('disabled', true);
        $("#mod_kind_id_end").val(id[7]).attr('disabled', true);
        $("#spanKindEnd").text(id[9]);
        $("#spanModalEnd").text("#" + id[8]);

        if (id.length >= 12) {
            var comentario = id[10];
            for (var i = 11; i < id.length - 1; i++) {
                comentario += ', ' + id[i];
            }
            $("#mod_comments_end").val(comentario);
        } else {
            $("#mod_comments_end").val(id[10]);
        }
        if (id[5] == 1) {
            $('#aten_ticket').text("Atender").attr('disabled', false).addClass("btn-warning").removeClass("btn-danger btn-success");
            $('#mod_comments_end').attr('readonly', false);
            $('#end_comments_container').hide();
            $('#end_button_container').hide();
        } else if (id[5] == 2) {
            $('#aten_ticket').text("En Atención").attr('disabled', true).addClass("btn-warning").removeClass("btn-danger btn-success");
            $('#mod_comments_end').attr('readonly', false);
            $('#end_comments_container').show();
            $('#end_button_container').show();
            $('#end_ticket_button').addClass("btn-success").removeClass("btn-danger btn-warning");
        } else if (id[5] == 3) {
            $('#aten_ticket').text("Terminado").attr('disabled', true).addClass("btn-success").removeClass("btn-danger btn-warning");
            $('#end_comments_container').show();
            $('#mod_comments_end').attr('readonly', true);
            $('#end_button_container').hide();
        } else if (id[5] == 4) {
            $('#aten_ticket').text("Cancelado").attr('disabled', true).addClass("btn-danger").removeClass("btn-success btn-warning");
            $('#end_comments_container').hide();
            $('#end_button_container').hide();
        }

        id = NULL;
        title = NULL;
        description = NULL;
        comentario = NULL;
    }

    /* 
    Para deshabilitar escritura en campo de texto -> $("#mod_description").val(id[2]).attr('readonly', true);
    Para deshabilitar selección de menú dropdown -> $("#mod_project_id").val(id[3]).attr('disabled', true);
    */

    function noEnter(texto, e) {
        if (navigator.appName == "Netscape") tecla = e.which;
        else tecla = e.keyCode;
        if (tecla == 13) return false;
        else return true;
    }
</script>