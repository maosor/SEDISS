<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
    $del = $con->prepare("DELETE FROM gastos WHERE idorganizacion=? and fecha = ? ");
    $del->bind_param('is',  $organizacion,$fecha);
    if ($del -> execute()) {
        header('location:../extend/alerta.php?msj=Borrado=Datos borrados...&c=gd&p=in&t=info');
    }else {
    echo 'Error actualizando...';
  }
$del->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=gd&p=in&t=error');
}
