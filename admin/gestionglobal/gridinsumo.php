<?php
include '../conexion/conexion.php';
if($_POST){
  $organizacion=$_POST['organizacion'];
  $fecha=$_POST['fecha'];
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
    <b>Rubro</b>
  </div>
</div>
<?php
$sel_unid = $con->prepare("SELECT DISTINCT ug.id, ug.Descripcion FROM gastos g INNER JOIN tipo_unidades_gestion ug ON g.unidadgestion = ug.id WHERE g.idcompania = 1 AND g.organizacion = ? AND fecha = ? order by ug.id");
$sel_unid -> bind_param('is', $organizacion, $fecha);
$sel_unid -> execute();
$sel_unid-> store_result();
$sel_unid -> bind_result($idug, $unidadgestion);
if($sel_unid->num_rows == 0){
  header('document:index.php');
}
while ($sel_unid ->fetch()): ?>
<div class="row">
  <div id="<?php echo $idug?>" class="col s12 dvunidad">
        <div class="col s4">
          <span><?php echo $unidadgestion ?></span>
        </div>
        <div class="input-field col s8">
          <?php
          $sel_insu = $con->prepare("SELECT ro.id, ro.descripcion, g.rubro from gastos g inner join red_organizacional ro on g.insumo = ro.id and tipo = 4 WHERE g.idcompania = 1 AND g.organizacion = ? AND  g.unidadgestion = ? AND fecha = ? order by ro.id ");
          $sel_insu -> bind_param('iis', $organizacion,$idug, $fecha);
          $sel_insu -> execute();
          $sel_insu-> store_result();
          $sel_insu -> bind_result($idin, $insumo, $rubro);
            while ($sel_insu ->fetch()): ?>
              <div class="col s12 dvinsumo">
                <div class="row ">
                  <div class="col s8">
                    <span>  <?php echo $insumo ?></span>
                  </div>
                  <div class="col s4 ">
                      <input class="inprubro" id="<?php echo $idin?>" type="text"  title="rubro" value="<?php echo $rubro?>" >
                  </div>
                </div>
              </div>
          <?php endwhile;
        $sel_insu ->close();?>
      </div>
    </div>
  </div>
  <?php endwhile;
  $sel_unid ->close();
