<?php @session_start();
if (isset($_SESSION['email'])){
  header('location:inicio');
}
 ?>
<!DOCTYPE html>

<html lang="es">

<head>
  <title>Proyecto</title>
  <meta charset="utf-8" />
  <meta name = "viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../css/materialize.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="shortcut icon" href="/favicon.ico" />
</head>
<body class="grey lighten-2">
  <main>
    <div class="row">
      <div class = "input-field col s12 center">
        <img src="../img/logo_inm.png" width="200" >
      </div>

    </div>
    <div class="container">
      <div class="row">
        <div class="col s12">
          <div class="card z-depth-5">
            <div class="card-content">
              <span class="card-title"><center>Recuperar Contraseña</center></span>
              <form action="nueva_contrasena.php" method="post" autocomplete="off">
                <div class = "input-field">
                  <i class="material-icons prefix">perm_identity</i>
                  <input type="email" name="usuario" id="usuario" required autofocus onblur="may (this.value, this.id)" >
                  <label for="usuario">Usuario</label>
                </div>
                <center>
                  <button type="submit" class="btn waves-effect waves-ligth"name="button">Recuperar</button>
                  <button type="reset" class="btn red darken-4 "  onclick="window.location='../inicio/index.php'" name="button">Cancelar</button>
                </center>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="../js/materialize.min.js"></script>
     <?php include '../extend/scripts.php' ?>
</body>
</html>
