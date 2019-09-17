<style media="screen">
  html{
    font-size: 14px;
    font-family: "Roboto", sans-serif;
    font-weight: normal;
  }
</style>
<?php
include '../conexion/conexion.php';
$codigo = htmlentities($_POST['codigo']);
$sel = $con->prepare("SELECT codigo, descripcion, codpadre, nivel,orden FROM red_organizacional where codigo = ? ");
$sel -> bind_param('s',$codigo);
$sel -> execute();
$sel -> bind_result($codigo, $descripcion,$codpadre,$nivel,$orden );
if ($sel->fetch()) {
 ?>
 <div class="row">
   <a id ='ins' class="btn-floating green left"><i
     class="material-icons">add</i></a>
   <a id ='up' class="btn-floating blue left" style= "margin-left: 5px;"><i
     class="material-icons">save</i></a>
   <br>
     <br>
   <input type="hidden" id = "codigo" name="codigo" value="<?php echo $codigo?>">
   <input type="hidden" id = "codpadre" name="codpadre" value="<?php echo $codpadre?>">
 </div>
 <div class="row">
   <div class = "input-field col s12">
     <input type="text" name="descripcion" title="descripcion" id="descripcion" focus=true value="<?php echo $descripcion ?>" >
     <label class="active" for="descripcion">Descripción</label>
   </div>
 </div>
 <div class="row">
   <div class = "input-field col s6">
     <input type="text" name="nivel" title="nivel" id="nivel" focus=true value="<?php echo $nivel ?>" >
     <label class="active" for="nivel">Nivel</label>
   </div>
   <div class = "input-field col s6">
     <input type="text" name="orden" title="orden" id="orden" focus=true value="<?php echo $orden ?>" >
     <label class="active" for="orden">Orden</label>
   </div>
 </div>
</div>
 </div>
<?php
}
$sel -> close();
 ?>
 <script type="text/javascript">
 $('#up').click(function(){
   $.post('up_red.php',{
     codigo:$('#codigo').val(),
     codpadre:$('#codpadre').val(),
     descripcion:$('#descripcion').val(),
     nivel:$('#nivel').val(),
     orden:$('#orden').val(),
     beforeSend: function () {
       $('#tree1 > ul').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#tree1 > ul').html(respuesta);
   });
 });
 $('#ins').click(function(){
   $.post('ins_red.php',{
     codigo:$('#codigo').val(),
     codpadre:$('#codpadre').val(),
     descripcion:$('#descripcion').val(),
     nivel:$('#nivel').val(),
     orden:$('#orden').val(),
     beforeSend: function () {
       $('#tree1 > ul').html('Espere un momento por favor');
      }
    }, function (respuesta) {
         $('#tree1 > ul').html(respuesta);
   });
 });
 </script>
