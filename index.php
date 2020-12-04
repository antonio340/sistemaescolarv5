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

?>



 
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    </nav>
   
    <br>

<!-- LOGIN FORMULARIO -->
<section class="section">
  <div class="box">
    <div class="field">
      <h4 class="title is-4">- Ingresar -</h4>
        <div class="control"> 
          <form name="form1" method="POST" action="api/funcion.php/login">
              <label class="label">Nombre: </label>
                 <input class="input" type="text" name="usuario" placeholder="ingresa tu nombre">
              <label class="label">Contraseña: </label>
                 <input class="input" type="password" name="password" placeholder="escribe tu contraseña">
              <input class="button is-danger is-light" value="login" type="button" onclick="login()">
          </form>
        </div>
    </div>
  </div>
</section>

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

<button class="button is-danger is-light" onclick="consultar()">consultar</button>

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
    </tr>
  </thead>  
  <tbody  id='contenido'> </tbody>
</table>
  </div>
</section>


<!-- FUNCIONES JAVASCRIPT -->
<script>
idusuario= 2
//CONSULTAR CALIFICACIONES
     function consultar(){       
       axios.post(`api/funcion.php/consultar/${idusuario}`)
       .then(resp => {
         resp.data.nombreperfil
         if (resp.data.calificaciones) {
          var filas

          resp.data.calificaciones.forEach( function (row, index) {
            n = index + 1
            filas += `<tr>
            <th> ${n} </th>
            <td> ${row['nombre']} </td>
            <td> Asignatura </td>
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

//LOGIN FUNCION
    function login(){

        axios.post(`api/funcion.php/login/${document.forms[0].usuario.value}`, {
        usuario: document.forms[0].usuario.value,
        password: document.forms[0].password.value,
       }).then(resp => {
         if (resp.data.aceptado){
             alert(`bienvenido: ${resp.data.nombreperfil}`)
             setTimeout(`location.href='inicio.php?idusuario=${
                 resp.data.idusuario}'`,500)
         } else {
             alert(`el usuario y/o contraseña esta incorrecto\n
             verifique e intenten de nuevo.`)
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