<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Proyecto</title>
  </head>
  <body>
    <?php
    $mensaje  = html_entity_decode($_GET['msj']);
    $c = htmlentities($_GET['c']);
    $p = htmlentities($_GET['p']);
    $t = htmlentities($_GET['t']);

    switch ($c) {
      case 'eje':
        $carpeta = '../ejecutivos/';
        break;
      case 'red':
          $carpeta = '../redorganizacional/';
          break;
      case 'typ':
          $carpeta = '../tiposyperfiles/';
          break;
      case 'us':
        $carpeta = '../usuario/';
        break;
      case 'home':
        $carpeta = '../inicio/';
        break;
      case 'salir':
        $carpeta = '../';
        break;
      case 'pe':
        $carpeta = '../perfil/';
        break;
      case 'cli':
        $carpeta = '../clientes/';
        break;
      case 'con':
          $carpeta = '../contactos/';
          break;
      case 'com':
          $carpeta = '../companias/';
          break;
      case 'prop':
        $carpeta = '../propiedades/';
        break;
      case 'gd':
        $carpeta = '../gestionglobal/';
        break;
      }
    switch ($p) {
      case 'in':
        $pagina = 'index.php';
        break;
      case 'home':
        $pagina = 'index.php';
        break;
      case 'salir':
        $pagina = 'index.php';
        break;
      case 'perfil':
        $pagina = 'perfil.php';
        break;
      case 'img':
        $pagina = 'imagenes.php';
        break;
      case 'can':
        $pagina = 'cancelados.php';
        break;
      }
    if (isset($_GET['id'])) {
      $id = htmlentities($_GET['id']);
      $dir=$carpeta.$pagina.'?id='.$id;
    }
    elseif (isset($_GET['a'])) {
      $a = htmlentities($_GET['a']);
      $dir=$carpeta.$pagina.'?a='.$a;
    }
    elseif (isset($_GET['o'])) {
      $o = htmlentities($_GET['o']);
      $dir=$carpeta.$pagina.'?o='.$o;
    }
    else {
      $dir = $carpeta.$pagina;
    }

    if($t =="error")
    {
      $titulo = "Oppss..";
    }else {
      $titulo = "Buen trabajo!";
    }
     ?>
 <?php  ?>
    <script
  			  src="https://code.jquery.com/jquery-3.3.1.min.js"
  			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  			  crossorigin="anonymous"></script>
    <script type = "text/javascript" src="../js/sweetalert2.all.js"></script>
    <script>
    swal({
    title: '<?php echo $titulo ?>',
    text: "<?php echo $mensaje  ?>",
    type: '<?php echo $t ?>',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok'
    }).then((result) => {
      if (result.value) {
        location.href = '<?php echo $dir  ?>';
      }
    });
    $(document).click(function(){
      location.href = '<?php echo $dir  ?>';
    });
    $(document).keyup(function(e){
      if(e.which == 27){
        location.href = '<?php echo $dir  ?>';
      }
    });
    </script>
  </body>
</html>
