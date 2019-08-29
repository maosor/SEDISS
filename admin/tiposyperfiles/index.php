<?php include '../extend/header.php';
$a= htmlentities($_GET['a']);
?>

<div class="row">
  <div class="col s12">
    <nav class="blue lighten-4" >
      <div class="nav-wrapper">
        <div class="input-field">
          <input type="search"   id="buscar" autocomplete="off"  >
          <label for="buscar"><i class="material-icons" >search</i></label>
          <i class="material-icons" >close</i>
        </div>
      </div>
    </nav>
  </div>
</div>
<?php
if ($a=='t') {
$sel = $con->prepare("SELECT id, descripcion FROM tipo_ejecutivo ");
}else {
  $sel = $con->prepare("SELECT id, descripcion FROM perfil_ejecutivo ");
}
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($id, $descripcion);
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <?php if ($a=='t'): ?>
            <span class="card-title">Tipos Ejecutivo (<?php echo $row?>)</span>
            <?php else: ?>
            <span class="card-title">Perfiles Ejecutivo (<?php echo $row?>)</span>
         <?php endif; ?>
         <table id="tbldatos">
           <thead>
             <tr class="cabecera">
               <th>Descripción</th>
               <th></th>
               <th></th>
               <?php if ($a=='t'): ?>
                  <th><a href="ingreso_tipoyperfil.php?a=t" class="btn-floating green right"><i
                  class="material-icons">add</i></a></th>
                <?php else: ?>
                  <th><a href="ingreso_tipoyperfil.php?a=p" class="btn-floating green right"><i
                   class="material-icons">add</i></a></th>
                <?php endif; ?>
             </tr>
           </thead>
           <?php while ($sel->fetch()) { ?>
            <tr>
              <td><?php echo $descripcion ?></td>
              <?php if ($a=='t'): ?>
                <td> <a href="ingreso_tipoyperfil.php?a=t&id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
                </td>
                <td>
                  <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar el tipo de ejecutivo?',text: 'Al eliminarlo no podrá recuperarlo!',
                    type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                  }).then((result) => { if (result.value){location.href='eliminar_tipoyperfil.php?a=t&id=<?php echo $id ?>';}})"><i class="material-icons">clear</i></a>
                </td>
              <?php else: ?>
                <td> <a href="ingreso_tipoyperfil.php?a=p&id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
                </td>
                <td>
                  <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar perfil del ejecutivo?',text: 'Al eliminarlo no podrá recuperarlo!',
                    type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                  }).then((result) => { if (result.value){location.href='eliminar_tipoyperfil.php?a=p&id=<?php echo $id ?>';}})"><i class="material-icons">clear</i></a>
                </td>
                <?php endif; ?>
              </tr>
          <?php }
          $sel->close();
          $con->close();
           ?>
         </table>
       </div>
     </div>
   </div>
 </div>
<?php include '../extend/scripts.php'; ?>

</body>
</html>
