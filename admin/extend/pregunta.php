<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Proyecto</title>
  </head>
  <body>
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
<script type = "text/javascript" src="../js/sweetalert2.all.js"></script>
<script>
swal({
title: '¿Esta seguro que quire salir?',
text: "Podría perder información que no haya guardado",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Si, quiero salir!'
}).then((result) => {
  if (result.value) {
    location.href = '../login/salir.php';
  }else {
    location.href = document.referrer
  }
});
</script>
</body>
</html>
