<?php include '../extend/header.php';
include '../extend/funciones.php'; ?>
<style media="screen">
/* Remove default bullets */
ul, #myUL {
 list-style-type: none;
}

/* Remove margins and padding from the parent ul */
#myUL {
 margin: 0;
 padding: 0;
}

/* Style the caret/arrow */
.caret {
 cursor: pointer;
 user-select: none; /* Prevent text selection */
}

/* Create the caret/arrow with a unicode, and style it */
.caret::before {
 content: "\25B6";
 color: black;
 display: inline-block;
 margin-right: 6px;
}

/* Rotate the caret/arrow icon when clicked on (using JavaScript) */
.caret-down::before {
 transform: rotate(90deg);
}

/* Hide the nested list */
.nested {
display: none;
}

/* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
.active {
 display: block;
}
</style>
<div class="row">
  <div class="col s12">
    <nav class="blue lighten-4" >
      <div class="nav-wrapper">
        <div class="input-field">
          <input type="search"   id="buscar" autocomplete="off"  >
          <label for="buscar"><i class="material-icons" >search</i></label>
          <i class="material-icons" >close</i>
        </div>
      </div>
    </nav>
  </div>
</div>
<?php
$sel = $con->prepare("SELECT codigo, descripcion, nivel FROM red_organizacional ORDER BY codigo");
$sel -> execute();
$sel-> store_result();
$sel -> bind_result($codigo, $descripcion, $nivel );
$row = $sel->num_rows;
 ?>
 <div class="row">
   <div class="col s12 ">
     <div class="card">
       <div class="card-content">
         <span class="card-title">Red Organizacional (<?php echo $row ?>)</span>
         <a href="ingreso_ejecutivo.php" class="btn-floating green right"><i
          class="material-icons">add</i></a></th>
         <ul id="myUL">
           <li><span class="caret">división</span>
             <?php mostrararbol('000000000000000000000000000000000000000000000000000000000000') ?>
          </li>
        </ul>
       </div>
     </div>
   </div>
 </div>
<?php include '../extend/scripts.php'; ?>
<script type="text/javascript">
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>
</body>
</html>
