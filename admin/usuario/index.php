<?php
 include '../extend/header.php';
 include '../extend/permiso.php';
 ?>
   <div class="row">
     <div class="col s12">
       <div class="card">
         <div class="card-content">
           <span class="card-title">Insertar usuarios</span>
           <form class="form" action="ins_usuarios.php" method="post" enctype="multipart/form-data">
             <div class="input-field">
               <input type="text" name="nick" required autofocus title="DEBE TENER ENTRE 8 Y 12 CARACTERES, SOLO LETRAS" pattern="[A-Za-z]{8,15}"
               id="nick" onblur="may (this.value, this.id)">
               <label for="nick">Nick:</label>
             </div>
             <div class="validacion"> </div>
             <div class = "input-field">
               <input type="password" name="pass1" title="CONTRASEÑA CON NUMEROS, LETRAS MAYUSCULAS, MINUSCULAS" pattern="[A-Za-z0-9]{8,15}"
               id="pass1" required>
               <label for="pass1">Contraseña:</label>
             </div>
             <div class = "input-field">
               <input type="password"  title="CONTRASEÑA CON NUMEROS, LETRAS MAYUSCULAS, MINUSCULAS" pattern="[A-Za-z0-9]{8,15}"
               id="pass2" required>
               <label for="pass">Verificar Contraseña:</label>
             </div>
             <select  name="nivel" required>
               <option value="" disabled selected>ELLIJE UN NIVEL DE USUARIO</option>
               <option value="ADMINISTRADOR">ADMINISTRADOR</option>
               <option value="ASESOR">ASESOR</option>
             </select>
             <div class = "input-field">
               <input type="text" name="nombre" title="Nombre del usuario" id= "nombre" onblur="may (this.value, this.id)"
               pattern="[A-Z/s ]+">
               <label for="nombre">Nombre completo del usuario:</label>
             </div>
             <div class = "input-field">
               <input type="email" name="correo" title="Correo eletrónico" id="correo">
               <label for="correo">Correo electrónico</label>
             </div>
             <div class="file-field input-field">
               <div class="btn">
                 <span>Foto:</span>
                 <input type="file" name="foto">
                </div>
               <div class="file-path-wrapper">
                 <input type="text" class="file-path validate">
               </div>
             </div>
             <div class="card-action">
                <button type="submit" class="btn black" id = "btn_guardar"name="button">Guardar <i class="material-icons">send</i></button>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
   <div class="row">
     <div class="col s12">
       <nav class="brown lighten-3">
         <div class="nav-wrapper">
           <div class = "input-field">
             <input type="search" id="buscar" autocomplete="off">
             <label for="buscar"><i class="material-icons">search</i></label>
             <i class="material-icons">close</i>
           </div>

         </div>
       </nav>

     </div>

   </div>
   <?php
      $sel = $con->query("SELECT  * FROM usuario ");
      $row = mysqli_num_rows($sel);
    ?>
   <div class="row">
     <div class="col s12 ">
       <div class="card">
         <div class="card-content">
           <span class="card-title">Usuarios (<?php echo $row  ?>)</span>
           <table>
             <thead>
               <tr class="cabecera">
                 <th class="truncate">Nick</th>
                 <th class="hide-on-med-and-down">Nombre</th>
                 <th class="hide-on-med-and-down">Correo</th>
                 <th>Nivel</th>
                 <th></th>
                 <th class="hide-on-small-only">Foto</th>
                 <th class="hide-on-small-only">Bloqueo</th>
                 <th class="hide-on-small-only">Eliminar</th>
               </tr>
             </thead>
             <?php while ($f = $sel -> fetch_assoc()){ ?>
               <tr>
                 <td class="truncate"><?php echo $f['nick'] ?></td>
                 <td class="hide-on-med-and-down"><?php echo $f['nombre'] ?></td>
                 <td class="hide-on-med-and-down"><?php echo $f['correo'] ?></td>
                 <td>
                 <form action="up_nivel.php" method="post">
                   <input type="hidden" name="id" value="<?php echo $f['id'] ?>">
                   <select  name="nivel" required>
                     <option value="<?php echo $f['nivel'] ?>" ><?php echo $f['nivel'] ?></option>
                     <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                     <option value="ASESOR">ASESOR</option>
                   </select>
                 </td>
                 <td>
                   <button type="submit" class="btn-floating"><i class="material-icons">repeat</i></button>
                 </form>
                 </td>
                 <td class="hide-on-small-only"><img src="<?php echo $f['foto'] ?>" width="50" class="circle"> </td>
                 <td>
                    <?php if ($f['bloqueo']==1): ?>
                      <a href="bloqueo_manual.php?us=<?php echo $f['id']?>&bl=<?php echo $f['bloqueo'] ?>"><i
                         class="material-icons green-text">lock_open</i></a>
                    <?php else: ?>
                      <a href="bloqueo_manual.php?us=<?php echo $f['id']?>&bl=<?php echo $f['bloqueo'] ?>"><i
                         class="material-icons red-text">lock_outline</i></a>
                    <?php endif; ?>
                  </td>
                 <td>
                   <a href="#" class="btn-floating red" onclick="swal({title: '¿Esta seguro que desea eliminar el cliente?',text: 'Al eliminarlo no podrá recuperarlo!',
                     type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarlo!'
                   }).then((result) => { location.href='eliminar_usuario.php?id=<?php echo $f['id']?>';})"><i class="material-icons">clear</i></a>
                 </td>
                 <td></td>
               </tr>
             <?php } ?>
           </table>
         </div>
       </div>
     </div>
   </div>
 <?php include '../extend/scripts.php' ?>
 <script src="../js/validacion.js"> </script>
</body>
</html>
