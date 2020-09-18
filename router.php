<?php

$matches = [];



// Excepcion para las  url principal sea index.html
if (in_array( $_SERVER["REQUEST_URI"], [ '/index.html', '/', '' ] )) {
  echo file_get_contents( '/home/juancuervo/Documents/APIREST/AJAX//index.html' );
  die;
}




//http://localhost:8000/books/1
/*[0] => /books/1
  [1] => books
  [2] => 1*/
if( preg_match( '/\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches) ){
  $_GET['resource_type'] = $matches[1];
  $_GET['resource_id'] = $matches[2];
  error_log(print_r($matches,1));
  require 'server.php';
}
//http://localhost:8000/books/1
/*[0] => /books
  [1] => books*/
else if( preg_match( '/\/([^\/]+)\/?/', $_SERVER["REQUEST_URI"], $matches)){
  $_GET['resource_type'] = $matches[1];
  error_log(print_r($matches,1));
    require 'server.php';
}
else {
    error_log('No matches');
    http_response_code(404);
}
?>
