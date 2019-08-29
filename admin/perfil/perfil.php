  <?php include '../extend/header.php' ?>
     <div class="row">
       <div class="col s12">
         <div class="card">
            <div class="card-content">
                <span class="card-title">Editar perfil</span>
            </div>
            <div class="card-tabs">
              <ul class="tabs tabs-fixed-width">
                <li class="tab"><a class="active" href="#datos">Datos</a></li>
                <li class="tab"><a href="#pass">Contraseña</a></li>
              </ul>
            </div>
            <div class="card-content grey lighten-4">
              <div id="datos">
                <form class="form" action="up_perfil.php" method="post" enctype="multipart/form-data">
                  <div class = "input-field  col m4">
                    <input type="text" name="nombre" title="Nombre del ejecutivo" value="<?php echo $_SESSION['nombre']?>" id= "nombre" onblur="may (this.value, this.id)"
                    pattern="[A-Z/s ]+">
                    <label for="nombre">Nombre del ejecutivo:</label>
                  </div>
                  <div class = "input-field col m4">
                    <input type="text" name="apellido1" title="Primer apellido del ejecutivo" value="<?php echo $_SESSION['apellido1']?>" id= "apellido1" onblur="may (this.value, this.id)"
                    pattern="[A-Z/s ]+">
                    <label for="apellido1">Primer apellido del ejecutivo:</label>
                  </div>
                  <div class = "input-field col m4">
                    <input type="text" name="apellido2" title="Segundo apellido del ejecutivo" value="<?php echo $_SESSION['apellido2']?>" id= "apellido2" onblur="may (this.value, this.id)"
                    pattern="[A-Z/s ]+">
                    <label for="apellido2">Nombre completo del usuario:</label>
                  </div>
                  <div class = "input-field col m12">
                    <input type="email" name="email" title="Correo eletrónico" value="<?php echo $_SESSION['email']?>" id="email">
                    <label for="email">Correo electrónico</label>
                  </div>
                  <center>
                    <button type="submit" class="btn" name="button"><i class="material-icons">check</i> Editar </button>
                    <button type="reset" class="btn red darken-4"  onclick="window.location='../inicio/index.php'" name="button"><i class="material-icons">close</i> Cancelar </button>
                  </center>
                </form>
              </div>
              <div id="pass">
                <form class="form" action="up_pass.php" method="post" enctype="multipart/form-data">
                  <div class = "input-field">
                    <input type="password" name="pass1" title="Contraseña del ejecutivo"
                    id="pass1" required>
                    <label for="pass1">Contraseña:</label>
                  </div>
                  <div class = "input-field">
                    <input type="password" title="Contraseña del ejecutivo"
                    id="pass2" required>
                    <label for="pass">Verificar Contraseña:</label>
                    <center>
                     <button type="submit" class="btn" id="btn_guardar" name="button"><i class="material-icons">check</i> Editar </button>
                     <button type="reset" class="btn red darken-4 "  onclick="window.location='../inicio/index.php'" name="button"><i class="material-icons">close</i> Cancelar</button>
                   </center>
                </form>
              </div>
            </div>
          </div>
       </div>
     </div>
   <?php include '../extend/scripts.php' ?>
  <script src="../js/validacion.js"> </script>
  </body>
</html>
