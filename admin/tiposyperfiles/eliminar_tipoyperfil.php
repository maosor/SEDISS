<?php
include '../extend/header.php';
$id = htmlentities($_GET['id']);
$a=htmlentities($_GET['a']);
if ($a=='t') {
  $del = $con->prepare("DELETE FROM tipo_ejecutivo WHERE id = ?");
}
else {
  $del = $con->prepare("DELETE FROM perfil_ejecutivo WHERE id = ?");
}

$del -> bind_param('i', $id);

if ($a== 't') {
  if ($del -> execute()) {
    header('location:../extend/alerta.php?msj=Tipo de ejecutivo eliminado&c=typ&p=in&t=success&a=t');
  }else {
    header('location:../extend/alerta.php?msj=El tipo de ejecutivo no pudo ser eliminado&c=typ&p=in&t=error&a=t');
  }
}else {
  if ($del -> execute()) {
    header('location:../extend/alerta.php?msj=Perfil del ejecutivo eliminado&c=typ&p=in&t=success&a=p');
  }else {
    header('location:../extend/alerta.php?msj=El perfil de ejecutivo no pudo ser eliminado&c=typ&p=in&t=error&a=p');
  }
}

$del ->close();
$con->close();
 ?>
