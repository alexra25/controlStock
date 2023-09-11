<?php

//Aqui hacemos la conexion a la base de datos

//variables de conexion
$servername ="localhost";
$username ="root";
$password ="";
$database ="db_stock_alacid";

$conn = mysqli_connect($servername,$username,$password,$database);

//verifico que se ha iniciado la conexion
if(!$conn){
    die("Error de conexión: ");
}

?>