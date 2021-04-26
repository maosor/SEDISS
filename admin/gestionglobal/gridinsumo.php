<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha='01-'.$_POST['fecha'];
  $fecha=date("Y-m-t", strtotime($fecha));
  $compania = $_SESSION['compania'];
}
 ?>
<br><br><br>
<div class="row">
  <div class="col s4">
    <b>Unidad de gestión</b>
  </div>
  <div class="col s5">
    <b>Insumo</b>
  </div>
  <div class="col s3">
    <b>Monto</b>
  </div>
</div>
<?php
$sel_unid = $con->prepare("SELECT DISTINCT ug.id, ug.Descripcion FROM gastos g INNER JOIN tipo_unidades_gestion ug ON g.unidadgestion = ug.id WHERE g.idcompania = ? AND g.organizacion = ? AND fecha = ? order by funcion, CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? and id = ug.idpa),ug.orden)*1,orden");
$sel_unid -> bind_param('iisi', $compania, $organizacion, $fecha,$compania);
$sel_unid -> execute();
$sel_unid-> store_result();
$sel_unid -> bind_result($idug, $unidadgestion);
$sql1="SELECT DISTINCT ug.id, ug.Descripcion FROM gastos g INNER JOIN tipo_unidades_gestion ug ON g.unidadgestion = ug.id WHERE g.idcompania = ".$compania." AND g.organizacion = ".$organizacion." AND fecha = '".$fecha."' order by funcion, CONCAT(0,(SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ".$compania." and id = ug.idpa),ug.orden)*1,orden";
addLog($sql1);
 $resultado='';
 $sql='';
if($sel_unid->num_rows == 0){
  header('document:index.php');
}
while ($sel_unid ->fetch()): ?>
<div class="row">
  <div id="g-<?php echo $idug?>" class="col s12 dvunidad blue lighten-5">
        <div class="col s4">
          <span><b><?php echo $unidadgestion ?></b></span>
        </div>
        <div class="input-field col s8">
          <?php
          $sel_insu = $con->prepare("SELECT ro.id, ro.descripcion, g.rubro from gastos g inner join red_organizacional ro on g.insumo = ro.id and tipo = 4 and g.idcompania = ro.id_compania WHERE g.idcompania = ? AND g.organizacion = ? AND  g.unidadgestion = ? AND fecha = ? order by
          CONCAT(0,(SELECT orden FROM red_organizacional WHERE id_compania = ? AND tipo = 4 and id = ro.idpa),orden)*1,ro.orden ");
          $sel_insu -> bind_param('iiisi', $compania, $organizacion,$idug, $fecha,$compania);
          $sel_insu -> execute();
          $sel_insu-> store_result();
          $sel_insu -> bind_result($idin, $insumo, $rubro);
            while ($sel_insu ->fetch()): ?>
              <div class="col s12 dvinsumo white">
                <div class="row ">
                  <div class="col s8">
                    <span>  <?php echo $insumo ?></span>
                  </div>
                  <div class="col s4 ">
                      <input class="inprubro" id="g-<?php echo $idin?>" type="text"  title="rubro" value="<?php echo $rubro?>" >
                  </div>
                </div>
              </div>

          <?php $resultado.= "(".$idin.$insumo.$rubro.")";
        endwhile;
          $sql.="SELECT ro.id, ro.descripcion, g.rubro from gastos g inner join red_organizacional ro on g.insumo = ro.id and tipo = 4 and g.idcompania = ro.id_compania WHERE g.idcompania =".$compania." AND g.organizacion =".$organizacion." AND  g.unidadgestion = ".$idug." AND fecha = '".$fecha."' order by
          CONCAT(0,(SELECT orden FROM red_organizacional WHERE id_compania =".$compania." AND tipo = 4 and id = ro.idpa),orden)*1,ro.orden ";
          addLog($sql);
          addLog($resultado);
        $sel_insu ->close();?>
      </div>
      <div class="col s4">
        <span><br></span>
      </div>
    </div>
  </div>
  <?php endwhile;
  $sel_unid ->close();
