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
$sel = $con->prepare("SELECT id_contacto, nombre, telefono_casa,telefono_oficina,telefono_celular,
                      fax,email,es_corredor,email2  FROM contacto ");
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($id, $nombre, $telefono_casa,$telefono_oficina,$telefono_celular,
                      $fax,$email,$es_corredor,$email2 );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Contactos (<?php echo $row?>)</span>
         <table id="tbldatos">
           <thead>
             <tr class="cabecera">
               <th>#</th>
               <th>Nombre</th>
               <th>Telefono<br>Casa</th>
               <th>Telefono<br>Oficina</th>
               <th>Telefono<br>Celular</th>
               <th>Fax</th>
               <th>Email</th>
               <th>Email2</th>
               <th>¿Corredor?</th>
               <th></th>
               <th></th>
               <th><a href="ingreso_contacto.php" class="btn-floating green right"><i
                class="material-icons">add</i></a></th>

             </tr>
           </thead>
           <?php while ($sel->fetch()) { ?>
            <tr>
              <td><?php echo $id?></td>
              <td><?php echo $nombre?></td>
              <td><?php echo $telefono_casa?></td>
              <td><?php echo $telefono_oficina?></td>
              <td><?php echo $telefono_celular?></td>
              <td><?php echo $fax ?></td>
              <td><?php echo $email ?></td>
              <td><?php echo $email2 ?></td>
              <td><?php echo $es_corredor==1?"Sí":"No" ?></td>
              <td> <a href="ingreso_contacto.php?id=<?php echo $id ?>" class="btn-floating blue"> <i class="material-icons">edit</i></a>
              </td>
              <td>
                <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar el contacto?',text: 'Al eliminarlo no podrá recuperarlo!',
                  type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                }).then((result) => { if (result.value){location.href='eliminar_contacto.php?id=<?php echo $id ?>';}})"><i class="material-icons">clear</i></a>
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
