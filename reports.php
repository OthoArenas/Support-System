<?php
$title = "Reportes | ";
include "head.php";

$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con,  "select * from priority");
$statuses = mysqli_query($con, "select * from status");
$kinds = mysqli_query($con, "select * from kind");
$updated_ids = mysqli_query($con, "select * from updated");

if ($rol == 2 || $rol == 3) {
?>


    <div class="" role="main">
        <!-- contenido -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reportes</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <!-- campo búsqueda -->
                        <form class="form-horizontal" role="form">
                            <input type="hidden" name="view" value="reports">
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-male fa-fw"></i></span>
                                        <select name="project_id" class="form-control">
                                            <option value="">DEPARTAMENTO</option>
                                            <?php foreach ($projects as $p) : ?>
                                                <option value="<?php echo $p['id']; ?>" <?php if (isset($_GET["project_id"]) && $_GET["project_id"] == $p['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-exclamation fa-fw"></i></span>
                                        <select name="priority_id" class="form-control">
                                            <option value="">PRIORIDAD</option>
                                            <?php foreach ($priorities as $p) : ?>
                                                <option value="<?php echo $p['id']; ?>" <?php if (isset($_GET["priority_id"]) && $_GET["priority_id"] == $p['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text">INICIO</span>
                                        <input type="date" name="start_at" value="<?php if (isset($_GET["start_at"]) && $_GET["start_at"] != "") {
                                                                                        echo $_GET["start_at"];
                                                                                    } ?>" class="form-control" placeholder="Palabra clave">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text">FIN</span>
                                        <input type="date" name="finish_at" value="<?php if (isset($_GET["finish_at"]) && $_GET["finish_at"] != "") {
                                                                                        echo $_GET["finish_at"];
                                                                                    } ?>" class="form-control" placeholder="Palabra clave">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-info fa-fw" aria-hidden="true"></i></span>
                                        <select name="status_id" class="form-control">
                                            <option value="" selected>ESTADO</option>
                                            <?php foreach ($statuses as $p) : ?>
                                                <option value="<?php echo $p['id']; ?>" <?php if (isset($_GET["status_id"]) && $_GET["status_id"] == $p['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-ticket-alt fa-fw" aria-hidden="true"></i></span>
                                        <select name="kind_id" class="form-control">
                                            <option value="" selected>TIPO</option>
                                            <?php foreach ($kinds as $p) : ?>
                                                <option value="<?php echo $p['id']; ?>" <?php if (isset($_GET["kind_id"]) && $_GET["kind_id"] == $p['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-recycle fa-fw"></i></span>
                                        <select name="isupdated_id" class="form-control">
                                            <option value="" selected>MODIFICADO</option>
                                            <?php foreach ($updated_ids as $p) : ?>
                                                <option value="<?php echo $p['id']; ?>" <?php if (isset($_GET["isupdated_id"]) && $_GET["isupdated_id"] == $p['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button class="btn btn-success btn-block">PROCESAR</button>
                                </div>
                            </div>
                        </form>
                        <!-- fin de campo búsqueda -->

                        <?php
                        $users = array();
                        if ((isset($_GET["status_id"]) && isset($_GET["kind_id"]) && isset($_GET["project_id"]) && isset($_GET["priority_id"]) && isset($_GET["isupdated_id"]) && isset($_GET["start_at"]) && isset($_GET["finish_at"])) && ($_GET["status_id"] != "" || $_GET["kind_id"] != "" || $_GET["project_id"] != "" || $_GET["priority_id"] != "" || $_GET["isupdated_id"] != "" || ($_GET["start_at"] != "" || $_GET["finish_at"] != ""))) {

                            $sql = "select * from ticket where ";
                            if ($_GET["status_id"] != "") {
                                $sql .= " status_id = " . $_GET["status_id"];
                            }

                            if ($_GET["kind_id"] != "") {
                                if ($_GET["status_id"] != "") {
                                    $sql .= " and ";
                                }
                                $sql .= " kind_id = " . $_GET["kind_id"];
                            }


                            if ($_GET["project_id"] != "") {
                                if ($_GET["status_id"] != "" || $_GET["kind_id"] != "") {
                                    $sql .= " and ";
                                }
                                $sql .= " project_id = " . $_GET["project_id"];
                            }

                            if ($_GET["priority_id"] != "") {
                                if ($_GET["status_id"] != "" || $_GET["project_id"] != "" || $_GET["kind_id"] != "") {
                                    $sql .= " and ";
                                }

                                $sql .= " priority_id = " . $_GET["priority_id"];
                            }

                            if ($_GET["isupdated_id"] != "") {
                                if ($_GET["status_id"] != "" || $_GET["project_id"] != "" || $_GET["kind_id"] != "") {
                                    $sql .= " and ";
                                }

                                $sql .= " isupdated = " . $_GET["isupdated_id"];
                            }


                            if ($_GET["start_at"] != "" && $_GET['finish_at'] == "") {
                                if ($_GET["status_id"] != "" || $_GET["project_id"] != "" || $_GET["priority_id"] != "" || $_GET["kind_id"] != "" || $_GET['isupdated_id'] != "") {
                                    $sql .= " and ";
                                }

                                $sql .= " ( created_at >= \"" . $_GET["start_at"] . "\" ) ";
                            }

                            if ($_GET["start_at"] == "" && $_GET['finish_at'] != "") {
                                $fechafinal = $_GET['finish_at'];
                                $fechafinal = date("Y-m-d", strtotime($fechafinal . "+ 1 days"));
                                if ($_GET["status_id"] != "" || $_GET["project_id"] != "" || $_GET["priority_id"] != "" || $_GET["kind_id"] != "" || $_GET['isupdated_id'] != "") {
                                    $sql .= " and ";
                                }

                                $sql .= " ( created_at <= \"" . $fechafinal . "\" ) ";
                            }

                            if ($_GET["start_at"] != "" && $_GET['finish_at'] != "") {
                                $fechafinal = $_GET['finish_at'];
                                $fechafinal = date("Y-m-d", strtotime($fechafinal . "+ 1 days"));
                                if ($_GET["status_id"] != "" || $_GET["project_id"] != "" || $_GET["priority_id"] != "" || $_GET["kind_id"] != "" || $_GET['isupdated_id'] != "") {
                                    $sql .= " and ";
                                }

                                $sql .= " ( created_at >= \"" . $_GET["start_at"] . "\" and created_at <= \"" . $fechafinal . "\" ) ";
                            }

                            $users = mysqli_query($con, $sql);
                        } else {
                            $users = mysqli_query($con, "select * from ticket order by created_at desc");
                        }


                        if (@mysqli_num_rows($users) > 0) {
                            // si hay reportes
                            $_SESSION["report_data"] = $users;
                        ?>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action table-bordered text-center table-responsive sortable-theme-bootstrap" id="report-table" style="font-size:12px">
                                        <thead>
                                            <th class="column-title"># </th>
                                            <th class="column-title">#Ticket </th>
                                            <th class="column-title">Asunto </th>
                                            <th class="column-title">Descripción </th>
                                            <th class="column-title">Departamento </th>
                                            <th class="column-title">Tipo </th>
                                            <th class="column-title">Categoria </th>
                                            <th class="column-title">Prioridad </th>
                                            <th class="column-title">Estado </th>
                                            <th class="column-title">Cliente </th>
                                            <th class="column-title">Email Cliente </th>
                                            <th class="column-title">División </th>
                                            <th class="column-title">Zona </th>
                                            <th class="column-title dateFormat-ddmmyyyy">Fecha </th>
                                            <th class="column-title dateFormat-ddmmyyyy">Última Actualización </th>
                                            <th class="column-title dateFormat-ddmmyyyy">Fecha de atención </th>
                                            <th class="column-title dateFormat-ddmmyyyy">Fecha de cierre </th>
                                            <th class="column-title">Comentarios de cierre </th>
                                        </thead>
                                        <?php
                                        $total = 0;
                                        $num_rows = 1;
                                        foreach ($users as $user) {
                                            $project_id = $user['project_id'];
                                            $priority_id = $user['priority_id'];
                                            $kind_id = $user['kind_id'];
                                            $category_id = $user['category_id'];
                                            $status_id = $user['status_id'];
                                            $user_id = $user['user_id'];
                                            $division_id = $user['division_id'];
                                            $zona_id = $user['zona_id'];

                                            $status = mysqli_query($con, "select * from status where id=$status_id");
                                            $category = mysqli_query($con, "select * from category where id=$category_id");
                                            $kinds = mysqli_query($con, "select * from kind where id=$kind_id");
                                            $project  = mysqli_query($con, "select * from project where id=$project_id");
                                            $medic = mysqli_query($con, "select * from priority where id=$priority_id");
                                            $users = mysqli_query($con, "select * from user where id=$user_id");
                                            $divisiones = mysqli_query($con, "select * from division where id=$division_id");
                                            $zonas = mysqli_query($con, "select * from zona where id=$zona_id");

                                        ?>
                                            <tr>
                                                <td><?php echo $num_rows;
                                                    $num_rows++ ?></td>
                                                <td><a href="#"><?php echo $user['ticket_id'] ?></a></td>
                                                <td><?php echo $user['title'] ?></td>
                                                <td><?php echo $user['description'] ?></td>
                                                <?php foreach ($project as $pro) { ?>
                                                    <td><?php echo $pro['name'] ?></td>
                                                <?php } ?>
                                                <?php foreach ($kinds as $kind) { ?>
                                                    <td><?php echo $kind['name'] ?></td>
                                                <?php } ?>
                                                <?php foreach ($category as $cat) { ?>
                                                    <td><?php echo $cat['name']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($medic as $medics) { ?>
                                                    <td><?php echo $medics['name']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($status as $stat) { ?>
                                                    <td><?php echo $stat['name']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($users as $user_name) { ?>
                                                    <td><?php echo $user_name['name']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($users as $user_email) { ?>
                                                    <td><?php echo $user_email['email']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($divisiones as $division) { ?>
                                                    <td><?php echo $division['name']; ?></td>
                                                <?php } ?>
                                                <?php foreach ($zonas as $zona) { ?>
                                                    <td><?php echo $zona['name']; ?></td>
                                                <?php } ?>
                                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])) . " " . date("h:i a", strtotime($user['created_at'])); ?>
                                                <td><?php if ($user['updated_at'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo date('d/m/Y', strtotime($user['updated_at'])) . " " . date("h:i a", strtotime($user['updated_at']));
                                                    } ?></td>
                                                <td><?php if ($user['attended_at'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo date('d/m/Y', strtotime($user['attended_at'])) . " " . date("h:i a", strtotime($user['attended_at']));
                                                    } ?></td>
                                                <td><?php if ($user['attended_at'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo date('d/m/Y', strtotime($user['closed_at'])) . " " . date("h:i a", strtotime($user['closed_at']));
                                                    } ?></td>
                                                <td><?php if ($user['closed_comments'] == NULL) {
                                                        echo "-";
                                                    } else {
                                                        echo $user['closed_comments'];
                                                    } ?></td>
                                            </tr>
                                        <?php

                                        }

                                        ?>
                                    <?php

                                } else {
                                    echo "<p class='alert alert-danger'>No hay tickets</p>";
                                }


                                    ?>
                                    </table>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /contenido -->

    <?php include "footer.php" ?>

    <script>
        $(document).ready(function() {
            $('#report-table').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar elementos en la tabla:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "sProcessing": "Procesando...",
                    "searchPlaceholder": "Buscar...",
                    "buttons": {
                        "pageLength": {
                            _: "Mostrar %d filas",
                            '-1': "Mostrar todo"
                        }
                    }
                },
                responsive: false,
                "paging": true,
                "lengthChange": true,
                stateSave: true,
                "lengthMenu": [10, 25, 50, 100, 500, -1],
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-success',
                        text: 'Copiar tabla',
                        copySuccess: {
                            1: "Se copió una fila al portapapeles",
                            _: "Se copiaron %d filas al portapapeles"
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success',
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-success',
                        orientation: 'landscape',
                        pageSize: 'TABLOID'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-success',
                        text: 'Imprimir'
                    },
                ],
            });
        });
    </script>

<?php
} else {
?>
    <h1 class="text-center">Página Restringida</h1>
<?php
}
