<?php

include "../config/config.php";

session_start();

$id = $_SESSION['user_id'];

if (isset($_FILES["file"])) {
  $file = $_FILES["file"];
  $name = $file["name"];
  $type = $file["type"];
  $tmp_n = $file["tmp_name"];
  $size = $file["size"];
  $folder = "../images/profiles/";

  if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif') {
    echo "Error, el archivo no es una imagen";
  } else if ($size > 4096 * 4096) {
    echo "Error, el tamaño máximo permitido es un 4MB";
  } else {
    $src = $folder . $name;
    @move_uploaded_file($tmp_n, $src);

    $query = mysqli_query($con, "UPDATE user set profile_pic=\"$name\" WHERE id=\"$id\"");
    if ($query) {
      echo "<div class='alert alert-success' role='alert'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>¡Bien hecho!</strong> Perfil Actualizado Correctamente
        </div>";
    }
  }
}
