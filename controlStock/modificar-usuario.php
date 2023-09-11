<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$consulta_usuarios = "SELECT * FROM usuarios";
$resultados_usuarios = mysqli_query($conn, $consulta_usuarios);

$id = $_GET['id'];

$consulta = "SELECT * FROM usuarios WHERE id = ${'id'}";
$resultadoConsulta = mysqli_query($conn, $consulta);
$usuario = mysqli_fetch_assoc($resultadoConsulta);
$state = 0;

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM usuarios WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        header("Location: usuarios.php");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}

$username = $usuario['username'];
$pasword = $usuario['pasword'];
$nombre = $usuario['nombre'];
$apellido1 = $usuario['apellido1'];
$apellido2 = $usuario['apellido2'];
$email = $usuario['email'];
$departamento = $usuario['departamento'];

if (isset($_POST['modificar'])) {
    // Recogemos los valores donde los almacenamos y sanitizamos
    $id_modificar = $_POST['id'];
    $username = $_POST['username'];
    $pasword = $_POST['pasword'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];
    $departamento = $_POST['departamento'];

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

    if (empty($errores)) {
        $consulta = "UPDATE usuarios SET username='$username',pasword='$pasword',nombre='$nombre',apellido1='$apellido1',apellido2='$apellido2',email='$email',departamento='$departamento' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 2;
    }
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<section>
    <div class="bloque-titulo_boton">
        <h2 class="titulo">Modificar Usuario</h2>
        <a href="usuarios.php">
            <div class="boton-primario btn btn-primary">Volver</div>
        </a>
    </div>

    <?php if (intval($state) === 2): ?>
        <div class="alerta succes">
            <?php echo "Usuario modificado correctamente"; ?>
        </div>
    <?php endif; ?>

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
                    <option value="OFICINA" <?php if ($departamento === 'OFICINA')
                        echo 'selected'; ?>>OFICINA</option>
                    <option value="DIBUJO" <?php if ($departamento === 'DIBUJO')
                        echo 'selected'; ?>>DIBUJO</option>
                    <option value="TECNICO" <?php if ($departamento === 'TECNICO')
                        echo 'selected'; ?>>TECNICO</option>
                    <option value="CLICHES" <?php if ($departamento === 'CLICHES')
                        echo 'selected'; ?>>CLICHES</option>
                    <option value="MONTAJE" <?php if ($departamento === 'MONTAJE')
                        echo 'selected'; ?>>MONTAJE</option>
                </select>
            </div>

            <div>
                <label class="formulario-label">Email:</label>
                <input class="formulario-input" type="text" placeholder="Email" name="email"
                    value="<?php echo $email ?>">

            </div>
            <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
            <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
            <input type="hidden" name="id" value="<?php echo $usuario['id'] ?>">
        </form>
    </div>
</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>