<?php


/*
-- Autenticacion via HTTP
$user = array_key_exists( 'PHP_AUTH_USER', $_SERVER ) ?  $_SERVER['PHP_AUTH_USER'] : '';
$pwd = array_key_exists( 'PHP_AUTH_PW', $_SERVER ) ?  $_SERVER['PHP_AUTH_PW'] : '';

if ($user !== 'juan' &&  $pwd !== 'juan'){
    http_response_code(401);
}*/

// Autenticacion via HMAC
/*
if(
  !array_key_exists( 'HTTP_X_HASH', $_SERVER) ||
  !array_key_exists( 'HTTP_X_TIMESTAMP', $_SERVER) ||
  !array_key_exists( 'HTTP_X_UID', $_SERVER)
  )
  {
    die;
  }


list($hash, $uid, $timestamp ) = [
  $_SERVER['HTTP_X_HASH'],
  $_SERVER['HTTP_X_UID'],
  $_SERVER['HTTP_X_TIMESTAMP'],
];

$secret = 'Sh!! No se lo cuentes a nadie!';

$newHash = sha1($uid.$timestamp.$secret);
error_log($_SERVER['HTTP_X_HASH']);
error_log($_SERVER['HTTP_X_HASH']);

if( $newHash !== $hash ){
      error_log('error HMAC');
  die;
}

*/
// Autenticacion via token

/*
if( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER)){
  die;
}

$url = 'http://localhost:8001';

$ch = curl_init( $url );

curl_setopt( 
  $ch,
  CURLOPT_HTTPHEADER,
  [
    "X-Token: {$_SERVER[ 'HTTP_X_TOKEN']}"
  ]
);

curl_setopt( 
  $ch,
  CURLOPT_RETURNTRANSFER,
  true
);

$ret = curl_exec( $ch );

if( $ret !== 'true' ){
  die;
}
*/


//Definimos los recursos disponibles
$allowedResourcetypes = [
  'books',
  'authors',
  'generes',
];

//Validamos que el recurso este disponible
$resourceType = $_GET['resource_type'];

if( !in_array( $resourceType,$allowedResourcetypes) ){
  http_response_code(400);
  die;
}

// Defino los recursos\
$books = [
  1 => [
    'titulo' => 'Lo que el viento se llevo',
    'id_autor' => 2,
    'id_genero' => 2,
  ],
  2 => [
    'titulo' => 'La Iliada',
    'id_autor' => 1,
    'id_genero' => 1,
  ],
  3 => [
    'titulo' => 'La Odisea',
    'id_autor' => 1,
    'id_genero' => 1,
  ],
];



header( 'Content-Type: application/json');

//Lavntar el id del recurso buscado
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

// Generamos la respuesta asumiendo que el pedido es correcto
switch ( strtoupper($_SERVER['REQUEST_METHOD']) ) {
  case 'GET':
  //En caso que no soliciten ningun recurso
  if( empty( $resourceId ) ){
    echo json_encode($books);
  }
  else{

    if( array_key_exists( $resourceId, $books))
    {
        echo json_encode( $books[ $resourceId ] );
    }
    else {
      http_response_code(404);
      die;
    }
  }
    break;
//curl -X 'POST' http://localhost:8000/books -d '{ "titulo": "Nuevo libro", "id_autor": 1, "id_genero": 2 }'
  case 'POST':
    //Tomamoss la entrada cruda
    $json = file_get_contents('php://input');
    //transformamos el json recibido a un nuevo elemento del arreglo
    $books[] = json_decode( $json, true  );
    //Emitimos hacia la salida la ultima clave del arreglo de libros
    echo array_keys( $books )[ count($books) - 1];
    break;

  case 'PUT':
  //Validamos que el recurso buscado exista
    if( !empty( $resourceId ) && array_key_exists( $resourceId, $books )){
      //Tomamoss la entrada cruda
      $json = file_get_contents('php://input');
      //transformamos el json recibido a un nuevo elemento del arreglo
      $books[ $resourceId ] = json_decode( $json, true  );
      //retornamos la coleccion modificada en formato json
      echo json_encode( $books );
    }
    break;

  case 'DELETE':
  //Validamos que el recurso buscado exista
    if( !empty( $resourceId ) && array_key_exists( $resourceId, $books )){
      //Eliminamos el recurso
      unset($books[$resourceId]);

      echo json_encode( $books );
    }
      break;

  default:
    // code...
    break;
}
