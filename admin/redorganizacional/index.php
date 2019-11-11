<?php include '../extend/header.php';
include '../extend/funciones.php'; ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="../css/treeview.css">
<?php
$tipo=htmlentities($_GET['o']);
$sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional WHERE tipo = ? ORDER BY codigo");
$sel -> bind_param("i", $tipo);
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
             <div class="row">
               <div class="">
                 <ul id="tree1">
                   <li>DIVISION</li>
                   <input type="hidden" id="tipo" value="<?php echo $tipo?>">
                   <?php mostrararbol('000000000000000000000000000000000000000000000000000000000000',$tipo); ?>
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
$('.node').not(':has(ul)').click(function(){
  $('.selecionado').removeClass('selecionado');
  $(this).addClass("selecionado");
  $.post('ajax_nodo.php',{
    codigo:$(this).attr('id'),
    tipo:$('#tipo').val(),
    beforeSend: function () {
      $('.dvdetalle').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('.dvdetalle').html(respuesta);
  });
});
$('.branch').hover(function(){
  $('.encima').removeClass('encima');
  $(this).addClass("encima");
  $('#edit').remove();
  $(this).prepend('<a id ="edit" class="btn-floating blue right" style= "margin-left: 5px;"><i class="material-icons">edit</i></a>');
  $('#edit').click(function () {
    $('.encima span').replaceWith('<input type="text" value = "'+ $('.encima span').text()+'" focus style="width: 85%;">');
    $('.encima a i').text("save");
  })
  console.log('over branch'+$(this).text());
});

</script>
</body>
</html>
