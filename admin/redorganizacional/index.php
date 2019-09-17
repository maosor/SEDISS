<?php include '../extend/header.php';
include '../extend/funciones.php'; ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="../css/treeview.css">
<?php
$sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional ORDER BY codigo");
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($codigo, $descripcion, $nivel );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s6 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Red Organizacional</span>
           <div class="s12 m6">
             <div class="row">
               <div class="">
                 <ul id="tree1">
                   <li>DIVISION</li>
                   <?php mostrararbol('000000000000000000000000000000000000000000000000000000000000'); ?>
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
  $.post('ajax_nodo.php',{
    codigo:$(this).attr('id'),
    beforeSend: function () {
      $('.dvdetalle').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('.dvdetalle').html(respuesta);
  });
});
$('.branch').dblclick(function(){
  $.post('ajax_nodo.php',{
    codigo:$(this).attr('id'),
    beforeSend: function () {
      $('.dvdetalle').html('Espere un momento por favor');
     }
   }, function (respuesta) {
        $('.dvdetalle').html(respuesta);
  });
});
</script>
</body>
</html>
