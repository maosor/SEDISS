<?php include '../extend/header.php';
include '../extend/funciones.php'; ?>
<script src="../js/jquery-1.11.1.min.js"></script>
 <div class="row">
   <div class="col s12">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Gestión Datos</span>
         <div class="row">
           <a id ='up' class="btn-floating btn-large blue left <?php echo $hidden==true?'':'hidden'?>" style= "margin-left: 5px;"><i
             class="material-icons">save</i></a>
           <a id ='del' href="del_gestion_datos.php?organizacion= <?php echo $organizacion?>&fecha= <?php echo $f['id']?>" disabled class="btn-floating btn-large red left <?php echo $hidden==true?'':'hidden'?>" style= "margin-left: 5px;"><i
             class="material-icons">delete</i></a>
           <br>
             <br>
           </div>
         <div class="row">
           <div class="col s6">
             <?php
             $sel_org = $con->prepare("SELECT DISTINCT o.id, o.descripcion FROM organizacion o INNER JOIN unidadgestion_organizacion uo ON o.id = uo.organizacion ");
             $sel_org -> execute();
             $sel_org-> store_result();
             $sel_org -> bind_result($id, $organizacion);?>
             <label for="organizacion">Organización</label>
                <select id="organizacion"class="form-control">
                    <?php while ($sel_org ->fetch()): ?>
                      <option value="<?php echo $id?>"><?php echo $organizacion?></option>
                    <?php endwhile;
                    $sel_org ->close();?>
                </select>
           </div>
           <div class="col s2">
              <label for="periodo">Periodo</label>
              <input id ="periodo" type="text" class = "datepicker" name="periodo" value="<?php getDate() ?>">
            </div>
            <div class="col s1">
              <a id ='sync' class="btn-floating btn-large green left <?php echo $hidden==true?'':'hidden'?>" style= "margin-left: 5px;"><i
                class="material-icons">sync</i></a>
            </div>
         </div>
          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#insumos">insumos</a></li>
                <li class="tab col s3 "><a href="#produccion">Producción</a></li>
                <li class="tab col s3  "><a href="#horas">Horas</a></li>
              </ul>
            </div>
            <div id="insumos" class="col s12">
              <br><br><br>
              <div class="row">
                <div class="col s4">
                  <b>Unidad de gestión</b>
                </div>
                <div class="col s5">
                  <b>Insumo</b>
                </div>
                <div class="col s3">
                  <b>Rubro</b>
                </div>
              </div>
              <?php
            $sel_unid = $con->prepare("SELECT uo.unidadgestion,tu.Descripcion FROM unidadgestion_organizacion uo INNER JOIN tipo_unidades_gestion tu ON tu.id = uo.unidadgestion WHERE organizacion = 1 order by tu.id");
            $sel_unid -> execute();
            $sel_unid-> store_result();
            $sel_unid -> bind_result($idug, $unidadgestion);
              while ($sel_unid ->fetch()): ?>
              <div class="row">
                <div id="<?php echo $idug?>" class="col s12 dvunidad">
                      <div class="col s4">
                        <span><?php echo $unidadgestion ?></span>
                      </div>
                      <div class="input-field col s8">
                        <?php
                        $sel_insu = $con->prepare("SELECT id, Descripcion FROM red_organizacional WHERE tipo = 4");
                        $sel_insu -> execute();
                        $sel_insu-> store_result();
                        $sel_insu -> bind_result($idin, $insumo);
                          while ($sel_insu ->fetch()): ?>
                            <div class="col s12 dvinsumo">
                              <div class="row ">
                                <div class="col s8">
                                  <span>  <?php echo $insumo ?></span>
                                </div>
                                <div class="col s4 ">
                                    <input class="inprubro" id="<?php echo $idin?>" type="text"  title="rubro" >
                                </div>
                              </div>
                            </div>
                        <?php endwhile;
                      $sel_insu ->close();?>
                    </div>
                  </div>
                </div>
                <?php endwhile;
                $sel_unid ->close();?>
            <div id="produccion" class="col s12">Producción</div>
            <div id="horas" class="col s12">Horas</div>
          </div>
       </div>
     </div>
   </div>
 </div>
<?php include '../extend/scripts.php'; ?>
<script src="../js/gestion_datos.js" charset="utf-8"></script>
<script type="text/javascript">
// $('#up').click(function() {
//   // $.each([ 52, 97 ], function( index, value ) {
//   // alert( index + ": " + value );
//   $('.inprubro').each( function(index,value) {
//       console.log( $(value).attr('id')+$(value).val());
//       //console.log( index + ": " + $('#984 div .input-field input').val());
// });
// })
</script>
