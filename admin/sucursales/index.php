<?php include '../extend/header.php'; ?>

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
$sel = $con->prepare("SELECT id, nombre,Telefono FROM sucursal ");
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($id, $nombre, $telefono );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Sucursales (<?php echo $row?>)</span>
         <table id="tbldatos">
           <thead>
             <tr class="cabecera">
               <th>Nombre</th>
               <th>Telefono</th>
               <th></th>
               <th></th>
               <th><a href="ingreso_sucursal.php" class="btn-floating green right"><i
                class="material-icons">add</i></a></th>

             </tr>
           </thead>
           <?php while ($sel->fetch()) { ?>
            <tr>
              <td><?php echo $nombre ?></td>
              <td><?php echo $telefono ?></td>
              <td> <a href="ingreso_sucursal.php?id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
              </td>
              <td>
                <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar la sucursal?',text: 'Al eliminarlo no podrá recuperarla!',
                  type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                }).then((result) => { if (result.value){location.href='eliminar_sucursal.php?id=<?php echo $id ?>';}})"><i class="material-icons">clear</i></a>
              </td>


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
