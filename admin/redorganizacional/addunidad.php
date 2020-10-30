<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
if ($_SERVER['REQUEST_METHOD']== 'POST'){
$org= htmlentities($_POST['id']);
$uni=htmlentities($_POST['unidad']);
$compania = $_SESSION['compania'];
  $ins = $con->prepare("INSERT INTO unidadgestion_organizacion VALUES (?,?) ");
  $ins -> bind_param('ii',$org, $uni);
  if ($ins -> execute()) {
     $sel_uni_org= $con->prepare("SELECT ug.id, ug.descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion ug ON uo.unidadgestion = ug.id WHERE uo.organizacion = ? AND ug.id_compania = ?
     ORDER BY ug.funcion, Concat(0,(select orden from tipo_unidades_gestion where id = ug.idpa), ug.orden)*1");
     $sel_uni_org -> bind_param('ii',$org,$compania);
     $sel_uni_org-> execute();
    $sel_uni_org-> bind_result($uniorgid, $uniorgdescripcion );
          while ($sel_uni_org ->fetch()): ?>
              <a class="collection-item" href="#!" id="<?php echo $uniorgid?>"><?php echo $uniorgdescripcion?></a>
           <?php endwhile;
           $sel_uni_org ->close();
  //  categoryTree(-1,'',$org);
}else {
    echo 'Error Insertando...';
  }
  $ins ->close();
}
 ?>
 <script type="text/javascript">
 $('.collection-item').click(function(){
  $('.collection .active').removeClass('active');
  $(this).addClass("active");
  $('#unidad').val($(this).attr('id'));

});
$('#unidadgestionorganizacion .collection-item').click(function(){
  $('#rem').removeAttr('disabled');
  $('#add').attr('disabled');
});
 </script>
