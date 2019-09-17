<?php
function Perfil_ejecutivo($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT descripcion FROM perfil_ejecutivo WHERE id = ? ");
  $sel->bind_param('i', $id);
  $sel->execute();
  $sel->bind_result($descripcion);
  if($sel->fetch()){
    return $descripcion;
  }
  else {
    return '';
  }
}
function tipo_ejecutivo($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT descripcion FROM tipo_ejecutivo WHERE id = ? ");
  $sel->bind_param('i', $id);
  $sel->execute();
  $sel->bind_result($descripcion);
  if($sel->fetch()){
    return $descripcion;
  }
  else {
    return '';
  }
}
function sucursal($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT nombre FROM sucursal WHERE id = ? ");
  $sel->bind_param('i', $id);
  $sel->execute();
  $sel->bind_result($nombre);
  if($sel->fetch()){
    return $nombre;
  }
  else {
    return '';
  }
}
function ejecutivo($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT nombre FROM ejecutivo WHERE id = ? ");
  $sel->bind_param('i', $id);
  $sel->execute();
  $sel->bind_result($nombre);
  if($sel->fetch()){
    return $nombre;
  }
  else {
    return '';
  }
}
/*2019-08-29 *Mau Devuelve la cantidad de hijoe que tiene un deteminado grupo*/
function numerohijos($cod)
{
  $rows = 0;
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT codigo FROM red_organizacional where codPadre = ? ");
  $sel->bind_param("s", $cod);
  $sel-> execute();
  $sel->store_result();
  $rows = $sel->num_rows;
  //echo "<script> console.log('Debug test: ".$cod." | ".$rows."');</script>";
  return $rows;
}
/*2019-08-29 Mau *Muestra el arbol y se llama recurvamente por cada grupo*/
function mostrararbol($CodPadre)
{
  $clase='';
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional where codPadre = ? ORDER BY codigo");
  $sel->bind_param("s", $CodPadre);
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  $hijos = numerohijos($CodPadre);

  if($hijos != 0){
    echo '<ul>';
  }
  while ($sel->fetch()) {
    //  echo '<li><i class="small material-icons">folder</i> '.$descripcion.'';
    echo "<li id='".$codigo."' class='node'>".$descripcion."";
    mostrararbol($codigo);
  }
  echo '</li>';
  if($hijos != 0){
    echo '</ul>';
  }
}
?>
