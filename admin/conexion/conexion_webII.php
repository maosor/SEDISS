<?php
  //$con = @new PDO('localhost', 'root', '', 'inmobiliaria');
  $con = @new PDO("mysql:host=localhost;dbname=inmobiliaria;charset=utf8", "root", "");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
 ?>
