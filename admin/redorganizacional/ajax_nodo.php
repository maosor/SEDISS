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
$tipo = htmlentities($_POST['tipo']);

if ($tipo > 4)
{
  $sel = $con->prepare("SELECT id, codigo, descripcion, codpadre, nivel,orden, Hereda, TieneCamas, Comprensiva, UnidProdPrim, UnidProdSec, UnidProdValorRel1, UnidProdValorRel2  FROM tipo_unidades_gestion where codigo = ? ");
  $sel -> bind_param('s',$codigo);
  $sel -> execute();
  $sel -> bind_result($id, $codigo, $descripcion,$codpadre,$nivel,$orden, $hereda, $camas, $comprensiva, $primaria, $secundaria, $prelativo, $srelativo );
}else {
  $sel = $con->prepare("SELECT id, codigo, descripcion, codpadre, nivel,orden FROM red_organizacional where codigo = ? and tipo = ? ");
  $sel -> bind_param('si',$codigo,$tipo);
  $sel -> execute();
  $sel -> bind_result($id, $codigo, $descripcion,$codpadre,$nivel,$orden );
  $hereda=0; $camas=0; $comprensiva=0; $primaria=''; $secundaria=''; $prelativo=0; $srelativo=0;
}

if ($sel->fetch()) {
   $sel->close();
   if ($tipo > 4)
   {
     $esunidgestion = $tipo-5;
     $sel_lst = $con->prepare("SELECT codigo, descripcion, nivel FROM tipo_unidades_gestion where EsUnidGestion = ? ");
     $sel_lst -> bind_param('i',$esunidgestion);
   }else {
     $sel_lst = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional where tipo = ? ");
     $sel_lst -> bind_param('i',$tipo);
  }
   $sel_lst -> execute();
   $sel_lst -> bind_result($padcodigo, $paddescripcion,$padnivel );
   echo $padcodigo.$paddescripcion.$padnivel;
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
      <label for="codpadre">Padre</label>
      <select  class="form-control" id="codpadre" name="codpadre" required value = "1">
        <option value="<?php echo $codpadre?>" selected disabled><?php echo padre($codpadre,$tipo)?></option>
        <option value="" ></option>
          <?php while ($sel_lst ->fetch()): ?>
            <option mayor = '<?php echo mayor($padcodigo,$tipo)?>' nivel='<?php echo $padnivel?>' value="<?php echo $padcodigo?>"><?php echo $paddescripcion?></option>
          <?php endwhile;
          $sel_lst ->close();?>
      </select>
      </div>
    </div>
    <div class="row">
     <div class = "input-field col s12" style="display:none;">
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
 <!-- Se ocultó porque no se mostrará si no lo solicitan -->
    <div class="row hidden">
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
<div class="grupos <?php echo $tipo < 5 ?'hidden':''?>">
  <div class="row">
    <div class="col s4">
      <input type="checkbox" class="filled-in" name="hereda"
      id="hereda" <?php echo $hereda==1?"checked":""?>/>
      <label for="hereda">Hereda </label>
    </div>
      <div class="col s4">
      <input type="checkbox" class="filled-in" name="camas"
      id="camas" <?php echo $camas==1?"checked":""?>/>
      <label for="camas">Tiene Camas</label>
    </div>
    <div class="col s4">
      <input type="checkbox" class="filled-in" name="comprensiva"
      id="comprensiva" <?php echo $comprensiva==1?"checked":""?>/>
      <label for="comprensiva">Comprensiva</label>
    </div>
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
      <input type="text" name="primaria" title="secundaria" id="secundaria" focus=true value="<?php echo $secundaria ?>" >
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
      <input type="text" name="RecursoNuclearv " title="RecursoNuclearv " id="RecursoNuclearv " focus=true value="<?php /*echo RecursoNuclearv*/  ?>" >
      <label class="active" for="RecursoNuclearv ">Recurso Nuclear</label>
    </div>
    <div class="col s3">
    <label for="funcion">Función</label>
    <select id="funcion"class="form-control">
      <option value="" disabled selected></option>
      <option value="1">Final</option>
      <option value="2">Apoyo</option>
    </select>

</div>
    <div class = "col s5">
      <?php
       $sel_per= $con->prepare("SELECT codigo, descripcion FROM red_organizacional where tipo = ? AND codigo not in (SELECT DISTINCT codpadre FROM red_organizacional where tipo = 3)");
       $sel_per-> bind_param('i',$tipo);
       $sel_per-> execute();
       $sel_per-> bind_result($percodigo, $perdescripcion ); ?>
      <label for="pertenece">Pertenece a</label>
         <select id="pertenece"class="form-control">
           <option value="<?php echo $codpadre?>" selected disabled><?php echo padre($codpadre,$tipo)?></option>
             <?php while ($sel_per ->fetch()): ?>
               <option value="<?php echo $percodigo?>"><?php echo $perdescripcion?></option>
             <?php endwhile;
             $sel_per ->close();?>
         </select>
    </div>
  </div>
</div>
<?php
}

/*$sel -> close();*/
 ?>
 <script type="text/javascript">
 $('#up').click(function(){
   $.post('up_red.php',{
     id:$('#id').val(),
     codigo:$('#codigo').val(),
     codpadre:$('#codpadre').val(),
     descripcion:$('#descripcion').val(),
     nivel:$('#nivel').val(),
     orden:$('#orden').val(),
     primaria:$('#primaria').val(),
     prelativa:$('#prelativa').val(),
     secundaria:$('#secundaria').val(),
     srelativa:$('#srelativa').val(),
     tipo:$('#tipo').val(),
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
     primaria:$('#primaria').val(),
     prelativa:$('#prelativa').val(),
     secundaria:$('#secundaria').val(),
     srelativa:$('#srelativa').val(),
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
