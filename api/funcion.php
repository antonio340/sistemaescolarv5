<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath('/sistemaescolarv5/api/funcion.php');

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello World');
    return $response;
});

//login de usuarios
$app->post('/login/{usuario}', function (Request $request, Response $response, array $args) {
    
    $data = json_decode($request->getBody()->getContents(), false);
  

    $user = DB::table('usuarios')
    ->leftjoin('perfiles','usuarios.perfiles_idperfiles', '=', 'perfiles.idperfiles')
    ->where('usuarios.nombreusuario',$data->usuario)
    ->first();

    $msg = new stdClass();
    
    if ($user->password == $data->password){
        
        $msg->aceptado = true;
        $msg->nombreperfil = $user->nombreperfil;
        $msg->idusuario = $user->idusuarios;
    
    }
    else {
        $msg->aceptado = false;
    }
    $response->getBody()->write(json_encode($msg));
    return $response;
    
});

//insertar o editar calificaciones
$app->post('/insertar/{alumnos}', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);

    

    $id = DB::table('calificaciones')->insertGetId([
         'calificacion' => $data->calificacion,
         'alumnos_idalumnos' => $data->idAlumno,
         'asignaturas_idasignaturas' => $data->idAsignatura,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

//borrar calificaciones
$app->post('/eliminar/{usuario}', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);

 
    $id = DB::table('calificaciones')->where(
        'alumnos_idalumnos',$data->idAlumno3)->where(
        'asignaturas_idasignaturas',$data->idAsignatura3
    )->delete();
    $msg = new stdClass();
    $msg->aceptado = true;
    $response->getBody()->write(json_encode($msg));
    return $response;
});

//consultar calificaciones


//editar calificaciones
$app->post('/editar/{alumnos}', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);

    

    $id = DB::table('calificaciones')->where(
        'alumnos_idalumnos',$data->idAlumno4)->where(
        'asignaturas_idasignaturas',$data->idAsignatura4
    )->update([
         'calificacion' => $data->calificacion4,
         'alumnos_idalumnos' => $data->idAlumno4,
         'asignaturas_idasignaturas' => $data->idAsignatura4,
    ]);
    $msg = new stdClass();
    $msg->aceptado = !empty($id);
    $response->getBody()->write(json_encode($msg));
    return $response;
});

//editar calificaciones
$app->post('/consultar/{idusuario}', function (Request $request, Response $response, array $args){    
    
    $data = new stdClass();

    $user = DB::table('usuarios')
    ->leftJoin('perfiles', 'usuarios.perfiles_idperfiles', '=', 'perfiles.idperfiles')
    ->where('usuarios.idusuarios', $args['idusuario'])
    ->first();

    //$perfil = $user->nombreperfil = 'maestro' ? true : false;

    if ($user->nombreperfil == 'maestro'){
        $perfil=true;
    }
       
    else{
         $perfil=false;
    }
    if ($perfil==true){
        //mostrar todas las calificaciones
        $all_cal = DB::table('calificaciones')
        ->leftJoin('alumnos', 'calificaciones.alumnos_idalumnos', '=', 'alumnos.idalumnos' )        
        ->get();
    } else {
        //mostrar solamente las calificaciones del alumno
        $cal_alumno = DB::table('calificaciones')
        ->leftJoin('alumnos', 'calificaciones.alumnos_idalumnos', '=', 'alumnos.idalumnos' )
        ->where('alumnos.usuarios_idusuarios',$user->idusuarios)
        ->get();        
    }
   
    
    $data->calificaciones = $perfil ? $all_cal : $cal_alumno;
    $data->nombreperfil=$perfil;
    $data->idUsuario = $user->idusuarios;
    $response->getBody()->write(json_encode($data));
    return $response;
});

// Run application
$app->run();
