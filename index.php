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


<!-- FUNCIONES JAVASCRIPT -->
<script>

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
   
   
    
    </script>
    </body>
    </html>