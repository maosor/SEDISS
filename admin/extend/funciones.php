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
function mostrararbol($CodPadre,$tipo)
{
  $clase='';
  include '../conexion/conexion.php';
  if ($tipo > 4)
  {
    $sel = $con->prepare("SELECT codigo, descripcion, 2 FROM tipo_unidades_gestion where codPadre = ? AND EsUnidGestion = ? ");
    $es=$tipo-5;
    $sel -> bind_param('si',$CodPadre,$es);
  }else {
  $sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional where codPadre = ? and tipo = ? ORDER BY codigo");
  $sel->bind_param("si", $CodPadre,$tipo);
  }
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  $hijos = numerohijos($CodPadre);

  if($hijos > 1){
    echo '<ul>';
  }
  while ($sel->fetch()) {
    //  echo '<li><i class="small material-icons">folder</i> '.$descripcion.'';
    echo "<li id='".$codigo."' class='node'> <span>".$descripcion."</span>";
    mostrararbol($codigo,$tipo);
  }
  echo '</li>';
  if($hijos > 1){
    echo '</ul>';
  }
}
function padre($id,$tipo)
{
  include '../conexion/conexion.php';
  if ($tipo > 4)
  {
    $sel = $con->prepare("SELECT descripcion FROM tipo_unidades_gestion where codigo = ? AND EsUnidGestion = ? ");
    $es=$tipo-5;
    $sel -> bind_param('si',$id,$es);
  }else {
  $sel = $con->prepare("SELECT descripcion FROM red_organizacional WHERE codigo = ? and tipo = ? ");
  $sel->bind_param('si', $id,$tipo);
  }
  $sel->execute();
  $sel->bind_result($descripcion);
  if($sel->fetch()){
    return $descripcion;
  }
  else {
    return '';
  }
}
function nivel($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT nivel+1 FROM red_organizacional WHERE codigo = ? ");
  $sel->bind_param('s', $id);
  $sel->execute();
  $sel->bind_result($nivel);
  if($sel->fetch()){
    return $nivel;
  }
  else {
    return 0;
  }
}
function mayor($id,$tipo)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT max(codigo) FROM red_organizacional WHERE codpadre = ? and tipo = ? ");
  $sel->bind_param('si', $id,$tipo);
  $sel->execute();
  $sel->bind_result($mayor);
  if($sel->fetch()){
    return $mayor;
  }
  return 0;
}
function descripcion($tipo)
{
 if ($tipo == 1)
 {
   return 'Red Organizacional';
 }elseif ($tipo == 2) {
   return 'Nivel Complejidad';
 }elseif ($tipo == 3) {
   return 'Categoria y tipo Recurso Humano';
 }elseif ($tipo == 4) {
  return 'Categoria y tipo Insumo';
}else {
  return '';
}
}
?>
