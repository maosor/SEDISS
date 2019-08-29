<?php
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
  foreach ($_POST as $campo => $valor) {
  $variable = "$".$campo."='".htmlentities($valor)."';";
  eval($variable);
  }
  $up = $con->prepare("UPDATE ejecutivo SET nombre=?, apellido1=?,apellido2=?, id_perfil=?,
    id_tipo=?, telefono_principal=?, telefono_secundario=?, telefono_celular=?, id_sucursal=? WHERE id=? ");
  $up->bind_param('sssiisssii', $nombre, $apellido1,$apellido2, $id_perfil,
    $id_tipo, $telefono_principal, $telefono_secundario, $telefono_celular, $id_sucursal,$id);
    if ($up -> execute()) {
    header('location:../extend/alerta.php?msj=Ejecutivo actualizado&c=eje&p=in&t=success');
  }else {
    header('location:../extend/alerta.php?msj=El ejecutivo no pudo ser actualizado&c=eje&p=in&t=error');
  }
$ins->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=eje&p=in&t=error');
}
 ?>
