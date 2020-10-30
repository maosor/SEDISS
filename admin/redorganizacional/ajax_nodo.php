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
$id = htmlentities($_POST['id']);
$tipo = htmlentities($_POST['tipo']);
$compania = $_SESSION['compania'];
if ($tipo > 4)
{
  $sel = $con->prepare("SELECT id, codigo, descripcion, idpa, nivel,orden, Hereda, TieneCamas, Comprensiva,
    UnidProdPrim, UnidProdSec, UnidProdValorRel1, UnidProdValorRel2,RecursoNuclear,Funcion,PerteneceA  FROM tipo_unidades_gestion where id = ? and id_compania = ? ORDER BY descripcion");
  $sel -> bind_param('si',$id,$compania);
  $sel -> execute();
  $sel -> bind_result($id, $codigo, $descripcion,$idpa,$nivel,$orden, $hereda, $camas, $comprensiva,
  $primaria, $secundaria, $prelativo, $srelativo,$RecursoNuclear,$Funcion,$PerteneceA );
}else {
  $sel = $con->prepare("SELECT id, codigo, descripcion, idpa, nivel,orden FROM red_organizacional where id = ? and tipo = ? and id_compania = ? ORDER BY descripcion");
  $sel -> bind_param('sii',$id,$tipo,$compania);
  $sel -> execute();
  $sel -> bind_result($id, $codigo, $descripcion,$idpa,$nivel,$orden );
  $hereda=0; $camas=0; $comprensiva=0; $primaria=''; $secundaria=''; $prelativo=0; $srelativo=0;$RecursoNuclear=0;$Funcion=0;$PerteneceA=0;
}
if ($sel->fetch()) {
   $sel->close();
   $hidden = true;
 }
   else {
     $hidden = false;
     $nivel=0;$orden='';
     $padcodigo=''; $paddescripcion='';$padnivel=0;
     $hereda=0; $camas=0; $comprensiva=0; $primaria=''; $secundaria=''; $prelativo=0; $srelativo=0;
   }
   if ($tipo > 4)
   {
     $sel_lst = $con->prepare("SELECT id, descripcion, nivel FROM tipo_unidades_gestion where EsUnidGestion = 0  and idpa = 0 and id_compania = ? ORDER BY orden");
     $sel_lst -> bind_param('i',$compania);
   }else {
     $sel_lst = $con->prepare("SELECT id, descripcion, nivel FROM red_organizacional where tipo = ? and (id in (select idpa from red_organizacional) or idpa = 0) and id_compania = ?  ORDER BY descripcion");
     $sel_lst -> bind_param('ii',$tipo,$compania);
  }
   $sel_lst -> execute();
   $sel_lst -> bind_result($padid, $paddescripcion,$padnivel );
   //echo $padcodigo.$paddescripcion.$padnivel;
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
      </div>
    <div class="row">
      <div class="form-group">
      <label for="idpa">Padre</label>
      <select  class="form-control" id="idpa" name="idpa" required value = "1">
        <option value="<?php echo $idpa?>" selected disabled><?php echo padre($idpa,$tipo)?></option>
        <option value="" >---PADRE---</option>
          <?php while ($sel_lst ->fetch()): ?>
            <option nivel='<?php echo $padnivel?>' value="<?php echo $padid?>"><?php echo $paddescripcion?></option>
          <?php endwhile;
          $sel_lst ->close();?>
      </select>
      </div>
    </div>
    <div class="row">
     <div class = "input-field col s12" style="display:none;">
       <input type="text" id = "codigo" name="codigo" disabled value="<?php echo $id?>">
       <label class="active" for="codigo">Código</label>
     </div>
   </div>
    <div class="row">
     <div class = "input-field col s8">
       <input type="text" name="descripcion" title="descripcion" id="descripcion" focus=true value="<?php echo $descripcion ?>" >
       <label class="active" for="descripcion">Descripción</label>
     </div>
     <div class = "input-field col s4">
       <input type="text" name="orden" title="orden" id="orden" focus=true value="<?php echo $orden ?>" >
       <label class="active" for="orden">Prioridad</label>
     </div>
   </div>
 <!-- Se ocultó porque no se mostrará si no lo solicitan -->
    <div class="row hidden">
     <div class = "input-field col s6">
       <input type="text" name="nivel" title="nivel" id="nivel" focus=true value="<?php echo $nivel ?>" >
       <label class="active" for="nivel">Nivel</label>
     </div>
   </div>
</div>
 </div>
<div class="grupos <?php echo $tipo < 5 ?'hidden':''?>">
  <div class="row">
    <!-- <div class="col s4">
      <input type="checkbox" class="filled-in" name="hereda"
      id="hereda" <?php //echo $hereda==1?"checked":""?>/>
      <label for="hereda">Hereda </label>
    </div> -->
      <div class="col s4">
      <input type="checkbox" class="filled-in" name="camas"
      id="camas" <?php echo $camas==1?"checked":""?> />
      <label for="camas">Tiene Camas</label>
    </div>
    <!-- <div class="col s4">
      <input type="checkbox" class="filled-in" name="comprensiva"
      id="comprensiva" <?php //echo $comprensiva==1?"checked":""?>/>
      <label for="comprensiva">Comprensiva</label>
    </div> -->
  </div>
  <div class="row">
    <div class = "input-field col s8">
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
      <input type="text" name="primaria" title="primaria" id="primaria" focus=true value="<?php echo $primaria ?>" >
      <label class="active" for="primaria">Primaria</label>
    </div>
    <div class = "input-field col s4">
      <input type="text" name="prelativo" title="prelativo" id="prelativo" focus=true value="<?php echo $prelativo ?>" >
      <label class="active" for="prelativo">Valor Relativo</label>
    </div>
  </div>
  <div class="row">
    <div class = "input-field col s8">
      <input type="text" name="secundaria" title="secundaria" id="secundaria" focus=true value="<?php echo $secundaria ?>" >
      <label class="active" for="secundaria">Secundaria</label>
    </div>
    <div class = "input-field col s4">
      <input type="text" name="srelativo" title="srelativo" id="srelativo" focus=true value="<?php echo $srelativo ?>" >
      <label class="active" for="srelativo">Valor Relativo</label>
    </div>
  </div>
</div>
<div class="unidad <?php echo $tipo!=6?'hidden':'' ?>">
  <div class="row">
    <div class = "input-field col s4">
      <input type="text" name="RecursoNuclear" title="RecursoNuclear" id="RecursoNuclear" focus=true value="<?php echo $RecursoNuclear  ?>" >
      <label class="active" for="RecursoNuclear">Recurso Nuclear</label>
    </div>
    <div class="col s3">
    <label for="funcion">Función</label>
    <select id="funcion"class="form-control">
      <option value="<?php echo $Funcion?>" disabled selected><?php echo $Funcion==0?'Final':'Apoyo'?></option>
      <option value="0">Final</option>
      <option value="1">Apoyo</option>
    </select>

 </div>
    <div class = "col s5">
      <?php
       $sel_per= $con->prepare("SELECT id, descripcion FROM red_organizacional where tipo = 3 AND id not in (SELECT DISTINCT codpadre FROM red_organizacional where tipo = 3)and id_compania = ?  ORDER BY descripcion");
       $sel_per -> bind_param('i',$compania);
       $sel_per-> execute();
       $sel_per-> bind_result($perid, $perdescripcion ); ?>
      <label for="pertenece">Pertenece a</label>
         <select id="pertenece"class="form-control">
           <option value="<?php echo $PerteneceA?>" selected disabled><?php echo padre($PerteneceA,3)?></option>
             <?php while ($sel_per ->fetch()): ?>
               <option value="<?php echo $perid?>"><?php echo $perdescripcion?></option>
             <?php endwhile;
             $sel_per ->close();?>
         </select>
    </div>
  </div>
</div>
<?php


/*$sel -> close();*/
 ?>
 <script type="text/javascript">
 $('#up').click(function(){
   $.post('up_red.php',{
     id:$('#id').val(),
     codigo:$('#codigo').val(),
     idpa:$('#idpa option:selected').val(),
     descripcion:$('#descripcion').val(),
     nivel:$('#nivel').val(),
     camas:$('#camas').is(":checked"),
     orden:$('#orden').val(),
     primaria:$('#primaria').val(),
     prelativo:$('#prelativo').val(),
     secundaria:$('#secundaria').val(),
     srelativo:$('#srelativo').val(),
     tipo:$('#tipo').val(),
     RecursoNuclear:$('#RecursoNuclear').val(),
     funcion:$('#funcion option:selected').val(),
     pertenece:$('#pertenece option:selected').val(),
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
     idpa:$('#idpa option:selected').val(),
     descripcion:$('#descripcion').val(),
     nivel:$('#nivel').val(),
     camas:$('#camas').is(":checked"),
     orden:$('#orden').val(),
     primaria:$('#primaria').val(),
     prelativo:$('#prelativo').val(),
     secundaria:$('#secundaria').val(),
     srelativo:$('#srelativo').val(),
     tipo:$('#tipo').val(),
     RecursoNuclear:$('#RecursoNuclear').val(),
     funcion:$('#funcion option:selected').val(),
     pertenece:$('#pertenece option:selected').val(),
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
     tipo:$('#tipo').val(),
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
    mayor = $('#codpadre option:selected').attr('mayor');
   var mayor = $('#codpadre option:selected').attr('mayor');
   var nivel = $('#codpadre option:selected').attr('nivel');

   var codigo = $('#codpadre option:selected').val();
   var nuevo = codigo.substring(0,nivel*3);
  // alert(codigo);
   if (mayor== null || mayor == ''){
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
