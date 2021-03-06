<?php include '../extend/header.php';
include '../extend/funciones.php'; ?>
<link href="../css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/treeview.css">
<?php
$compania = $_SESSION['compania'];
if (!isset($_GET['o']))
{
  $tipo=1;
  $oculta = 'hidden';
}
else {
  $tipo=htmlentities($_GET['o']);
  $oculta = '';
}
$sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional WHERE tipo = ? and id_compania = ? ORDER BY codigo");
$sel -> bind_param("ii", $tipo,$compania);
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($codigo, $descripcion, $nivel );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s6 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title"> <?php echo descripcion($tipo)?></span>
           <div class="s12 m6">
              <input type="hidden" id="tipo" value="<?php echo $oculta == ''?$tipo:null?>">
             <div class="row <?php echo $oculta?>">
               <a id ='nuevo' class="btn-floating btn-large light-blue darken-4 left"><i
                 class="material-icons">insert_drive_file</i></a>
            </div>
             <div class="row">
               <div class="">
                 <ul id="tree1">
                   <li>DIVISION</li>
                   <?php $inicio =0;
                    if ($tipo==5 || $tipo==6 ){
                     $inicio=unidadmenor($id);
                   }
                   //echo $inicio;
                   ?>
                   <?php mostrararbol($inicio,$tipo,$compania);?>
                 </ul>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="col s6 ">
       <div class="card">
         <div class="card-content">
           <span class="card-title">Editar o Insertar Datos</span>
             <div class="s12 m6 dvdetalle">
             </div>
           </div>
         </div>
       </div>
   </div>
<?php include '../extend/scripts.php'; ?>
<script src="../js/treeview.js" charset="utf-8"></script>
<script type="text/javascript">
$('.node').click(function(event){
  event.stopPropagation();
  $('.selecionado').removeClass('selecionado');
  $(this).addClass("selecionado");
  if($('#tipo').val() == '')
  {
    llama_organizacion($(this).attr('id'))
  }
  else {
    llama_nodo($(this).attr('id'),$('#tipo').val())
  }

});
$('#nuevo').click(function () {
  //$('.dvdetalle').load('ajax_nodo.php',{codigo:0,tipo:1});
  llama_nodo('0', $('#tipo').val());
});
function llama_nodo(cod, tip) {
  $.post('ajax_nodo.php',{
    id:cod,
    tipo:tip,
    beforeSend: function () {
      $('.dvdetalle').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('.dvdetalle').html(respuesta)
  });
}
function llama_organizacion(cod) {
  $.post('ajax_nodo_organizacion.php',{
    id:cod,
    beforeSend: function () {
      $('.dvdetalle').html('Espere un momento por favor')
     }
   }, function (respuesta) {
        $('.dvdetalle').html(respuesta)
  });
}
</script>
</body>
</html>
