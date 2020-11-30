<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;
require_once "header.php";
require "vendor/autoload.php";
require "config/database.php";

$user = DB::table('usuarios')
    ->leftjoin('perfiles','usuarios.perfiles_idperfiles', '=', 'perfiles.idperfiles')
    ->where('usuarios.nombreusuario',$_POST['usuario'])
    ->first();

//si no se encuentra una sesión de maestro entonces muestra lo siguiente
if(!isset($_SESSION["maestro"]) and !isset($_SESSION["alumno"]))
{
 echo <<<_LOGIN1

 
 NO puedes estar aqui
_LOGIN1;
}
//si encontró una sesión de alumno
{
 
    if(isset($_SESSION["alumno"]))
    {
     
    echo <<<_LOGGED2

    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
            <div class="buttons">
          <a class="button is-dark" href="logout.php">
             <strong>Log out</strong>
          </a>
        </nav>
_LOGGED2;
     }
     else //entonces es una sesión de maestro
     {
        $nombre_de_usuario=$_SESSION["maestro"];
 
   echo <<<_LOGGED1

    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
            <div class="buttons">
          <a class="button is-dark" href="logout.php">
             <strong>Log out</strong>
          </a>
          <a class="button is-dark" href="insertarcal.php">
          <strong>Insertar calificación</strong>
       </a>
       <a class="button is-dark" href="erasecal1.php">
       <strong>eliminar calificación</strong>
    </a>
    </nav>
          
    <section class="hero">
    <div class="hero-head">
      
        <h1 class="title">
        sesion iniciada como: 
        </h1>
        <h2 class="subtitle">
         -$nombre_de_usuario-
        </h2>
      </div>
  </section>



_LOGGED1;




     }
}
