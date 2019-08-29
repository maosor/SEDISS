<?php @session_start();
include '../conexion/conexion.php';
if (!isset($_SESSION['email'])){
  header('location:../');
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
 <link href="../css/styles.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="shortcut icon" href="/favicon.ico" />
 <style media="screen">
 header, main, footer {
   padding-left: 300px;
 }
 .button-collapse
 {
    display: none;
 }
 body{
   text-transform: uppercase;
 }
 @media only screen and (max-width:992px) {
   header, main, footer{
     padding-left: 0;
   }
   .button-collapse
   {
      display: inherit;
   }
 }
 </style>
 </head>
 <body class="grey lighten-3">
<main>
<?php
    include '../extend/menu_admin.php';
 ?>
