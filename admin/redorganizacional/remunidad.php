<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$org= htmlentities($_POST['id']);
$uni=htmlentities($_POST['unidad']);
  $del = $con->prepare("DELETE FROM unidadgestion_organizacion WHERE organizacion = ? AND unidadgestion = ? ");
  $del -> bind_param('ii',$org, $uni);
  if ($del -> execute()) {
    $sel_uni_org= $con->prepare("SELECT id, descripcion FROM tipo_unidades_gestion where id not in (SELECT DISTINCT idpa FROM tipo_unidades_gestion) AND id NOT IN
    (SELECT unidadgestion FROM unidadgestion_organizacion where organizacion = ?) ");
    $sel_uni_org -> bind_param('i',$org);
    $sel_uni_org-> execute();
    $sel_uni_org-> bind_result($uniorgid, $uniorgdescripcion );
         while ($sel_uni_org ->fetch()): ?>
            <a class="collection-item" href="#!" id="<?php echo $uniorgid?>"><?php echo $uniorgdescripcion?></a>
          <?php endwhile;
          $sel_uni_org ->close();
}else {
    echo 'Error Eliminando...';
  }
  $del ->close();
}
 ?>
 <script type="text/javascript">
 $('.collection-item').click(function(){
  $('.collection .active').removeClass('active');
  $(this).addClass("active");
  $('#unidad').val($(this).attr('id'));
  $('#rem, #add').attr('disabled','disabled');
});
$('#unidadgestion .collection-item').click(function(){
  $('#add').removeAttr('disabled');
  $('#rem').attr('disabled');
});
 </script>
