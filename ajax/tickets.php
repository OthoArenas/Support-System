<?php

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

session_start();
$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * from user where id=$id");
while ($row = mysqli_fetch_array($query)) {
    $username = $row['username'];
    $name = $row['name'];
    $lastname = $row['lastname'];
    $is_active = $row['is_active'];
    $rol = $row['rol'];
    $email = $row['email'];
    $profile_pic = $row['profile_pic'];
    $created_at = $row['created_at'];
}

if ($rol == 2 || $rol == 3) {

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
    if (isset($_GET['id'])) {
        $id_del = intval($_GET['id']);
        $query = mysqli_query($con, "SELECT * from ticket where id='" . $id_del . "'");
        $count = mysqli_num_rows($query);

        if ($delete1 = mysqli_query($con, "DELETE FROM ticket WHERE id='" . $id_del . "'")) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Aviso!</strong> Datos eliminados exitosamente.
            </div>
        <?php
                } else {
                    ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Error!</strong> Lo sentimos, algo ha salido mal. Intenta nuevamente.
            </div>
    <?php
            } //end else
        } //end if
        ?>

    <?php
        if ($action == 'ajax') {
            // escaping, additionally removing everything that could be (html/javascript-) code
            $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
            $aColumns = array('title', 'status_id'); //Columnas de busqueda
            $sTable = "ticket";
            $sWhere = "";
            if ($_GET['q'] != "") {
                $sWhere = "WHERE (";
                for ($i = 0; $i < count($aColumns); $i++) {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }
            $sWhere .= " order by created_at desc";
            include 'pagination.php'; //include pagination file
            //pagination variables
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
            $per_page = 100000000; //how much records you want to show
            $adjacents  = 4; //gap between pages after number of adjacents
            $offset = ($page - 1) * $per_page;
            //Count the total number of row in your table*/
            $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
            $row = mysqli_fetch_array($count_query);
            $numrows = $row['numrows'];
            $total_pages = ceil($numrows / $per_page);
            $reload = './expences.php';
            //main query to fetch the data
            $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
            $query = mysqli_query($con, $sql);
            //loop through fetched data
            if ($numrows > 0) {

                ?>
            <table class="table table-striped jambo_table bulk_action table-bordered text-center table-responsive sortable-theme-bootstrap" data-sortable id="ticket-table">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center"># </th>
                        <th class="column-title text-center">#Ticket </th>
                        <th class="column-title text-center">Asunto </th>
                        <th class="column-title text-center">Descripción </th>
                        <th class="column-title text-center">Categoría </th>
                        <th class="column-title text-center">Departamento </th>
                        <th class="column-title text-center">Tipo </th>
                        <th class="column-title text-center">Prioridad </th>
                        <th class="column-title text-center">Estado </th>
                        <th class="column-title text-center">Cliente </th>
                        <th class="column-title text-center">Email Cliente </th>
                        <th class="column-title text-center">División </th>
                        <th class="column-title text-center">Zona </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Última Actualización </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha e atención </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha de cierre </th>
                        <th class="column-title text-center">Comentarios de cierre </th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                $num_rows = 1;
                                while ($r = mysqli_fetch_array($query)) {
                                    $id = $r['id'];
                                    $ticket_id = $r['ticket_id'];
                                    $created_at = date('d/m/Y', strtotime($r['created_at']));
                                    $created_at_hour = date("h:i a", strtotime($r['created_at']));
                                    $updated_at = date('d/m/Y', strtotime($r['updated_at']));
                                    $updated_at_hour = date("h:i a", strtotime($r['updated_at']));
                                    $attended_at = date('d/m/Y', strtotime($r['attended_at']));
                                    $attended_at_hour = date("h:i a", strtotime($r['attended_at']));
                                    $closed_at = date('d/m/Y', strtotime($r['closed_at']));
                                    $closed_at_hour = date("h:i a", strtotime($r['closed_at']));
                                    $description = $r['description'];
                                    $description = str_replace(",", ";", $description);
                                    $closed_comments = $r['closed_comments'];
                                    $title = $r['title'];
                                    $title = str_replace(",", ";", $title);
                                    $project_id = $r['project_id'];
                                    $priority_id = $r['priority_id'];
                                    $user_id = $r['user_id'];
                                    $status_id = $r['status_id'];
                                    $kind_id = $r['kind_id'];
                                    $category_id = $r['category_id'];

                                    $sql = mysqli_query($con, "select * from project where id=$project_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_project = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from priority where id=$priority_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_priority = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from status where id=$status_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_status = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from user where id=$user_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_user = $c['name'];
                                        $user_email = $c['email'];
                                        $user_division = $c['division_id'];
                                        $user_zona = $c['zona_id'];
                                    }

                                    $sql = mysqli_query($con, "select * from division where id=$user_division");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $division_name = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from zona where id=$user_zona");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $zona_name = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from kind where id=$kind_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_kind = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from category where id=$category_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_category = $c['name'];
                                    }

                                    $ticketArray = array($id, $title, $description, $project_id, $priority_id, $status_id, $category_id, $kind_id, $ticket_id, $name_kind, $closed_comments, $rol);
                                    $ticket_str = implode(",", $ticketArray);
                                    ?>
                        <input type="hidden" value="<?php echo $id; ?>" id="id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $ticket_id; ?>" id="ticket_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $title; ?>" id="title<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $description; ?>" id="description<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $closed_comments; ?>" id="closed_comments<?php echo $id; ?>">

                        <!-- obtiene los datos -->
                        <input type="hidden" value="<?php echo $kind_id; ?>" id="kind_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $project_id; ?>" id="project_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $category_id; ?>" id="category_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $priority_id; ?>" id="priority_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $status_id; ?>" id="status_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $name_user; ?>" id="name_user<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_email; ?>" id="user_email<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_division; ?>" id="division_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_zona; ?>" id="zona_id<?php echo $id; ?>">

                        <tr class="even pointer">
                            <td><?php echo $num_rows;
                                                $num_rows++; ?></td>
                            <td><a href="#"><?php echo $ticket_id; ?></a></td>
                            <td><?php echo str_replace(";", ",", $title); ?></td>
                            <td><?php echo str_replace(";", ",", $description); ?></td>
                            <td><?php echo $name_category; ?></td>
                            <td><?php echo $name_project; ?></td>
                            <td><?php echo $name_kind; ?></td>
                            <td><?php echo $name_priority; ?></td>
                            <td><?php echo $name_status; ?></td>
                            <td><?php echo $name_user; ?></td>
                            <td><?php echo $user_email; ?></td>
                            <td><?php echo $division_name; ?></td>
                            <td><?php echo $zona_name; ?></td>
                            <td><?php echo $created_at . " " . $created_at_hour; ?></td>
                            <td><?php if ($updated_at == "01/01/1970" || $updated_at == "31/12/1969") {
                                    echo "-";
                                } else {
                                    echo $updated_at . " " . $updated_at_hour;
                                } ?></td>
                            <td><?php if ($attended_at == "01/01/1970" || $attended_at == "31/12/1969") {
                                    echo "-";
                                } else {
                                    echo $attended_at . " " . $attended_at_hour;
                                } ?></td>
                            <td><?php if ($closed_at == "01/01/1970" || $closed_at == "31/12/1969") {
                                    echo "-";
                                                } else {
                                                    echo $closed_at . " " . $closed_at_hour;
                                                } ?></td>
                            <td><?php if ($closed_comments == NULL) {
                                                    echo "-";
                                                } else {
                                                    echo $closed_comments;
                                                } ?></td>
                            <td><span class="pull-right d-flex">
                                    <a href="#" class='btn btn-default' title='Atender ticket' onclick="obtener_datos_terminar('<?php echo $ticket_str; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-end"><i class="fa fa-inbox fa-fw" aria-hidden="true"></i></a>
                                    <a href="#" class='btn btn-default' title='Editar ticket' onclick="obtener_datos('<?php echo $ticket_str; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="fas fa-edit fa-fw"></i></a>
                                    <a href="#" class='btn btn-default' title='Borrar ticket' onclick="eliminar('<?php echo $id; ?>')"><i class="fas fa-trash fa-fw"></i></a></span></td>
                        </tr>
                    <?php
                                } //end while
                                ?>
                    <table style="display:none">
                        <tr>
                            <td colspan=10><span class="pull-right">
                                    <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                                </span></td>
                        </tr>
                    </table>
            </table>
            </div>
        <?php
                } else {
                    ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Aviso!</strong> ¡No hay datos para mostrar!
            </div>
    <?php
            }
        }
        ?>

    <script>
        $(document).ready(function() {

            $('#ticket-table').DataTable({
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

        var filtro = sessionStorage.getItem("filtro");
        if (sessionStorage.getItem("filtro") == "Pendiente") {
            $('input').val("\"Pendiente\"");
            $('input').focus();
        } else if (sessionStorage.getItem("filtro") == "En Atención") {
            $('input').val("\"En Atención\"");
            $('input').focus();
            $('input').keydown();
        } else if (sessionStorage.getItem("filtro") == "Terminado") {
            $('input').val("\"Terminado\"");
            $('input').focus();
        } else if (sessionStorage.getItem("filtro") == "Cancelado") {
            $('input').val("\"Cancelado\"");
            $('input').focus();
        }
        sessionStorage.removeItem("filtro");
        sessionStorage.clear("filtro");
    </script>


    <!-- INICIO DE TABLAS PARA CLIENTES Y DEMO -->
    <?php
    } else if ($rol == 1 || $rol == 4) {

        $action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
        if (isset($_GET['id'])) {
            $id_del = intval($_GET['id']);
            $query = mysqli_query($con, "SELECT * from ticket where id='" . $id_del . "'");
            $count = mysqli_num_rows($query);

            if ($delete1 = mysqli_query($con, "DELETE FROM ticket WHERE id='" . $id_del . "'")) {
                ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Aviso!</strong> Datos eliminados exitosamente.
            </div>
        <?php
                } else {
                    ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Error!</strong> Lo sentimos, algo ha salido mal. Intenta nuevamente.
            </div>
    <?php
            } //end else
        } //end if
        ?>

    <?php
        if ($action == 'ajax') {
            // escaping, additionally removing everything that could be (html/javascript-) code
            $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
            $aColumns = array('title', 'status_id'); //Columnas de busqueda
            $sTable = "ticket";
            $sWhere = "";
            if ($_GET['q'] != "") {
                $sWhere = "WHERE (";
                for ($i = 0; $i < count($aColumns); $i++) {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }
            $sWhere .= " order by created_at desc";
            include 'pagination.php'; //include pagination file
            //pagination variables
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
            $per_page = 100000000; //how much records you want to show
            $adjacents  = 4; //gap between pages after number of adjacents
            $offset = ($page - 1) * $per_page;
            //Count the total number of row in your table*/
            $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
            $row = mysqli_fetch_array($count_query);
            $numrows = $row['numrows'];
            $total_pages = ceil($numrows / $per_page);
            $reload = './expences.php';
            //main query to fetch the data
            $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
            $sql = "SELECT * FROM $sTable WHERE user_id = '$id' LIMIT $offset,$per_page";
            $query = mysqli_query($con, $sql);
            //loop through fetched data
            if ($numrows > 0) {

                ?>
            <table class="table table-striped jambo_table bulk_action table-bordered text-center table-responsive sortable-theme-bootstrap" data-sortable id="ticket-table">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center"># </th>
                        <th class="column-title text-center">#Ticket </th>
                        <th class="column-title text-center">Asunto </th>
                        <th class="column-title text-center">Descripción </th>
                        <th class="column-title text-center">Categoría </th>
                        <th class="column-title text-center">Departamento </th>
                        <th class="column-title text-center">Tipo </th>
                        <th class="column-title text-center">Prioridad </th>
                        <th class="column-title text-center">Estado </th>
                        <th class="column-title text-center">Cliente </th>
                        <th class="column-title text-center">Email Cliente </th>
                        <th class="column-title text-center">División </th>
                        <th class="column-title text-center">Zona </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Última Actualización </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha e atención </th>
                        <th class="column-title text-center dateFormat-ddmmyyyy">Fecha de cierre </th>
                        <th class="column-title text-center">Comentarios de cierre </th>
                        <th class="column-title no-link last"><span class="nobr"></span>Editar Ticket</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                $num_rows = 1;
                                while ($r = mysqli_fetch_array($query)) {
                                    $id = $r['id'];
                                    $ticket_id = $r['ticket_id'];
                                    $created_at = date('d/m/Y', strtotime($r['created_at']));
                                    $created_at_hour = date("h:i a", strtotime($r['created_at']));
                                    $updated_at = date('d/m/Y', strtotime($r['updated_at']));
                                    $updated_at_hour = date("h:i a", strtotime($r['updated_at']));
                                    $attended_at = date('d/m/Y', strtotime($r['attended_at']));
                                    $attended_at_hour = date("h:i a", strtotime($r['attended_at']));
                                    $closed_at = date('d/m/Y', strtotime($r['closed_at']));
                                    $closed_at_hour = date("h:i a", strtotime($r['closed_at']));
                                    $description = $r['description'];
                                    $description = str_replace(",", ";", $description);
                                    $closed_comments = $r['closed_comments'];
                                    $title = $r['title'];
                                    $title = str_replace(",", ";", $title);
                                    $project_id = $r['project_id'];
                                    $priority_id = $r['priority_id'];
                                    $user_id = $r['user_id'];
                                    $status_id = $r['status_id'];
                                    $kind_id = $r['kind_id'];
                                    $category_id = $r['category_id'];

                                    $sql = mysqli_query($con, "select * from project where id=$project_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_project = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from priority where id=$priority_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_priority = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from status where id=$status_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_status = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from user where id=$user_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_user = $c['name'];
                                        $user_email = $c['email'];
                                        $user_division = $c['division_id'];
                                        $user_zona = $c['zona_id'];
                                    }

                                    $sql = mysqli_query($con, "select * from division where id=$user_division");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $division_name = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from zona where id=$user_zona");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $zona_name = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from kind where id=$kind_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_kind = $c['name'];
                                    }

                                    $sql = mysqli_query($con, "select * from category where id=$category_id");
                                    if ($c = mysqli_fetch_array($sql)) {
                                        $name_category = $c['name'];
                                    }

                                    $ticketArray = array($id, $title, $description, $project_id, $priority_id, $status_id, $category_id, $kind_id, $ticket_id, $name_kind, $closed_comments, $rol);
                                    $ticket_str = implode(",", $ticketArray);
                                    ?>
                        <input type="hidden" value="<?php echo $id; ?>" id="id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $ticket_id; ?>" id="ticket_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $title; ?>" id="title<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $description; ?>" id="description<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $closed_comments; ?>" id="closed_comments<?php echo $id; ?>">

                        <!-- obtiene los datos -->
                        <input type="hidden" value="<?php echo $kind_id; ?>" id="kind_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $project_id; ?>" id="project_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $category_id; ?>" id="category_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $priority_id; ?>" id="priority_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $status_id; ?>" id="status_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $name_user; ?>" id="name_user<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_email; ?>" id="user_email<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_division; ?>" id="division_id<?php echo $id; ?>">
                        <input type="hidden" value="<?php echo $user_zona; ?>" id="zona_id<?php echo $id; ?>">

                        <tr class="even pointer">
                            <td><?php echo $num_rows;
                                                $num_rows++; ?></td>
                            <td><a href="#"><?php echo $ticket_id; ?></a></td>
                            <td><?php echo str_replace(";", ",", $title); ?></td>
                            <td><?php echo str_replace(";", ",", $description); ?></td>
                            <td><?php echo $name_category; ?></td>
                            <td><?php echo $name_project; ?></td>
                            <td><?php echo $name_kind; ?></td>
                            <td><?php echo $name_priority; ?></td>
                            <td><?php echo $name_status; ?></td>
                            <td><?php echo $name_user; ?></td>
                            <td><?php echo $user_email; ?></td>
                            <td><?php echo $division_name; ?></td>
                            <td><?php echo $zona_name; ?></td>
                            <td><?php echo $created_at . " " . $created_at_hour; ?></td>
                            <td><?php if ($updated_at == "01/01/1970") {
                                                    echo "-";
                                                } else {
                                                    echo $updated_at . " " . $updated_at_hour;
                                                } ?></td>
                            <td><?php if ($attended_at == "01/01/1970") {
                                                    echo "-";
                                                } else {
                                                    echo $attended_at . " " . $attended_at_hour;
                                                } ?></td>
                            <td><?php if ($closed_at == "01/01/1970") {
                                                    echo "-";
                                                } else {
                                                    echo $closed_at . " " . $closed_at_hour;
                                                } ?></td>
                            <td><?php if ($closed_comments == NULL) {
                                                    echo "-";
                                                } else {
                                                    echo $closed_comments;
                                                } ?></td>
                            <td><span class="pull-right">

                                    <a href="#" class='btn btn-default' title='Editar ticket' onclick="obtener_datos('<?php echo $ticket_str; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="fas fa-edit fa-fw"></i></a>

                        </tr>
                    <?php
                                } //end while
                                ?>
                    <table style="display:none">
                        <tr>
                            <td colspan=10><span class="pull-right">
                                    <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                                </span></td>
                        </tr>
                    </table>
            </table>
            </div>
        <?php
                } else {
                    ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>¡Aviso!</strong> ¡No hay datos para mostrar!
            </div>
    <?php
            }
        }
        ?>

    <script>
        $(document).ready(function() {

            $('#ticket-table').DataTable({
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

        var filtro = sessionStorage.getItem("filtro");
        if (sessionStorage.getItem("filtro") == "Pendiente") {
            $('input').val("\"Pendiente\"");
            $('input').focus();
        } else if (sessionStorage.getItem("filtro") == "En Atención") {
            $('input').val("\"En Atención\"");
            $('input').focus();
            $('input').keydown();
        } else if (sessionStorage.getItem("filtro") == "Terminado") {
            $('input').val("\"Terminado\"");
            $('input').focus();
        } else if (sessionStorage.getItem("filtro") == "Cancelado") {
            $('input').val("\"Cancelado\"");
            $('input').focus();
        }
        sessionStorage.removeItem("filtro");
        sessionStorage.clear("filtro");
    </script>

<?php
}
?>