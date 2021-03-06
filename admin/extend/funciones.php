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
function compania($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT descripcion FROM compania WHERE id = ? ");
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
/*2019-08-29 *Mau Devuelve la cantidad de hijoe que tiene un deteminado grupo*/
function numerohijos($cod,$tipo,$compania)
{
  $rows = 0;
  include '../conexion/conexion.php';
  if ($tipo == 5)
  {
    $sel = $con->prepare("SELECT codigo FROM tipo_unidades_gestion where idpa = ? AND EsUnidGestion = ? and id_compania = ?");
    $es=$tipo-5;
    $sel -> bind_param('sii',$cod,$es,$compania);
  }elseif ($tipo == 6)
  {
    $sel = $con->prepare("SELECT codigo FROM tipo_unidades_gestion where idpa = ? and id_compania = ?");
    $sel -> bind_param('si',$cod,$compania);

  }else{
  $sel = $con->prepare("SELECT codigo FROM red_organizacional where idpa = ? and id_compania = ?");
  $sel->bind_param("si", $cod,$compania);
 }
  $sel-> execute();
  $sel->store_result();
  $rows = $sel->num_rows;
  //echo "<script> console.log('Debug test: ".$cod." | ".$rows."');</script>";
  return $rows;
}
/*2019-08-29 Mau *Muestra el arbol y se llama recurvamente por cada grupo*/
function mostrararbol($CodPadre,$tipo,$compania)
{
  $clase='';
  include '../conexion/conexion.php';
  if ($tipo == 5)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? AND EsUnidGestion = ? and id_compania = ? ORDER BY orden");
    $es=$tipo-5;
    $sel -> bind_param('sii',$CodPadre,$es,$compania);
  }elseif ($tipo == 6)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? and id_compania = ?  ORDER BY orden");
    $sel -> bind_param('si',$CodPadre,$compania);
  }else{
  $sel = $con->prepare("SELECT id, descripcion, nivel FROM red_organizacional where idpa = ? and tipo = ? and id_compania = ? ORDER BY orden");
  $sel->bind_param("sii", $CodPadre,$tipo,$compania);
  }
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  $hijos = numerohijos($CodPadre,$tipo,$compania);
  if($hijos > 0){
    echo '<ul>';
  }
  while ($sel->fetch()) {
    //  echo '<li><i class="small material-icons">folder</i> '.$descripcion.'';
    echo "<li id='".$codigo."' class='node'> <span>".$descripcion."</span>";
    mostrararbol($codigo,$tipo,$compania,$compania);
  }
  echo '</li>';
  if($hijos > 0){
    echo '</ul>';
  }
}
function mostrararbollista($CodPadre,$tipo)
{
  $clase='';
  include '../conexion/conexion.php';
  if ($tipo == 5)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? AND EsUnidGestion = ? ORDER BY orden");
    $es=$tipo-5;
    $sel -> bind_param('si',$CodPadre,$es);
  }elseif ($tipo == 6)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? ORDER BY orden");
    $sel -> bind_param('s',$CodPadre);
  }else{
  $sel = $con->prepare("SELECT id, descripcion, nivel FROM red_organizacional where idpa = ? and tipo = ? ORDER BY orden");
  $sel->bind_param("si", $CodPadre,$tipo);
  }
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  $hijos = numerohijos($CodPadre,$tipo);
  if($hijos > 0){
    echo '<ul>';
  }
  $t='li';
  while ($sel->fetch()) {
    //  echo '<li><i class="small material-icons">folder</i> '.$descripcion.'';
    $h=numerohijos($codigo,$tipo);
    $h == 0?$clase='item':$clase='header';
    $h == 0?$t='a':$t='li';
    echo "<".$t." id='".$codigo."' class='collection-".$clase."'> <span>".$descripcion."</span>";
    mostrararbollista($codigo,$tipo);
  }
  echo '</'.$t.'>';
  if($hijos > 0){
    echo '</ul>';
  }
}
function padre($id,$tipo)
{
  include '../conexion/conexion.php';
  if ($tipo > 4)
  {
    $sel = $con->prepare("SELECT descripcion FROM tipo_unidades_gestion where id = ? ");
    $sel -> bind_param('i',$id);
  }else {
  $sel = $con->prepare("SELECT descripcion FROM red_organizacional WHERE id = ? and tipo = ? order by descripcion");
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
  $sel = $con->prepare("SELECT max(id) FROM red_organizacional WHERE idpa = ? and tipo = ? ");
  $sel->bind_param('si', $id,$tipo);
  $sel->execute();
  $sel->bind_result($mayor);
  if($sel->fetch()){
    return $mayor;
  }
  return 0;
}
function periodos($idcompania, $idorganizacion)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT DISTINCT	p.fecha FROM gastos g INNER JOIN produccion p ON g.fecha = p.fecha WHERE p.idcompania = ? AND p.organizacion = ? ");
  $sel->bind_param('ii', $idcompania,$idorganizacion);
  $sel->execute();
  $sel->bind_result($fecha);

  while($sel->fetch()): ?>
      <option value="<?php echo $fecha?>"><?php echo $fecha?></option>
    <?php endwhile;
    $sel ->close();
  return 0;
}
function ultimoPeriodo($idcompania, $idorganizacion)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT max(fecha) FROM gastos WHERE idcompania = ? AND organizacion = ?");
  $sel->bind_param('ii', $idcompania,$idorganizacion);
  $sel->execute();
  $sel->bind_result($fecha);

  if($sel->fetch()){
    $fecha=date_create($fecha);
    return date_format($fecha,"M-Y");
  }
    else {
      return Date("M-Y");
    }
    $sel ->close();
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
  }elseif ($tipo == 5) {
   return 'Grupo Unidad de gestión';
  }elseif ($tipo == 6) {
   return 'Unidad de gestión';
  }else {
    return '';
  }
}
function pertenece($CodPadre,$tipo)
{
  $clase='';
  include '../conexion/conexion.php';
  if ($tipo == 5)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? AND EsUnidGestion = ? ");
    $es=$tipo-5;
    $sel -> bind_param('si',$CodPadre,$es);
  }elseif ($tipo == 6)
  {
    $sel = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where idpa = ? ORDER BY codigo");
    $sel -> bind_param('s',$CodPadre);
  }else{
  $sel = $con->prepare("SELECT id, descripcion, nivel FROM red_organizacional where idpa = ? and tipo = ? ORDER BY descripcion");
  $sel->bind_param("si", $CodPadre,$tipo);
  }
  $sel -> execute();
  $sel-> store_result();
  $sel -> bind_result($codigo, $descripcion, $nivel );
  while ($sel->fetch()) {
    $sel->close();
    $con->close();
    return true;
  }
  pertenece($codigo,$tipo);
  $sel->close();
  $con->close();
  return false;
}
function obtenerdosfila($prod,$rows,$sel_unid,$funcion, $primaria,$fecha)
{
  include '../conexion/conexion.php';
  $i=0;
  $p=1;
  $total=0;
  $sel_unid->data_seek(0);
  $sel_unid -> bind_result($idug, $unidadgestion);
  $estotal = $funcion==null && $primaria==null;
  $esporcentaje =$funcion==100 && $primaria==100;
 while ($sel_unid ->fetch()):
   if($prod==null){
     $sel_prod = $con->prepare("SELECT if(primaria = 1, 'EGRESOS/CONSULTAS', 'DÍA-PACIENTE'), sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and ug.Funcion = ? and primaria = ? and h.fecha = ? group by producto, primaria");
     $sel_prod -> bind_param('iiis', $idug,$funcion,$primaria,$fecha);

   }
   elseif ($estotal) {
     $sel_prod = $con->prepare("SELECT unidadgestion, sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and h.fecha = ? group by unidadgestion");
      $sel_prod -> bind_param('is', $idug,$fecha);
   }

   elseif ($esunidad) {
     $sel_prod = $con->prepare("SELECT 'POR  UNIDAD DE PROD. FINAL', sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and h.fecha = ? group by unidadgestion");
      $sel_prod -> bind_param('is', $idug,$fecha);
   }
   elseif ($esporcentaje) {
     $sel_prod = $con->prepare("SELECT unidadgestion, (sum(rubro)*100)/(select sum(rubro) from produccion) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and h.fecha = ? group by unidadgestion");
     $sel_prod -> bind_param('is', $idug,$fecha);
   }
   else {
     $sel_prod = $con->prepare("SELECT if(primaria = 1, CONCAT (ug.descripcion,' - ', ug.UnidProdPrim),CONCAT(ug.descripcion,' - ', ug.UnidProdSec)), sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and ug.Funcion = ? and primaria = ? and producto = ? and h.fecha = ? group by producto, primaria");
     $sel_prod -> bind_param('iiiis', $idug,$funcion,$primaria,$prod,$fecha);
     $sql="SELECT if(primaria = 1, CONCAT (ug.descripcion,' - ', ug.UnidProdPrim),CONCAT(ug.descripcion,' - ', ug.UnidProdSec)), sum(rubro) FROM produccion h INNER JOIN tipo_unidades_gestion ug ON h.producto = ug.id WHERE unidadgestion = ? and ug.Funcion = ? and primaria = ? and producto = ? and h.fecha = ? group by producto, primaria".$idug.$funcion.$primaria.$prod;
   }

  //print_r($idug.$funcion.$primaria.$rows.$idug);
    $sel_prod -> execute();
    $sel_prod-> store_result();
    $sel_prod -> bind_result($idin, $insumo);
  //  print_r($sel_unid);
  //  print_r($sql);
   while ($sel_prod ->fetch()):
     if ($i ==$rows && $p==0):
       $p=1;
       $i=0;
       $total=0;
     endif;
     echo $p==1&&(!$estotal&&!$esporcentaje)?"<div class='divTableRow'><div class='divTableCell'>".$idin."</div>":'';
     ?>
     <div class="divTableCell number"><?php echo ($estotal||$esporcentaje?'<b>':'').number_format($insumo, 2, ',', ' ').($estotal||$esporcentaje?'</b>':'')?></div>
   <?php
   $total +=$insumo;
   echo $i==$rows-1?"<div class='divTableCell number'><b>".number_format($total, 2, ',', ' ')."</b></div></div>":'';
   $p=0;
   $i++;
  endwhile;
endwhile;
}

function categoryTree($parent_id = 0, $sub_mark = '',$organizacion){
      include '../conexion/conexion.php';
      $deshabilitado = '';
      $compania = $_SESSION['compania'];
      if(!isset($organizacion))
      {
        $organizacion = 0;
      }
    //$query = $db->query("SELECT * FROM categories WHERE parent_id = $parent_id ORDER BY name ASC");
    $query = $con->query("SELECT idpa, id, descripcion, (SELECT EXISTS(SELECT DISTINCT idpa FROM tipo_unidades_gestion m where m.idpa= a.id)) mayor  FROM tipo_unidades_gestion a where id NOT IN
       (SELECT unidadgestion FROM unidadgestion_organizacion where organizacion = $organizacion) AND idpa = $parent_id AND id_compania = $compania ORDER BY orden ASC");
    if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
          if($row['mayor'] == 1)
          {
            $deshabilitado = 'disabled-link';
            $ref= '';
        }
          else {
            $ref= 'href="#!"';
          }
            echo '<a class="collection-item '.$deshabilitado.'" '.$ref.' id="'.$row['id'].'">'.$sub_mark.$row['descripcion'].'</a>';
            categoryTree($row['id'], $sub_mark.'-',$organizacion);
        }
    }
}
function addLog ($mensaje){
  $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        //"Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
        "Trace: ".serialize(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)).PHP_EOL.
        "User: ".$_SESSION ['nombre'].PHP_EOL.
        "Message: ".$mensaje.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('../Logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
}
function unidadmenor($id)
{
  include '../conexion/conexion.php';
  $sel = $con->prepare("SELECT min(idpa) from tipo_unidades_gestion where id_compania = ?");
  $sel->bind_param('i', $id);
  $sel->execute();
  $sel->bind_result($menor);
  if($sel->fetch()){
    return $menor;
  }
  else {
    return 0;
  }
}

?>
