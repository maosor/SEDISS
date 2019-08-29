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
$estado = 'Activo';
$sel = $con->prepare("SELECT id_cliente, fecha_ingreso,c.nombre,telefono1, telefono2, c.email, e.nombre FROM cliente c
  INNER JOIN ejecutivo e ON c.id_ejecutivo_asignado = e.id  WHERE estatus = ?");
$sel -> bind_param ('s', $estado);
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($id, $fecha, $nombre, $telefono1, $telefono2, $email, $ejecutivo );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Clientes (<?php echo $row?>)</span>
         <table id="tbldatos">
           <thead>
             <tr class="cabecera">
               <th>#</th>
               <th>Fecha</th>
               <th>Nombre</th>
               <th>Telefono1</th>
               <th>Telefono2</th>
               <th>Email</th>
               <th>Ejecutivo</th>
               <th></th>
               <th></th>
               <th><a href="ingreso_cliente.php" class="btn-floating green right"><i
                class="material-icons">add</i></a></th>

             </tr>
           </thead>
           <?php while ($sel->fetch()) { ?>
            <tr>
              <td><?php echo $id?></td>
              <td><?php echo $fecha?></td>
              <td><?php echo $nombre?></td>
              <td><?php echo $telefono1?></td>
              <td><?php echo $telefono2?></td>
              <td><?php echo $email ?></td>
              <td><?php echo $ejecutivo ?></td>
              <td> <a href="../comentarios/index.php?id=<?php echo $id ?>" class="btn-floating pink darken-4"> <i class="material-icons">insert_comment</i></a>
              <td> <a href="ingreso_cliente.php?id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
              </td>
              <td>
                <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar el cliente?',text: 'Al eliminarlo no podrá recuperarlo!',
                  type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                }).then((result) => { if (result.value){location.href='eliminar_cliente.php?id=<?php echo $id ?>';}})"><i class="material-icons">clear</i></a>
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
