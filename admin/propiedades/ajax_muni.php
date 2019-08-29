<?php
include '../conexion/conexion.php';
$estado = htmlentities($_POST['estado']);
 ?>
 <select id="municipio" name="municipio" required>
   <option value="" disabled>SELECCIONA UN NUNICIPIO</option>
   <?php
     $sel_muni = $con->prepare("SELECT * FROM municipios WHERE idestado = ? ");
     $sel_muni -> bind_param('i',$estado);
     $sel_muni -> execute();
     $res_muni = $sel_muni -> get_result();
     while ($f_muni =$res_muni->fetch_assoc()) {?>
       <option value="<?php echo $f_muni['municipio']?>"><?php echo utf8_decode($f_muni['municipio'])?></option>
     <?php }
     $sel_muni->close();
     $con->close();
    ?>
 </select>
 <script>
   $('select').material_select();
 </script>
