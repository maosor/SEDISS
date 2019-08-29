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
function numerohijos($cod)
{
  $rows = 0;
 include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT count(*) rows FROM red_organizacional where codPadre = ? ");
  $sel->bind_param("s", $cod);
  $sel-> execute();
  $sel->store_result();
  $sel ->bind_result($rows);
  echo "<script>console.log('Debug test: " .$rows."' );</script>";
  return $rows;

}
function mostrararbol($CodPadre)
{
  $clase='';
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional where codPadre = ? ORDER BY codigo");
  $sel->bind_param("s", $CodPadre);
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  $row = $sel->num_rows;

//  if($row > 0){
        echo '<ul class="nested">';
  //}
    while ($sel->fetch()) {
      if (numerohijos($codigo) == 1){
            $clase = 'single';
      }
      else {
          $clase = 'caret caret-down';
      }
          echo '<li class="nivel'.$nivel.'"><span class="'.$clase.'">'.$descripcion.'</span>';
        echo '<div style="display: inline-table;"><a href="ingreso_ejecutivo.php?id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a></div>';
          mostrararbol($codigo);

        }
       echo '</li></ul>';
}
?>
