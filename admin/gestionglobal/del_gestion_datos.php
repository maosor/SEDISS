<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha='01-'.$_POST['fecha'];
  $fecha=date("Y-m-t", strtotime($fecha));
  $accion=$_POST['accion'];
  $compania = $_SESSION['compania'];
  if($accion == '#insumos'){
    $del = $con->prepare("DELETE FROM gastos WHERE idcompania = ? AND organizacion=? AND fecha = ? ");
  }else if($accion == '#produccion') {
    $del = $con->prepare("DELETE FROM produccion WHERE idcompania = ? AND organizacion=? AND fecha = ? ");
  }else if($accion == '#horas') {
    $del = $con->prepare("DELETE FROM horas WHERE idcompania = ? AND organizacion=? AND fecha = ? ");
  }
  $del->bind_param('iis', $compania, $organizacion,$fecha);
    ///echo 'Insertado: SQL ==> '.$organizacion.$fecha;
  if ($del -> execute()) {
      //header('location:../extend/alerta.php?msj=Borrado=Datos borrados...&c=gd&t=info');
  }else {
    echo 'Error borrando...';
  }
$del->close();
$con->close();
}else {
  header('location:../extend/alerta.php?msj=Utiliza el formulario&c=gd&p=in&t=error');
}
