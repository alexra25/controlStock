<?php
    include "conexion.php";
    include "sesion.php";
    include "includes/registrar.php";
// consultar todas las categorias
$consulta_usuarios = "SELECT * FROM usuarios";
$resultados_usuarios = mysqli_query($conn, $consulta_usuarios);


// declarar variables de value
$errorres = [];
$username = '';
$pasword = '';
$nombre = '';
$apellido1 = '';
$apellido2 = '';
$email = '';
$departamento = '';
$rol = '';


if (isset($_POST['insertar'])) { // Verifica si el formulario se ha enviado

    // Recogemos los valores donde los almacenamos y sanitizamos

    $username = $_POST['username'];
    $pasword = $_POST['pasword'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];

    // Verificacion de formulario
    if (!$username) {
        $errores[] = "Debes añadir un Nombre Usuario";
    }

    if (!$pasword) {
        $errores[] = "Debes añadir una contraseña";
    }

    if (!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$apellido1) {
        $errores[] = "Debes añadir primer apellido";
    }

    if (!$apellido2) {
        $errores[] = "Debes añadir segundo apellido";
    }

    if (!$email) {
        $errores[] = "Debes añadir un email";
    }

    if (!$departamento) {
        $errores[] = "Debes añadir un departamento";
    }

    if (!$rol) {
        $errores[] = "Debes añadir un rol";
    }

    // revisar el array de errores y si esta vacio lo guarda en la base de datos
    if (empty($errores)) {
        $consulta = "INSERT INTO usuarios (username, pasword, nombre, apellido1, apellido2, email, id_rol, id_departamento) values ('$username','$pasword','$nombre','$apellido1','$apellido2','$email','$rol','$departamento')";

        $resultados = mysqli_query($conn, $consulta);

    }

    // Cerrar la conexión cuando hayas terminado
    $conn->close();

}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!--Aqui va el contenido principal de la pagina -->
<section>
    <div class="bloque-titulo_boton">
        <h2 class="titulo">Nuevo Usuario</h2>
        <a href="usuarios.php">
            <div class="boton-primario btn btn-primary">Volver</div>
        </a>
    </div>


    <!-- mostrar los errores si existen -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <div class="contenido-formulario">
        <form class="formulario" method="post">
            <div>
                <label class="formulario-label">Username:</label>
                <input class="formulario-input" type="text" placeholder="Nombre Usuario" name="username"
                    value="<?php echo $username ?>">
            </div>
            <div>
                <label class="formulario-label">Contraseña:</label>
                <input class="formulario-input" type="text" placeholder="Contraseña" name="pasword"
                    value="<?php echo $pasword ?>">
            </div>
            <div>
                <label class="formulario-label">Nombre:</label>
                <input class="formulario-input" type="text" placeholder="Nombre" name="nombre"
                    value="<?php echo $nombre ?>">
            </div>
            <div>
                <label class="formulario-label">Primer apellido:</label>
                <input class="formulario-input" type="text" placeholder="Primer apellido:" name="apellido1"
                    value="<?php echo $apellido1 ?>">

            </div>
            <div>
                <label class="formulario-label">Segundo apellido:</label>
                <input class="formulario-input" type="text" placeholder="Segundo apellido:" name="apellido2"
                    value="<?php echo $apellido2 ?>">

            </div>
            <div>
                <label class="formulario-label">Departamento:</label>
                <select class="formulario-input formulario-select" name="departamento">
                    <option value="">--Seleccionar--</option>
                    <option value="1">OFICINA</option>
                    <option value="2">DIBUJO</option>
                    <option value="5">TECNICO</option>
                    <option value="4">CLICHES</option>
                    <option value="3">MONTAJE</option>
                </select>
            </div>
            <div>
                <label class="formulario-label">Rol:</label>
                <select class="formulario-input formulario-select" name="rol">
                    <option value="">--Seleccionar--</option>
                    <option value="1">Administrador</option>
                    <option value="2">Jefe departamento</option>
                    <option value="3">Técnico</option>
                    <option value="4">Operario</option>
                </select>
            </div>
            <div>
                <label class="formulario-label">Email:</label>
                <input class="formulario-input" type="text" placeholder="Email" name="email"
                    value="<?php echo $email ?>">

            </div>
            <input class="boton-primario btn btn-primary" type="submit" value="Insertar" name="insertar">
        </form>
    </div>
</section>

</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>