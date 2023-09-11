<?php

//Aqui hacemos la conexion a la base de datos

//variables de conexion
$servername ="localhost";
$username ="root";
$password ="";
$database ="Stock";

$conn = new mysqli($servername,$username,$password,$database);

//verifico que se ha iniciado la conexion
if($conn -> $connect_error){
    die("Error de conexión: " . $conn->connect_error);
}

?>