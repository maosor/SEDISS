<?php include 'admin/conexion/conexion_web.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="admin/css/materialize.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" />

    <title>Sitio Web</title>
  </head>
  <body class="blue-grey lighten-5">
    <nav class="red">
      <a href="index.php" class="brand-logo center">LOGO</a>
    </nav>
    <div class="slider">
      <ul class="slides">
        <?php
          $sel = $con->prepare("SELECT ruta FROM slider");
          $sel -> execute();
          $sel -> bind_result($ruta);
          while ($sel ->fetch()) {?>
        <li>
          <img src="admin/inicio/<?php echo $ruta ?> "> <!-- random image -->
          <div class="transparent caption center-align">
            <h3>Empresa</h3>
            <h5 class="light grey-text text-lighten-3">Slogan de la empresa</h5>
          </div>
        </li>
        <?php }
        $sel->close(); ?>
      </ul>
    </div>
    <div class="row">
      <?php
      $sel_marc = $con->prepare("SELECT foto_principal, precio, estado, municipio, fraccionamiento, propiedad FROM
        inventario WHERE marcado = 'SI'");
      $sel_marc -> execute();
      $sel_marc -> bind_result($foto_principal, $precio, $estado, $municipio, $fraccionamiento, $propiedad);
      while ($sel_marc->fetch()) {?>
      <div class="col s12 m6 l3">
        <div class="card">
          <div class="card-image">
            <img src="admin/propiedades/<?php echo $foto_principal?>">
            <span class="card-title"><?php echo '¢'.number_format($precio, 2);?></span>
          </div>
          <div class="card-content">
            <p><?php echo $fraccionamiento.' '.$estado.' '.$municipio?></p>
          </div>
          <div class="card-action">
            <a href="ver_mas.php?id=<?php echo $propiedad?> ">Ver mas..</a>
          </div>
        </div>
      </div>
<?php }
$sel_marc -> close();
 ?>
    </div>
    <div class="row">
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Buscador de inmuebles</span>
            <form action="buscar.php" method="post">
              <div class="row">
                <div class="col s6">
                  <select id="estado" name="estado" required>
                    <option value="" disabled>SELECCIONA UN ESTADO</option>
                    <?php
                      $sel_estado = $con->prepare("SELECT idestados, estado FROM estados ");
                      $sel_estado -> execute();
                      $sel_estado -> bind_result($idestados, $estado);
                      while ($sel_estado ->fetch()) {?>
                        <option value="<?php echo $idestados?>"><?php echo $estado?></option>
                      <?php }
                      $sel_estado->close();
                     ?>
                  </select>
                </div>
                <div class="col s6">
                  <div class="res_estado"></div>
                </div>
              </div>
              <div class="row">
                <div class="col s6">
                  <select name="operacion" required  >
                    <option value="" disabled selected  >ELIGE LA OPERACION</option>
                    <option value="VENTA">VENTA</option>
                    <option value="RENTA">RENTA</option>
                    <option value="TRASPASO">TRASPASO</option>
                    <option value="OCUPADO">OCUPADO</option>
                  </select>
                </div>
                <div class="col s6">
                  <select name="tipo_inmueble" required >
                    <option value="" disabled selected  >ELIGE EL TIPO DE INMUEBLE</option>
                    <option value="CASA">CASA</option>
                    <option value="TERRENO">TERRENO</option>
                    <option value="LOCAL">LOCAL</option>
                    <option value="DEPARTAMENTO">DEPARTAMENTO</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s6">
                  <div class = "input-field">
                    <input type="number" name="rango1" title="" id="rango1" required>
                    <label for="rango1">Precio minimo</label>
                  </div>
                </div>
                <div class="col s6">
                  <div class = "input-field">
                    <input type="number" name="rango2" title="" id="rango2" required>
                    <label for="rango2">Precio maximo</label>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn">Buscar inmueble</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">Contacto</span>
            <div class="row">
              <div class="col s6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d15717.19657734039!2d-84.2542193!3d9.99212985!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scr!4v1519962002279"
                width="600" height="450" frameborder="0" style="border:0" allowfullscreen class="z-depth-4"></iframe>
              </div>
              <div class="col s6">
                <div class="input-field">
                  <input type="text" name="nombre" pattern="[A-Za-z/s ]+"  title=""  id="nombre" required >
                  <label for="nombre">Nombre:</label>
                </div>
                <div class="input-field">
                  <input type="text" name="asunto"   title=""  id="asunto"  >
                  <label for="asunto">Asunto:</label>
                </div>
                <div class="input-field">
                  <input type="email" name="correo"   title=""  id="correo" required  >
                  <label for="correo">Correo:</label>
                </div>
                <div class="input-field">
                  <textarea name="mensaje" rows="8" cols="80" id="mensaje" onblur="may(this.value, this.id)" class="materialize-textarea"></textarea>
                  <label for="">Mensaje:</label>
                </div>
                <button type="button" class="btn" id = "enviar">Enviar</button>
                <div class="resultado"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="blue-grey page-footer">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">

            <h5 class="white-text"><i class="material-icons">call</i>Teléfonos: </h5>
            <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
          </div>
          <div class="col l4 offset-l2 s12">
            <h5 class="white-text">Links</h5>
            <ul>
              <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
        © 2014 Copyright Text
        <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
      </div>
    </footer>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="admin/js/materialize.min.js"></script>
    <script>
      $('.slider').slider();
      $('select').material_select();
      $('#estado').change(function() {
        $.post('admin/propiedades/ajax_muni.php',{
          estado:$('#estado').val(),
          beforeSend: function () {
            $('.res_estado').html('Espere un momento por favor');
           }
         }, function (respuesta) {
              $('.res_estado').html(respuesta);
        });
      });
      $('#enviar').click(function() {
        $.post('email.php',{
          nombre:$('#nombre').val(),
          asunto:$('#asunto').val(),
          correo:$('#correo').val(),
          mensaje:$('#mensaje').val(),
          id_propiedad:$('#id_propiedad').val(),

          beforeSend: function () {
            $('.resultado').html('Espere un momento por favor');
           }
         }, function (respuesta) {
              $('.resultado').html(respuesta);
        });
      });
    </script>
  </body>
</html>
