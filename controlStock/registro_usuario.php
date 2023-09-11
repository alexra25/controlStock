<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

// Verificar si se ha enviado el formulario
if(isset($_POST["registrar"])) {

    include "conexion.php";
    include "sesion.php";
    // Obtener los datos del formulario
    $username = $_POST["username"];
    $pasword = $_POST["pasword"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $email = $_POST["email"];
    $departamento = $_POST["departamento"];

    // Consulta SQL para insertar el nuevo usuario en la tabla 'usuarios'
    $sql = "INSERT INTO usuarios (username, pasword, nombre, apellido1, apellido2, email, departamento) VALUES ('$username', '$pasword', '$nombre', '$apellido1','$apellido2' ,'$email', '$departamento')";

    $consulta = mysqli_query($conn,$sql);

    if($consulta){
        header("Location: inicio_sesion.php");
    }else{
        echo "Error al registrarse";
    }
    

    // Cerrar la conexión
    $conexion->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Formulario de Registro de Usuarios</title>
</head>
<body class="contenido-formulario">
    <h2 class="titulo">Registro de Usuarios</h2>
    <form  method="post" class="formulario">
        <label class="formulario-label" for="username">Usuario:</label>
        <input class="formulario-input" type="text" id="username" name="username" required>
        <br><br>

        <label class="formulario-label" for="pasword">Contraseña:</label>
        <input class="formulario-input" type="password" id="pasword" name="pasword" required>
        <br><br>

        <label class="formulario-label" for="nombre">Nombre:</label>
        <input class="formulario-input" type="text" id="nombre" name="nombre" required>
        <br><br>

        <label class="formulario-label" for="apellido1">Primer apellido:</label>
        <input class="formulario-input" type="text" id="apellido1" name="apellido1" required>
        <br><br>

        <label class="formulario-label" for="apellido2">Segundo apellido:</label>
        <input class="formulario-input" type="text" id="apellido2" name="apellido2" required>
        <br><br>

        <label class="formulario-label" for="email">Email:</label>
        <input class="formulario-input" type="text" id="email" name="email" required>
        <br><br>

        <label class="formulario-label" for="departamento">Departamento:</label>
        <input class="formulario-input" type="text" id="departamento" name="departamento" required>
        <br><br>

        <input type="submit" class="formulario-boton" value="Registrar" name="registrar">
    </form>
</body>
</html>
