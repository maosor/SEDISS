<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $a= htmlentities($_GET['a']);
  if ($a=='t') {
    $up = $con->prepare("UPDATE tipo_ejecutivo SET descripcion=? WHERE id=? ");
    $up->bind_param('si', $descripcion, $id);
      if ($up -> execute()) {
      header('location:../extend/alerta.php?msj=Tipo de ejecutivo actualizado&c=typ&p=in&t=success&a=t');
    }else {
      header('location:../extend/alerta.php?msj=El tipo de ejecutivo no pudo ser actualizado &c=typ&p=in&t=error&a=t');
    }
  }else {
    $up = $con->prepare("UPDATE perfil_ejecutivo SET descripcion=? WHERE id=? ");
    $up->bind_param('si', $descripcion, $id);
      if ($up -> execute()) {
      header('location:../extend/alerta.php?msj=Perfil de ejecutivo actualizado&c=typ&p=in&t=success&a=p');
    }else {
      header('location:../extend/alerta.php?msj=El perfil del ejecutivo no pudo ser actualizado&c=typ&p=in&t=error&a=p');
    }
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=typ&p=in&t=error&a=t');
}
 ?>
