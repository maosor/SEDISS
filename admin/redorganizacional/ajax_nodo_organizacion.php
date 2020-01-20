<style media="screen">
  html{
    font-size: 14px;
    font-family: "Roboto", sans-serif;
    font-weight: normal;
  }
</style>

<?php
include '../conexion/conexion.php';
include '../extend/funciones.php';
$idpa = htmlentities($_POST['id']);
  $sel = $con->prepare("SELECT id, descripcion, complejidad, poblacion FROM organizacion where idpa = ? ORDER BY descripcion ");
  $sel -> bind_param('i', $idpa);
  $sel -> execute();
  $sel -> bind_result($id, $descripcion,$complejidad,$poblacion );
$hidden = false;
if ($sel->fetch()) {
   $sel->close();
   $hidden = true;
 }
   ?>
    <div class="row">
      <a id ='del' class="btn-floating btn-large red right <?php echo $hidden==true?'':'hidden'?>" style= "margin-left: 5px;"><i
        class="material-icons">delete</i></a>
      <a id ='ins' class="btn-floating btn-large green right <?php echo $hidden==true?'hidden':''?>"> <i
        class="material-icons">check</i></a>
      <a id ='up' class="btn-floating btn-large blue right <?php echo $hidden==true?'':'hidden'?>" style= "margin-left: 5px;"><i
        class="material-icons">save</i></a>
      <br>
        <br>
      <div></div>
      <input type="hidden" id = "id" name="id" value="<?php echo $id?>">
      <input type="hidden" id = "idpa" name="idpa" value="<?php echo $idpa?>">
      </div>
    <div class="row">
     <div class = "input-field col s12">
       <input type="text" name="descripcion" title="descripcion" id="descripcion" focus=true value="<?php echo $descripcion ?>" >
       <label class="active" for="descripcion">Organización</label>
     </div>
   </div>
   <div class = "row">
     <?php
      $sel_niv= $con->prepare("SELECT id, descripcion FROM red_organizacional where tipo = 2 AND id not in (SELECT DISTINCT codpadre FROM red_organizacional where tipo = 2) ORDER BY descripcion");
      $sel_niv-> execute();
      $sel_niv-> bind_result($nivid, $nivdescripcion ); ?>
     <label for="complejidad">Nivel de complejidad</label>
        <select id="complejidad"class="form-control">
          <option value="<?php echo $complejidad?>" selected disabled><?php echo padre($complejidad,2)?></option>
            <?php while ($sel_niv ->fetch()): ?>
              <option value="<?php echo $nivid?>"><?php echo $nivdescripcion?></option>
            <?php endwhile;
            $sel_niv ->close();?>
        </select>
   </div>
   <div class="row">
    <div class = "input-field col s12">
      <input type="text" name="poblacion" title="poblacion" id="poblacion" focus=true value="<?php echo $poblacion ?>" >
      <label class="active" for="poblacion">Población</label>
    </div>
  </div>
   <div class = "row">
     <input type="hidden" name="unidad" id="unidad">
     <?php
      $sel_uni= $con->prepare("SELECT id, descripcion FROM tipo_unidades_gestion where id not in (SELECT DISTINCT idpa FROM tipo_unidades_gestion) AND id NOT IN
      (SELECT unidadgestion FROM unidadgestion_organizacion) ORDER BY descripcion");
      $sel_uni-> execute();
      $sel_uni-> bind_result($uniid, $unidescripcion ); ?>
     <label for="unidadgestion">Unidades de Gestión</label>
     <a id ='add' class="btn-floating  blue darken-4 right"  style= "margin-left: 5px;" disabled><i
       class="material-icons">arrow_downward</i></a>

        <div id="unidadgestion" class="collection">
              <?php while ($sel_uni ->fetch()): ?>
              <a class="collection-item" href="#!" id="<?php echo $uniid?>"><?php echo $unidescripcion?></a>
            <?php endwhile;
            $sel_uni ->close();?>
        </div>
   </div>
   <div class = "row">
     <?php
      $sel_uni_org= $con->prepare("SELECT ug.id, ug.descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion ug ON uo.unidadgestion = ug.id WHERE uo.organizacion = ? ORDER BY ug.descripcion");
      $sel_uni_org -> bind_param('i',$id);
      $sel_uni_org-> execute();
      $sel_uni_org-> bind_result($uniorgid, $uniorgdescripcion ); ?>
      <label for="unidadgestionorganizacion">Unidades de Gestión de la Organización</label>
      <a id ='rem' class="btn-floating  blue darken-4 right" style= "margin-left: 5px;" disabled><i
        class="material-icons">arrow_upward</i></a>
        <div id="unidadgestionorganizacion" class="collection">
              <?php while ($sel_uni_org ->fetch()): ?>
              <a class="collection-item" href="#!" id="<?php echo $uniorgid?>"><?php echo $uniorgdescripcion?></a>
            <?php endwhile;
            $sel_uni_org ->close();?>
        </div>
   </div>
 </div>
</div>
 <script type="text/javascript">

 $('#add').click(function(){
   $.post('addunidad.php',{
     id:$('#id').val(),
     unidad:$('#unidad').val(),
     beforeSend: function () {
       $('#unidadgestionorganizacion').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#unidadgestionorganizacion').html(respuesta);
         $('#unidadgestion #'+$('#unidad').val()).remove();
         $('#rem, #add').attr('disabled','disabled');
   });
 });
 $('#rem').click(function(){
   $.post('remunidad.php',{
     id:$('#id').val(),
     unidad:$('#unidad').val(),
     beforeSend: function () {
       $('#unidadgestion').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#unidadgestion').html(respuesta);
         $('#unidadgestionorganizacion #'+$('#unidad').val()).remove();
         $('#rem, #add').attr('disabled','disabled');
   });
 });
 $('#up').click(function(){
   $.post('up_red.php',{
     id:$('#id').val(),
     descripcion:$('#descripcion').val(),
     complejidad:$('#complejidad option:selected').val(),
     poblacion:$('#poblacion').val(),
     idpa:$('#idpa').val(),
     beforeSend: function () {
       $('#tree1 > ul').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#tree1 > ul').html(respuesta);
   });
 });
 $('#ins').click(function(){
   $.post('ins_red.php',{
     id:$('#id').val(),
     descripcion:$('#descripcion').val(),
     complejidad:$('#complejidad option:selected').val(),
     poblacion:$('#poblacion').val(),
     idpa:$('#idpa').val(),
     beforeSend: function () {
       $('#tree1 > ul').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#tree1 > ul').html(respuesta);
   });
 });
 $('#del').click(function(){
   $.post('del_red.php',{
     id:$('#id').val(),
     beforeSend: function () {
       $('#tree1 > ul').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#tree1 > ul').html(respuesta);
   });
 });
 $('.collection-item').click(function(){
  $('.collection .active').removeClass('active');
  $(this).addClass("active");
  $('#unidad').val($(this).attr('id'));
});
$('#unidadgestionorganizacion .collection-item').click(function(){
  $('#rem').removeAttr('disabled');
  $('#add').attr('disabled');
});
$('#unidadgestion .collection-item').click(function(){
  $('#add').removeAttr('disabled');
  $('#rem').attr('disabled');
});
 </script>
