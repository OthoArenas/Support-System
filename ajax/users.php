<?php

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_expence = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * from user where id='" . $id_expence . "'");
    while ($row = mysqli_fetch_array($query)) {
        $rol = $row['rol'];
    }
    $count = mysqli_num_rows($query);
    if ($rol != 3 && $id_expence != 1) {
        if ($delete1 = mysqli_query($con, "DELETE FROM user WHERE id='" . $id_expence . "'")) {
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
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Error!</strong> Lo sentimos, no se pueden eliminar cuentas de administrador
        </div>
<?php
    }
} //end if
?>

<?php
if ($action == 'ajax') {
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('name', 'lastname', 'rol', 'email', 'division_id', 'zona_id'); //Columnas de busqueda
    $sTable = "user";
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
    include 'pagination.php'; //archivo de paginación
    //variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //número de registros a mostrar
    $adjacents  = 4; //espacios entre adyacentes
    $offset = ($page - 1) * $per_page;
    //cuenta número de registros*/
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './users.php';
    //obtención de datos
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop para mostrar datos
    if ($numrows > 0) {

?>
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">Nombre de usuario</th>
                    <th class="column-title">Nombre </th>
                    <th class="column-title">Correo Electrónico </th>
                    <th class="column-title">División </th>
                    <th class="column-title">Zona </th>
                    <th class="column-title">Estado </th>
                    <th class="column-title">Rol de usuario </th>
                    <th class="column-title">Fecha </th>
                    <th class="column-title no-link last"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($r = mysqli_fetch_array($query)) {
                    $id = $r['id'];
                    $status = $r['is_active'];
                    $username = $r['username'];
                    $rol_id = $r['rol'];
                    if ($status == 1) {
                        $status_f = "Activo";
                    } else {
                        $status_f = "Inactivo";
                    }

                    $name = $r['name'];
                    $lastname = $r['lastname'];
                    $end_name = $name . " " . $lastname;
                    $email = $r['email'];
                    $division_id = $r['division_id'];
                    $zona_id = $r['zona_id'];
                    $created_at = date('d/m/Y', strtotime($r['created_at']));

                    $sql_rol = mysqli_query($con, "select * from rol where id=$rol_id");
                    if ($c = mysqli_fetch_array($sql_rol)) {
                        $rol = $c['name'];
                    }

                    $sql_division = mysqli_query($con, "select * from division where id=$division_id");
                    if ($c = mysqli_fetch_array($sql_division)) {
                        $division_name = $c['name'];
                    }

                    $sql_zona = mysqli_query($con, "select * from zona where id=$zona_id");
                    if ($c = mysqli_fetch_array($sql_zona)) {
                        $zona_name = $c['name'];
                    }
                ?>
                    <input type="hidden" value="<?php echo $username; ?>" id="username<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $name; ?>" id="name<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $lastname; ?>" id="lastname<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $email; ?>" id="email<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $division_id; ?>" id="division_id<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $zona_id; ?>" id="zona_id<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $status; ?>" id="status<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $rol_id; ?>" id="rol<?php echo $id; ?>">

                    <tr class="even pointer">
                        <td><?php echo $username; ?></td>
                        <td><?php echo $end_name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $division_name; ?></td>
                        <td><?php echo $zona_name; ?></td>
                        <td><?php echo $status_f; ?></td>
                        <td><?php echo $rol; ?></td>
                        <td><?php echo $created_at; ?></td>
                        <td><span class="pull-right d-flex">
                                <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-upd"><i class="fas fa-edit fa-fw"></i></a>
                                <a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="fas fa-trash fa-fw"></i></a></span></td>
                    </tr>
                <?php
                } //end while
                ?>
                <tr>
                    <td colspan=9><span class="pull-right">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span></td>
                </tr>
        </table>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Aviso!</strong> No hay datos para mostrar
        </div>
<?php
    }
}
?>