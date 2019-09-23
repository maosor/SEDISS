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
$codigo = htmlentities($_POST['codigo']);
$sel = $con->prepare("SELECT id, codigo, descripcion, codpadre, nivel,orden FROM red_organizacional where codigo = ? ");
$sel -> bind_param('s',$codigo);
$sel -> execute();
$sel -> bind_result($id, $codigo, $descripcion,$codpadre,$nivel,$orden );

if ($sel->fetch()) {
 $sel->close();
 $sel_lst = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional ");
 $sel_lst -> execute();
 $sel_lst -> bind_result($padcodigo, $paddescripcion,$padnivel );

    ?>
    <div class="row">
      <a id ='ins' class="btn-floating green left"><i
        class="material-icons">add</i></a>
      <a id ='up' class="btn-floating blue left" style= "margin-left: 5px;"><i
        class="material-icons">save</i></a>
      <br>
        <br>
      <input type="hidden" id = "id" name="id" value="<?php echo $id?>">
      </div>
    <div class="row">
      <div class="form-group">
      <label for="padre">Padre</label>
      <select  class="form-control" id="codpadre" name="codpadre" required value = "1">
        <option value="<?php echo $codpadre?>" disabled selected><?php echo padre($codpadre)?></option>
          <?php while ($sel_lst ->fetch()): ?>
            <option mayor = '<?php echo mayor($padcodigo)?>' nivel='<?php echo $padnivel?>' value="<?php echo $padcodigo?>"><?php echo $paddescripcion?></option>
          <?php endwhile;
          $sel_lst ->close();?>
      </select>
      </div>
    </div>
   <div class="row">
     <div class = "input-field col s12">
       <input type="text" id = "codigo" name="codigo" disabled value="<?php echo $codigo?>">
       <label class="active" for="codigo">Código</label>
     </div>
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

//$sel -> close();
 ?>
 <script type="text/javascript">
//  $('select').formSelect();
 $('#up').click(function(){
   $.post('up_red.php',{
     id:$('#id').val(),
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
 function padleft (str, max) {
  str = str.toString();
  return str.length < max ? padleft("0" + str, max) : str;
}
function padright(num, string, char) {
    for (var i = 0; i < num; i++) {
        string += char;
    }
    return string;
}

 $( "#codpadre" ).change(function() {
   var nivel = $('#codpadre option:selected').attr('nivel');
   var mayor = $('#codpadre option:selected').attr('mayor');
   var codigo = $('#codpadre option:selected').val();
   var nuevo = codigo.substring(0,nivel*3);
  // alert(codigo);
   if (mayor == ''){
     nuevo = nuevo.concat('001');
           }
   else {
     nuevo = nuevo.concat(padleft(parseInt(mayor.substring(nivel*3, (nivel*3)+3))+1,3));
     }
     nuevo = padright(60-nuevo.length,nuevo,'0');
     $('#codigo').val(nuevo);
     $('#nivel').val(parseInt(nivel)+1);

  //alert(60,nuevo,'0'));

  // $(".dvdetalle").load();
});
 </script>
