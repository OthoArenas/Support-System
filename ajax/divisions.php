<?php

include "../config/config.php"; //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_del = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * from division where id='" . $id_del . "'");
    $count = mysqli_num_rows($query);
    if ($delete1 = mysqli_query($con, "DELETE FROM division WHERE id='" . $id_del . "'")) {
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
            <strong>¡Error!</strong> No se pudo eliminar ésta división. Existen tickets vinculadas a ésta división.
        </div>
<?php
    } //end else
} //end if
?>

<?php
if ($action == 'ajax') {
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('name'); //Columnas de busqueda
    $sTable = "division";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by name desc";
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
    $reload = './divisions.php';
    //obtención de datos
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop para mostrar datos
    if ($numrows > 0) {

?>
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">Nombre División </th>
                    <th class="column-title no-link last"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($r = mysqli_fetch_array($query)) {
                    $id = $r['id'];
                    $name = $r['name'];
                ?>
                    <input type="hidden" value="<?php echo $id; ?>" id="id<?php echo $id; ?>">
                    <input type="hidden" value="<?php echo $name; ?>" id="name<?php echo $id; ?>">

                    <tr class="even pointer">
                        <td class="col-10"><?php echo $name; ?></td>
                        <td><span class="pull-right d-flex col-2">
                                <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id; ?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="fas fa-edit fa-fw"></i></a>
                                <a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="fas fa-trash fa-fw"></i></a></span></td>
                    </tr>
                <?php
                } //end while
                ?>
                <tr>
                    <td colspan=6><span class="pull-right">
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