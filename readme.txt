Example APIREST
To start server (terminal #1)
 php -S localhost:8000 server.php

To consume an API
 curl http://localhost:8000 -v
 curl http://localhost:8000/\?resource_type\=books
 curl http://localhost:8000/\?resource_type\=books | jq
Show headers
 $ curl http://localhost:8000/\?resource_type\=books -v > /dev/null
Query
 $curl "http://localhost:8000?resource_type=books&resource_id=1"
POST
curl -X 'POST' http://localhost:8000/books -d '{"titulo":"Nuevo Libro","id_autor":1,"id_genero":2}'
// Método Put - el recurso 1 será reemplazado por el libro que estoy creando
// $ curl -X 'PUT' http://localhost:8000/books/1 -d '{"titulo": "Nuevo Libro", "id_autor": 1, "id_genero": 2}'
// Método Delete
// curl -X 'DELETE' http://localhost:8000/books/1
?>
