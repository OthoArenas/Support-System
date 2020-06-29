<?php
session_start();
include "config/config.php";
include "scripts.php";

if (!isset($_SESSION['user_id']) && $_SESSION['user_id'] == null) {
    header("location: index.php");
}
?>
<?php
$id = $_SESSION['user_id'];
$query = mysqli_query($con, "SELECT * from user where id=$id");
while ($row = mysqli_fetch_array($query)) {
    $username = $row['username'];
    $name = $row['name'];
    $lastname = $row['lastname'];
    $is_active = $row['is_active'];
    $rol = $row['rol'];
    $email = $row['email'];
    $division_id = $row['division_id'];
    $zona_id = $row['zona_id'];
    $profile_pic = $row['profile_pic'];
    $created_at = $row['created_at'];
}

$sql_rol = mysqli_query($con, "SELECT * FROM rol WHERE id= '$rol' ;");
$result_rol = mysqli_fetch_assoc($sql_rol);
$rol_name = $result_rol['name'];

$sql_division = mysqli_query($con, "SELECT * FROM division WHERE id= '$division_id' ;");
$result_division = mysqli_fetch_assoc($sql_division);
$division_name = $result_division['name'];

$sql_zona = mysqli_query($con, "SELECT * FROM zona WHERE id= '$zona_id' ;");
$result_zona = mysqli_fetch_assoc($sql_zona);
$zona_name = $result_zona['name'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title . " " . $name; ?> </title>


    <link rel="icon" type="image/ico" href="images/favicon.ico" sizes="32x32">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Materialize -->
    <link rel="stylesheet" href="css/materialize/css/materialize.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="css/fontawesome/css/all.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="css/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="css/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="css/animate.css/animate.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.3/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-2.0.0/sl-1.3.0/datatables.min.css" />
    <!-- jQuery scroller -->
    <link href="css/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />

    <!-- bootstrap-daterangepicker -->
    <!-- <link href="css/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> -->

    <!-- Estilos personalizados -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- MICSS button[type="file"] -->
    <link rel="stylesheet" href="css/micss.css">

</head>

<!-- NAVBAR -->
<div class="bg-dark section" id="navbar_section">
    <div class="container" id="icon_container">
        <a href="#" data-target="slide-out" class="sidenav-trigger" id="logo_link"><i class="fas fa-ticket-alt fa-fw fa-4x hoverable"> </i><span id="nav_logo_name">SUPPORT SYSTEM</span></a>
        <a class="dropdown-trigger float-right user-profile" id="dropdown_link" href="#!" data-target="dropdown1"><img src="images/profiles/<?php echo $profile_pic; ?>" alt="" style="object-fit:cover"><?php echo $name . " " . $lastname; ?><small><?php echo " - " . $rol_name; ?></small><i class="material-icons right">arrow_drop_down</i></a>
    </div>
</div>


<!-- Estructura dropdown -->
<ul id="dropdown1" class="dropdown-content">
    <li><a class="dropdown-trigger float-left user-profile" href="#!" data-target="dropdown1"><img src="images/profiles/<?php echo $profile_pic; ?>" alt="" style="object-fit:cover"><?php echo $name . " " . $lastname; ?></a></li>
    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
    <li><a href="tickets.php"><i class="fa fa-ticket-alt fa-fw"></i> Tickets</a></li>
    <li class="divider"></li>
    <li><a href="action/logout.php"><i class="fas fa-sign-out-alt fa-fw"></i> Cerrar Sesión</a></li>
</ul>

<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="images/profiles/569.jpg">
            </div>
            <div class="text-center justify-content-center">
                <a href="dashboard.php" class="site_title"><i class="fa fa-ticket-alt hoverable"></i> <span class="hoverable">SUPPORT SYSTEM</span></a>
                <a href="dashboard.php#profile_img_container"><img class="circle ml-auto mr-auto hoverable" src="images/profiles/<?php echo $profile_pic; ?>" alt="<?php echo $name; ?>"></a>
                <span class="white-text">Bienvenid@,</span>
                <a href="dashboard.php#x_title_panel"><span class="white-text name"><?php echo $name . " " . $lastname; ?></span></a>
                <a href="dashboard.php#x_title_panel"><span class="white-text email"><?php echo $email; ?></span></a>
            </div>
            <div class="text-center">
                <small class="white-text rol"><?php echo "$rol_name - $zona_name"; ?></small>
            </div>
    <li><a href="action/logout.php"><i class="fas fa-sign-out-alt fa-fw"></i> Cerrar Sesión</a></li>
    <li>
        <div class="divider"></div>
    </li>
    </div>
    </li>
    <?php if ($rol == 3) : ?>
        <li class="<?php if (isset($active1)) {
                        echo $active1;
                    } ?>">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
        </li>

        <li class="<?php if (isset($active2)) {
                        echo $active2;
                    } ?>">
            <a href="tickets.php"><i class="fa fa-ticket-alt fa-fw"></i> Tickets</a>
        </li>

        <li class="<?php if (isset($active3)) {
                        echo $active3;
                    } ?>">
            <a href="projects.php"><i class="fa fa-list-alt fa-fw"></i> Departamentos</a>
        </li>

        <li class="<?php if (isset($active4)) {
                        echo $active4;
                    } ?>">
            <a href="categories.php"><i class="fa fa-align-left fa-fw"></i> Categorías</a>
        </li>

        <li class="<?php if (isset($active5)) {
                        echo $active5;
                    } ?>">
            <a href="reports.php"><i class="fas fa-chart-line fa-fw"></i> Reportes</a>
        </li>

        <li class="<?php if (isset($active6)) {
                        echo $active6;
                    } ?>">
            <a href="users.php"><i class="fa fa-users fa-fw"></i> Usuarios</a>
        </li>

        <li class="<?php if (isset($active7)) {
                        echo $active7;
                    } ?>">
            <a href="division.php"><i class="fas fa-globe-americas fa-fw"></i> Divisiones</a>
        </li>

        <li class="<?php if (isset($active8)) {
                        echo $active8;
                    } ?>">
            <a href="zonas.php"><i class="fas fa-map-marker-alt fa-fw"></i> Zonas</a>
        </li>

        <li class="<?php if (isset($active9)) {
                        echo $active9;
                    } ?>">
            <a href="about.php"><i class="fa fa-child fa-fw"></i> Información</a>
        </li>

    <?php elseif ($rol == 2) : ?>
        <li class="<?php if (isset($active1)) {
                        echo $active1;
                    } ?>">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
        </li>

        <li class="<?php if (isset($active2)) {
                        echo $active2;
                    } ?>">
            <a href="tickets.php"><i class="fa fa-ticket-alt fa-fw"></i> Tickets</a>
        </li>

        <li class="<?php if (isset($active5)) {
                        echo $active5;
                    } ?>">
            <a href="reports.php"><i class="fas fa-chart-line fa-fw"></i> Reportes</a>
        </li>

        <li class="<?php if (isset($active8)) {
                        echo $active8;
                    } ?>">
            <a href="about.php"><i class="fa fa-child fa-fw"></i> Información</a>
        </li>
    <?php elseif ($rol == 1 || $rol == 4) : ?>
        <li class="<?php if (isset($active1)) {
                        echo $active1;
                    } ?>">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
        </li>

        <li class="<?php if (isset($active2)) {
                        echo $active2;
                    } ?>">
            <a href="tickets.php"><i class="fa fa-ticket-alt fa-fw"></i> Tickets</a>
        </li>
        <li class="<?php if (isset($active8)) {
                        echo $active8;
                    } ?>">
            <a href="about.php"><i class="fa fa-child fa-fw"></i> Información</a>
        </li>
    <?php endif ?>
    <li>
        <div class="divider"></div>
    </li>
    <li><a href="https://dsignstudio.com.mx"> <img src="images/logo.png" alt="D-Sign Studio Logo" id="icon_logo_menu"> D-Sign Studio</a></li>
    <div class="divider"></div>
    <li><a href="https://www.itil.com.mx/" target="_blank"><img src="images/ITILV3.png" alt="ITIL Logo" id="itil_logo_sidebar" width="40" style="margin-right:10px"> ITIL</a></li>
</ul>

<!-- / NAVBAR -->

<body class="nav-md" id="body_init">
    <div class="container body">
        <div class="main_container">
            <br />