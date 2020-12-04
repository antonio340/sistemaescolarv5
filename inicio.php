<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once "header.php";
require "vendor/autoload.php";
require 'config/database.php';

//Alumnos
$alms = DB::table('alumnos')->select(  
  'alumnos.nombre',
  'alumnos.primer_apellido',
  'alumnos.segundo_apellido',
  'alumnos.idalumnos',
)->distinct()
->get();


//Asignaturas
$asigs = DB::table('asignaturas')->select(
  'asignaturas.idasignaturas',
  'asignaturas.nombre_asignatura',  
)->distinct()
->get();

$prueba=$_GET['idusuario'];


$user = DB::table('usuarios')
->leftJoin('perfiles', 'usuarios.perfiles_idperfiles', '=', 'perfiles.idperfiles')
->where('usuarios.idusuarios', $prueba)
->first();



if ($user->nombreperfil == 'maestro'){
    $perfil=true;
}
   
else{
     $perfil=false;
}


if ($perfil == true){
?>
<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
<div class="buttons">
          <a class="button is-dark" href="index.php">
             <strong>Log out</strong>
          </a>
         </div>
    </nav>
<!-- INSERTAR CALIFICACIÓN FORMULARIO -->
<section class="section">
  <div class="box">
        <h4 class="title is-4">- Agregar calificaciones al alumno -</h4>
        <form name="form2" method="POST" action="">

        <div class="field">
          <label class="label">Alumno: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAlumnos' name='alumnos' form='form2'>
                <?php             
                  foreach ($alms as $row) {
                    echo "<option value='$row->idalumnos'> {$row->nombre} 
                    {$row->primer_apellido} {$row->segundo_apellido} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Asignatura: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAsignaturas' name='asignaturas' form='form2'>
                <?php             
                  foreach ($asigs as $row) {
                    echo "<option value='$row->idasignaturas'> 
                    {$row->nombre_asignatura} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>               
          
          <div class="field">
            <label class="label">Calificación</label>
            <div class="control">
              <input class="input" type="text" name="calificacion" placeholder="Capture la calificación">
            </div>
          </div>      

          <div class="field is-grouped">
            <div class="control">
              <button class="button is-danger is-light" onclick="insertar()">Insertar</button>
            </div> 
          </div>    

         </form>
  </div>
</section>


<!-- ELIMINAR CALIFICACIÓN FORMULARIO -->
<section class="section">
  <div class="box">
        <h4 class="title is-4">- Eliminar calificaciones-</h4>
        <form name="form3" method="POST" action="">

        <div class="field">
          <label class="label">Alumno: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAlumnos3' name='alumnos' form='form3'>
                <?php             
                  foreach ($alms as $row) {
                    echo "<option value='$row->idalumnos'> {$row->nombre} 
                    {$row->primer_apellido} {$row->segundo_apellido} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Asignatura: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAsignaturas3' name='asignaturas' form='form3'>
                <?php             
                  foreach ($asigs as $row) {
                    echo "<option value='$row->idasignaturas'> 
                    {$row->nombre_asignatura} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>               
          
       

          <div class="field is-grouped">
            <div class="control">
              <button class="button is-danger is-light" onclick="eliminar()">Eliminar</button>
            </div> 
          </div>    

         </form>
  </div>
</section>

<!-- EDITAR CALIFICACIÓN FORMULARIO -->

<section class="section">
  <div class="box">
        <h4 class="title is-4">- Editar calificaciones del alumno -</h4>
        <form name="form4" method="POST" action="">

        <div class="field">
          <label class="label">Alumno: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAlumnos4' name='alumnos' form='form4'>
                <?php             
                  foreach ($alms as $row) {
                    echo "<option value='$row->idalumnos'> {$row->nombre} 
                    {$row->primer_apellido} {$row->segundo_apellido} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Asignatura: </label>
          <div class="control">          
            <div class="select">
              <select id='selectAsignaturas4' name='asignaturas' form='form4'>
                <?php             
                  foreach ($asigs as $row) {
                    echo "<option value='$row->idasignaturas'> 
                    {$row->nombre_asignatura} </option>";
                  }          
                ?>
              </select>          
            </div>
          </div>
        </div>               
          
          <div class="field">
            <label class="label">Calificación</label>
            <div class="control">
              <input class="input" type="text" name="calificacion" placeholder="Capture la calificación">
            </div>
          </div>      

          <div class="field is-grouped">
            <div class="control">
              <button class="button is-danger is-light" onclick="editar()">actualizar</button>
            </div> 
          </div>    

         </form>

  </div>
</section>


<!--CONSULTAR CALIFICACIÓN FORMULARIO -->
<section class="section">

  <div class="box">
  <h4 class="title is-4">- Consultar calificaciones-</h4>
 
  <table class="table">
  <thead>
    <tr>
      <th><abbr title="Position">#</abbr></th>
      <th>Nombre del alumno</th>
      <th>Asignatura</th>
      <th>Calificacion</th>     
     <th> <button class="button is-danger is-light" onclick="consultar()">actualizar</button></th>        
    </tr>
  </thead>  
  <tbody  id='contenido'> </tbody>
</table>
  </div>
</section>

<?php
}
else{
  echo<<<_ALUMNO
  <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
  <div class="buttons">
          <a class="button is-dark" href="index.php">
             <strong>Log out</strong>
          </a>
         </div>
    </nav>
  <section class="section">

  <div class="box">
  <h4 class="title is-4">- Consultar calificaciones-</h4>
 
  <table class="table">
  <thead>
    <tr>
      <th><abbr title="Position">#</abbr></th>
      <th>Nombre del alumno</th>
      <th>Asignatura</th>
      <th>Calificacion</th>     
     <th> <button class="button is-danger is-light" onclick="consultar()">actualizar</button></th>        
    </tr>
  </thead>  
  <tbody  id='contenido'> </tbody>
</table>
  </div>
</section>
_ALUMNO;
}
?>
<!-- FUNCIONES JAVASCRIPT -->
<script>
idusuario=<?= json_encode($prueba) ?>;
console.log(idusuario);

//CONSULTAR CALIFICACIONES
     function consultar(){       
       axios.post(`api/funcion.php/consultar/${idusuario}`)
       .then(resp => {
         if (resp.data.calificaciones) {
          var filas

          resp.data.calificaciones.forEach( function (row, index) {
            n = index + 1
            filas += `<tr>
            <th> ${n} </th>
            <td> ${row['nombre']} </td>
            <td> ${row['nombre_asignatura']} </td>
            <td> ${row['calificacion']} </td>
            </tr>`
          })         

          document.getElementById('contenido').innerHTML = filas
         } else {
             alert(`sin calificaciones`)
         }
       }).catch(error => {
         console.log(error)
       })

     } 

   //INSERTAR FUNCION
    function insertar(){
      var selectAlum = document.getElementById("selectAlumnos")
      var alumnoSelect = selectAlum.options[selectAlum.selectedIndex].value

      var selectAsig = document.getElementById("selectAsignaturas")
      var asigSelect = selectAsig.options[selectAsig.selectedIndex].value
      

        axios.post(`api/funcion.php/insertar/${alumnoSelect}`, {
          idAlumno: alumnoSelect,
          idAsignatura: asigSelect,
          calificacion: document.forms['form2'].calificacion.value,
       }).then(resp => {
         if (resp.data.aceptado){
             alert('se inserto la calificacion correctamente')
         } else {
             alert('se produjo un error')
         }

       }).catch(error => {
         console.log(error)
       })
    }
    
  
  //ELIMINAR FUNCION
  function eliminar(){
      var selectAlum3 = document.getElementById("selectAlumnos3")
      var alumnoSelect3 = selectAlum3.options[selectAlum3.selectedIndex].value

      var selectAsig3 = document.getElementById("selectAsignaturas3")
      var asigSelect3 = selectAsig3.options[selectAsig3.selectedIndex].value
      

        axios.post(`api/funcion.php/eliminar/${alumnoSelect3}`, {
          idAlumno3: alumnoSelect3,
          idAsignatura3: asigSelect3,
       }).then(resp => {
         if (resp.data.aceptado){
             alert('se elimino la calificacion correctamente')
         } else {
             alert('se produjo un error')
         }

       }).catch(error => {
         console.log(error)
       })
    }




      //EDITAR FUNCION
      function editar(){
      var selectAlum4 = document.getElementById("selectAlumnos4")
      var alumnoSelect4 = selectAlum4.options[selectAlum4.selectedIndex].value

      var selectAsig4 = document.getElementById("selectAsignaturas4")
      var asigSelect4 = selectAsig4.options[selectAsig4.selectedIndex].value
      

        axios.post(`api/funcion.php/editar/${alumnoSelect4}`, {
          idAlumno4: alumnoSelect4,
          idAsignatura4: asigSelect4,
          calificacion4: document.forms['form4'].calificacion.value,
       }).then(resp => {
         if (resp.data.aceptado){
             alert('se edito la calificacion correctamente')
         } else {
             alert('se produjo un error')
         }

       }).catch(error => {
         console.log(error)
       })
    }

    window.onload=consultar
    
    </script>
    </body>
    </html>