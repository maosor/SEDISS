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
if (isset($_GET['id']))
  {
    $id = $con->real_escape_string(htmlentities($_GET['id']));
    $sel_cli = $con->prepare("SELECT nombre FROM cliente WHERE id_cliente =? ");
    $sel_cli -> bind_param ('i', $id);
    $sel_cli -> execute();
    $sel_cli-> store_result();
    $sel_cli -> bind_result($nombre);
    $sel_cli->fetch();
    $sel_cli ->close();
    $sel = $con->prepare("SELECT id, fecha, comentario FROM comentario WHERE id_cliente =? ");
    $sel -> bind_param ('i', $id);
    $sel -> execute();
    $sel-> store_result();
    $sel -> bind_result($id_com, $fecha, $comentario );
    $row = $sel->num_rows;
  }
  else {
      header('location:../extend/alerta.php?msj=Utiliza el formulario&c=cli&p=in&t=error');
  }
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Comentarios de <?php echo $nombre?> (<?php echo $row?>) </span>
         <table id="tbldatos">
           <thead>
             <tr class="cabecera">
               <th>#</th>
               <th>Fecha</th>
               <th>comentario</th>
               <th></th>
               <th></th>
               <th><a href="../clientes/index.php" class="btn-floating orange right"><i
                class="material-icons">keyboard_return</i></a>&nbsp;<a href="ingreso_comentario.php?cli=<?php echo $id?>" class="btn-floating green right"><i
                class="material-icons">add</i></a></th></th>

             </tr>
           </thead>
           <?php while ($sel->fetch()) { ?>
            <tr>
              <td><?php echo $id_com?></td>
              <td><?php echo $fecha?></td>
              <td><?php echo $comentario?></td>
              <td> <a href="ingreso_comentario.php?id=<?php echo $id_com ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
              </td>
              <td>
                <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar el comentario?',text: 'Al eliminarlo no podrá recuperarlo!',
                  type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                }).then((result) => { if (result.value){location.href='eliminar_comentario.php?id=<?php echo $id_com ?>&cli=<?php echo $id?>';}})"><i class="material-icons">clear</i></a>
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
