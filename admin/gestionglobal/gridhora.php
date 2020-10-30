<?php
include '../conexion/conexion.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
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
    <b>Horas</b>
  </div>
</div>
<?php
$sel_unid = $con->prepare("SELECT DISTINCT ug.id, ug.Descripcion FROM horas h INNER JOIN tipo_unidades_gestion ug ON h.unidadgestion = ug.id WHERE h.idcompania = ? AND h.organizacion = ? AND fecha = ?
order by CONCAT((SELECT orden FROM tipo_unidades_gestion WHERE id_compania = ? AND id = ug.idpa),ug.orden)*1,orden");
$sel_unid -> bind_param('iisi',$compania, $organizacion, $fecha,$compania);
$sel_unid -> execute();
$sel_unid-> store_result();
$sel_unid -> bind_result($idug, $unidadgestion);
if($sel_unid->num_rows == 0){
  header('document:index.php');
}
while ($sel_unid ->fetch()): ?>
<div class="row">
  <div id="h-<?php echo $idug?>" class="col s12 dvunidad blue lighten-5">
        <div class="col s4">
          <span><b><?php echo $unidadgestion ?></b></span>
        </div>
        <div class="input-field col s8">
          <?php
          $sel_insu = $con->prepare("SELECT ro.id, ro.descripcion, h.rubro from horas h inner join red_organizacional ro on h.recurso = ro.id and tipo = 3 WHERE h.idcompania = ? AND h.organizacion = ? AND  h.unidadgestion = ? AND fecha = ? order by orden,id ");
          $sel_insu -> bind_param('iiis',$compania, $organizacion,$idug, $fecha);
          $sel_insu -> execute();
          $sel_insu-> store_result();
          $sel_insu -> bind_result($idin, $insumo, $rubro);
            while ($sel_insu ->fetch()): ?>
              <div class="col s12 dvhora white">
                <div class="row ">
                  <div class="col s8">
                    <span>  <?php echo $insumo ?></span>
                  </div>
                  <div class="col s4 ">
                      <input class="inphora" id="h-<?php echo $idin?>" type="text"  title="hora" value="<?php echo $rubro?>" >
                  </div>
                </div>
              </div>
            <?php endwhile;
        $sel_insu ->close();?>
      </div>
      <div class="col s4">
        <span><br></span>
      </div>
    </div>
  </div>
  <br>
  <?php endwhile;
  $sel_unid ->close();
