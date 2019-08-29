<?php include '../extend/header.php';
$id = htmlentities($_GET['id']);
$sel = $con->prepare("SELECT foto_principal FROM inventario WHERE propiedad = ?");
$sel -> bind_param('s', $id);
$sel -> execute();
$res = $sel -> get_result();
if ($f = $res->fetch_assoc()) {
  $foto= $f['foto_principal'];
}
$sel->close();
?>
  <div class="row">
    <div class="col s6">
        <h2 class="header">Actualizar foto principal</h2>
        <div class="card horizontal">
          <div class="card-image">
            <img src="<?php echo $foto ?>" width="200" height="200">
          </div>
          <div class="card-stacked">
            <div class="card-content">
              <form action="up_principal.php" class="form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="hidden" name="anterior" value="<?php echo $foto ?>">
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Foto:</span>
                    <input type="file" name="foto">
                   </div>
                  <div class="file-path-wrapper">
                    <input type="text" class="file-path validate">
                  </div>
                </div>
                <button type="submit" class="btn">Actualizar</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    <div class="col s6">
      <h2 class="header">Cargar imagenes</h2>
      <div class="row">
        <div class="col s12">
          <div class="card">
            <div class="card-content">
              <form action="ins_imagenes.php" class="form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Foto:</span>
                    <input type="file" name="ruta[]" multiple>
                   </div>
                  <div class="file-path-wrapper">
                    <input type="text" class="file-path validate">
                  </div>
                </div>
                <button type="submit" class="btn">Guardar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="row">
    <div class="col s12 center cargador">
      <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="col s12">
      <div class="card">
        <div class="card-content">
          <?php
          $sel_img = $con->prepare("SELECT * FROM imagenes WHERE id_propiedad = ?");
          $sel_img -> bind_param('i', $id);
          $sel_img -> execute();
          $res_img = $sel_img -> get_result();
          while ($f_img = $res_img->fetch_assoc()) { ?>

            <a href="#" onclick="swal({title: '¿Esta seguro que desea eliminar la imagen?',text: 'Al eliminarla no podrá recuperarla!',
              type: 'warning',showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Si, Eliminarla!'
            }).then((result) => { location.href='eliminar_img.php?id=<?php echo $f_img['id']?>&ruta=<?php echo $f_img['ruta']?>&id_propiedad=<?php echo $id?>';})">
            <img src= "<?php echo $f_img['ruta']?>"alt=""></a>
          <?php }
          $sel_img-> close();
           ?>
        </div>
      </div>
    </div>
  </div>
 <?php include '../extend/scripts.php' ?>
 <script>
 $('.cargador').hide();
 $('.form').submit(function(event){
   $('.cargador').show();
 });

 </script>
</body>
</html>
