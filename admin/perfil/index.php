  <?php include '../extend/header.php' ?>
     <div class="row">
       <div class="col s12">
         <div class="card horizontal">
            <div class="card-image">
              <img src="../perfil/<?php echo $_SESSION['foto'] ?>" width="200" height="200">
            </div>
            <div class="card-stacked">
              <div class="card-content">
                <form action="up_foto.php" method="post" enctype="multipart/form-data">
                  <div class="file-field input-field">
                    <div class="btn">
                      <span>Foto:</span>
                      <input type="file" name="foto">
                     </div>
                    <div class="file-path-wrapper">
                      <input type="text" class="file-path validate">
                    </div>
                  <button type="submit" class="btn">Actualizar</button>
                  <input  type="reset" class="btn red darken-4" onclick="window.location='../inicio/index.php'" value ="Cancelar"</input>
                </form>
              </div>

            </div>
          </div>
        </div>
     </div>
   <?php include '../extend/scripts.php' ?>
  </body>
</html>
