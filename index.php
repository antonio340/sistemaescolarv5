<?php
require_once "header.php";
require "vendor/autoload.php";
?>



 
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    </nav>
   
    <br>

<section class="section">
  <div class="box">
        <h4 class="title is-4">- ingresar -</h4>
        <form name="form1" method="POST" action="api/funcion.php/login">
          <strong>nombre</strong>
            <input type="text" name="usuario">
          <strong>contraseña</strong>
            <input type="password" name="password">
         <input class="button is-danger is-light" value="login" type="button" onclick="login()">
         </form>
  </div>
</section>

<section class="section">
  <div class="box">
        <h4 class="title is-4">- insertar -</h4>
        <form name="form2" method="POST" action="api/funcion.php/insertar">
          <strong>id del alumno</strong>
            <input type="text" name="usuario">
          <strong>id de asignatura</strong>
            <input type="text" name="asignatura">
          <strong>calificacion</strong>
            <input type="text" name="calificacion">
          
         <input class="button is-danger is-light" value="insertar" type="button" onclick="insert()">
         </form>
  </div>
</section>

<section class="section">
  <div class="box">
        <h4 class="title is-4">- eliminar -</h4>
        <form name="form3" method="POST" action="api/funcion.php/insertar">
          <strong>id del alumno</strong>
            <input type="text" name="usuario">
          <strong>id de asignatura</strong>
            <input type="text" name="asignatura">
          <strong>calificacion</strong>
            <input type="text" name="calificacion">
          
         <input class="button is-danger is-light" value="insertar" type="button" onclick="eliminar()">
         </form>
  </div>
</section>


<script>
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

<script>
    function insert(){

        axios.post(`api/funcion.php/insertar/${document.forms['form2'].usuario.value}`, {
        usuario: document.forms['form2'].usuario.value,
        asignatura: document.forms['form2'].asignatura.value,
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
    </script>

<script>
    function eliminar(){

        axios.post(`api/funcion.php/eliminar/${document.forms['form3'].usuario.value}`, {
        usuario: document.forms['form3'].usuario.value,
        asignatura: document.forms['form3'].asignatura.value,
        calificacion: document.forms['form3'].calificacion.value,
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
    </script>