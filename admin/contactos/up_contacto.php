<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE contacto SET nombre=?,
    telefono_casa=?,telefono_oficina=?,telefono_celular=?,fax=?,email=?,es_corredor=?,email2=? WHERE id_contacto=? ");
  $up->bind_param('ssssssssi', $nombre, $telefono_casa,$telefono_oficina,$telefono_celular,$fax,$email,$es_corredor,$email2,$id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Contacto actualizado&c=con&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=El contacto no pudo ser actualizado&c=con&p=in&t=error');
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=con&p=in&t=error');
}
 ?>
