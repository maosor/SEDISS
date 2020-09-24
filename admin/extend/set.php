<?php
include '../conexion/conexion.php';
//echo "<script>Console.log('Entró....');</script>";
/*    $up = $con->prepare(" UPDATE compania SET seleccionada=1 WHERE id=?; ");
    $up->bind_param('s',$_POST['name']);
      if (!$up -> execute()) {
        echo "<script>Console.log('Error....');</script>";
      }*/
  $_SESSION [$_POST['name']] = $_POST['value'];
  if($_SESSION ['compania']==$_POST['value']){
    echo "Actualización variable sessión exitosa con: ".$_POST['value'];
  }else {
    echo "No se pudo actualizar la variable de sessión".$_SESSION ['compania'];
  }
?>
