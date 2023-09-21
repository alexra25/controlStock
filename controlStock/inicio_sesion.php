<?php
include "conexion.php";
session_start(); // Iniciar la sesión

if (isset($_POST["iniciar"])) {
    $nombre = $_POST["nombre"];
    $pasword = $_POST["pasword"];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE username = '$nombre' AND pasword = '$pasword'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Verifica si se encontró un usuario con las credenciales proporcionadas
        if (mysqli_num_rows($result) > 0) {
            // Obtener los datos del usuario y almacenarlos en la variable $usuario
            $usuario = mysqli_fetch_assoc($result);
            // Inicio de sesión exitoso
            $_SESSION["username"] = $usuario["username"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["apellido"] = $usuario["apellido"];
            $_SESSION["id_usuario"] = $usuario["id"];
            $_SESSION["id_rol"] = $usuario["id_rol"];
            $_SESSION["id"] = session_id();
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
        }
    } else {
        $error_message = "Error en la consulta: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <!--Links de bootstrap-->
    <link rel="stylesheet" href="./csss/bootstrap.min.css">
    <script src="./js/bootstrap.bundle.min.js"></script>

    <title>Iniciar Sesión</title>
</head>

<body class="contenido-formulario bg-light inicio">
<h2 class="titulo">Iniciar Sesión</h2>
<?php if (isset($error_message)): ?>
    <div class="alerta error">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>
<div class="container mt-6">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-primary bg-gradient text-white">
                        Credenciales
                    </div>
                    <div class="card-body row">
                        <form method="POST" class="formulario">
                            <div class="mb-4">
                                <label class="form-label d-flex align-items-start" for="nombre">Nombre de usuario:</label>
                                <input class="form-control" type="text" name="nombre" ><br>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-flex align-items-start" for="pasword">Contraseña:</label>
                                <input class="form-control" type="password" name="pasword" ><br> 
                            </div>
                            <input class="boton-primario btn btn-primary position-absolute top-55 start-50 translate-middle" type="submit" value="Iniciar Sesión" name="iniciar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>