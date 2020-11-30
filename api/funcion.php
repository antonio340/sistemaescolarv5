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
$app->post('/insertar/{usuario}', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);

    $id = DB::table('calificaciones')->insertGetId([
         'calificacion' => $data->calificacion,
         'alumnos_idalumnos' => $data->usuario,
         'asignaturas_idasignaturas' => $data->asignatura,
    ]);
    $msg = new stdClass();
    $msg->aceptado = empty($id)? false: true;
    $response->getBody()->write(json_encode($msg));
    return $response;
});

//borrar calificaciones
$app->post('/eliminar/{usuario}', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);

 
    $id = DB::table('calificaciones')->where([
        'calificacion',$data->calificacion,
        'alumnos_idalumnos',$data->usuario,
        'asignaturas_idasignaturas',$data->asignatura,
   ])->delete();
    $msg = new stdClass();
    $msg->aceptado = true;
    $response->getBody()->write(json_encode($msg));
    return $response;
});

//consultar calificaciones
$app->post('/consultar', function (Request $request, Response $response, array $args){

    $data = json_decode($request->getBody()->getContents(), false);
    $id = DB::table('calificaciones')->insertGetId([
         'calificacion' => $data['calificacion'],
         'alumnos_idalumnos' => $data['usuario'],
         'asignaturas_idasignaturas' => $data['asignatura'],
    ]);
    $msg = new stdClass();
    $msg->aceptado = empty($id)? false: true;
    $response->getBody()->write(json_encode($msg));
    return $response;
});
// Run application
$app->run();