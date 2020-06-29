<?php
$title = "Dashboard - ";
include "head.php";

$TicketDataPendiente = mysqli_query($con, "select * from ticket where status_id=1");
$TicketDataEnAtención = mysqli_query($con, "select * from ticket where status_id=2");
$TicketDataTerminados = mysqli_query($con, "select * from ticket where status_id=3");
$TicketDataCancelados = mysqli_query($con, "select * from ticket where status_id=4");
$ProjectData = mysqli_query($con, "select * from project");
$CategoryData = mysqli_query($con, "select * from category");
$UserData = mysqli_query($con, "select * from user order by created_at desc");
$divisions = mysqli_query($con, "select * from division order by name");
$zonas = mysqli_query($con, "select * from zona order by name");
?>
<div class="container" role="main">
    <!-- contenido -->
    <div class="container">
        <div class="page-title">
            <?php if ($rol == 2 || $rol == 3) : ?>
                <div class="top_tiles">
                    <div class="row">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                            <div class="tile-stats">
                                <div class="icon" style="color:rgba(255, 159, 64, 1);"><i class="fas fa-clock fa-fw"></i></div>
                                <div class="count" id="numero_pendientes"><?php echo mysqli_num_rows($TicketDataPendiente) ?></div>
                                <h3>Tickets Pendientes</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                            <div class="tile-stats">
                                <div class="icon" style="color:rgba(54, 162, 235, 1);"><i class="fa fa-share" aria-hidden="true"></i></div>
                                <div class="count" id="numero_atencion"><?php echo mysqli_num_rows($TicketDataEnAtención) ?></div>
                                <h3>Tickets En Atención</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                            <div class="tile-stats">
                                <div class="icon" style="color:rgba(75, 192, 192, 1);"><i class="fas fa-check-square fa-fw"></i></i></div>
                                <div class="count" id="numero_terminados"><?php echo mysqli_num_rows($TicketDataTerminados) ?></div>
                                <h3>Tickets Terminados</h3>
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                            <div class="tile-stats">
                                <div class="icon" style="color:rgba(255, 99, 132, 1);"><i class="fas fa-times-circle fa-fw"></i></div>
                                <div class="count" id="numero_cancelados"><?php echo mysqli_num_rows($TicketDataCancelados) ?></div>
                                <h3>Tickets Cancelados</h3>
                            </div>
                        </div>
                    </div> <!-- / row -->
                    <?php if ($rol == 3) : ?>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div onclick="window.location = 'projects.php'" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                                    <div class="tile-stats">
                                        <div class="icon" style="color:rgba(75, 192, 192, 1);"><i class="fa fa-list-alt"></i></div>
                                        <div class="count"><?php echo mysqli_num_rows($ProjectData) ?></div>
                                        <h3>Departamentos</h3>
                                    </div>
                                </div>
                                <div onclick="window.location = 'categories.php'" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                                    <div class="tile-stats">
                                        <div class="icon" style="color:rgba(75, 192, 192, 1);"><i class="fa fa-th-list"></i></div>
                                        <div class="count"><?php echo mysqli_num_rows($CategoryData) ?></div>
                                        <h3>Categorias</h3>
                                    </div>
                                </div>
                                <div onclick="window.location = 'users.php'" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor:pointer">
                                    <div class="tile-stats">
                                        <div class="icon" style="color:rgba(75, 192, 192, 1);"><i class="fa fa-users"></i></div>
                                        <div class="count"><?php echo mysqli_num_rows($UserData) ?></div>
                                        <h3>Usuarios</h3>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </div> <!-- container -->
                    <?php endif ?>
                    <div class="row chart-container justify-content-center">
                        <canvas id="miGrafica" style="display: block; width: 460px; height: 230px;"></canvas>
                    </div>
                </div> <!-- /top_tiles -->
            <?php endif ?>
            <!-- content -->
            <br><br>
            <div class="row text-center">
                <div class="col-md-4" id="profile_img_container">
                    <div class="image view view-first">
                        <img class="thumb-image" style="width: 100%; display: block;" src="images/profiles/<?php echo $profile_pic; ?>" alt="image" />
                    </div>
                    <span class="btn btn-my-button btn-file">
                        <form method="post" id="formulario" enctype="multipart/form-data">
                            Cambiar Imagen de perfil <input type="file" name="file">
                        </form>
                    </span>
                    <div id="respuesta"></div>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12">
                    <?php include "lib/alerts.php";
                    profile(); //llamada a la funcion de alertas
                    ?>
                    <div class="x_panel">
                        <div class="x_title" id="x_title_panel">
                            <h2>Información personal</h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left " action="action/upd_profile.php" method="post">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12" for="username">Nombre de usuario
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input type="text" name="username" id="username" class="form-control text-center" value="<?php echo $username; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Nombre
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input type="text" name="name" id="first-name" class="form-control text-center" value="<?php echo $name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12" for="lastname">Apellidos
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input type="text" name="lastname" id="lastname" class="form-control text-center" value="<?php echo $lastname; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12" for="email">Correo electrónico
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12 pb-3">
                                        <input type="email" name="email" id="email" class="form-control text-center" value="<?php echo $email; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                                    <select class="form-control" required name="division" id="division">
                                        <option value="<?php echo $division_id; ?>" disabled selected><?php echo $division_name; ?></option>
                                        <?php foreach ($divisions as $p) : ?>
                                            <?php if ($rol == 3 && $p['id'] == 1) : ?>
                                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                            <?php elseif ($p['id'] > 1) : ?>
                                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field mb-5">
                                    <select class="form-control" required name="zona" id="zona">
                                        <option value="<?php echo $zona_id; ?>" disabled selected><?php echo $zona_name; ?></option>
                                        <?php foreach ($zonas as $p) : ?>
                                            <?php if ($rol == 3 && $p['id'] == 1) : ?>
                                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                            <?php elseif ($p['id'] > 1) : ?>
                                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <h2 class="py-5">Cambiar Contraseña</h2>

                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Contraseña actual
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input name="password" class="date-picker form-control text-center" type="password" placeholder="Ingrese su contraseña actual">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Nueva contraseña
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input name="new_password" class="date-picker form-control text-center" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Confirmar contraseña nueva
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12 pb-5">
                                        <input name="confirm_new_password" class="date-picker form-control text-center" type="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="justify-content-center">
                                        <button type="submit" name="upd_profile" data-toggle="modal" data-target=".bs-update-profile-modal-lg-add" class="btn btn-success">Actualizar Datos</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- /x panel -->
                </div> <!-- /profile info col-md-8 -->
            </div>
        </div>
    </div>
</div><!-- /contenido -->

<?php include "footer.php" ?>
<script>
    $(function() {
        $("input[name='file']").on("change", function() {
            var formData = new FormData($("#formulario")[0]);
            var ruta = "action/upload-profile.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos) {
                    $("#respuesta").html(datos);
                    setTimeout(function() {
                        $("#body_init").load("#miGrafica");
                    }, 1500);

                }
            });
        });
    });

    var pendientes = document.getElementById('numero_pendientes').textContent;
    var atencion = document.getElementById('numero_atencion').textContent;
    var terminados = document.getElementById('numero_terminados').textContent;
    var cancelados = document.getElementById('numero_cancelados').textContent;
    var ctx = document.getElementById('miGrafica').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        resposive: true,
        aspectRatio: 1,
        maintainAspectRatio: true,
        data: {
            labels: ['Pendientes', 'En Atención', 'Terminados', 'Cancelados'],
            datasets: [{
                label: '# of Tickets',
                data: [pendientes, atencion, terminados, cancelados],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                position: 'top',
                text: 'Atención de Tickets',
            },
        }
    });

    $('#numero_pendientes').click(function() {
        sessionStorage.setItem("filtro", "Pendiente");
        window.location = 'tickets.php';
    });

    $('#numero_atencion').click(function() {
        sessionStorage.setItem("filtro", "En Atención");
        window.location = 'tickets.php';
    });

    $('#numero_terminados').click(function() {
        sessionStorage.setItem("filtro", "Terminado");
        window.location = 'tickets.php';
    });

    $('#numero_cancelados').click(function() {
        sessionStorage.setItem("filtro", "Cancelado");
        window.location = 'tickets.php';
    });
</script>