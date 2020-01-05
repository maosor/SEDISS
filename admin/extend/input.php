<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    $a =htmlentities($_POST['a']);
    $v = htmlentities($_POST['v']);
     ?>
  </body>
</html>
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
<script type = "text/javascript" src="../js/sweetalert2.all.js"></script>

<script type="text/javascript">
  const {value: accept } = swal({
    title:'<?php echo $a?>',
    input: 'text',
    inputValue: '<?php echo $v?>',
    showCancelButton: true,
    inputValidator: (value) => {
      return !value && 'Es necesario ingresar un texto'
    }
  });
  if (accept) {
    swal('You agreed with T&C :)')
  }


</script>
