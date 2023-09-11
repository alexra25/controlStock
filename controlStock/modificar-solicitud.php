<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$id = $_GET['id'];

$consulta = "SELECT seguimiento.*,
            productos.nombre AS nombre_producto,
            usuarios.nombre AS nombre_usuario,
            usuarios.departamento,
            productos.referencia,
            estados.nombre_estado
            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id
            INNER JOIN usuarios ON seguimiento.id_usuario = usuarios.id
            INNER JOIN estados ON seguimiento.id_estado = estados.id
            WHERE seguimiento.id = '$id'";

$resultadoConsulta = mysqli_query($conn, $consulta);
$solicitud = mysqli_fetch_assoc($resultadoConsulta);

$state = 0;
$nombre_usuario = $solicitud['nombre_usuario'];
$fecha = $solicitud['fecha'];
$departamento = $solicitud['departamento'];
$nombre_producto = $solicitud['nombre_producto'];
$referencia = $solicitud['referencia'];
$cantidad = $solicitud['cantidad'];
$nombre_estado = $solicitud['nombre_estado'];

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM seguimiento WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);
    if ($resultados) {
        setRegistro($nombre, 10, $id_usuario, $conn);

    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }
}

if (isset($_POST['modificar'])) {
    $id_modificar = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    if (!$cantidad) {
        $errores[] = "Debes añadir una cantidad";
    }

    if (empty($errores)) {
        $consulta = "UPDATE seguimiento SET cantidad = '$cantidad' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 2;

        if ($resultados) {
            setRegistro($nombre, 10, $id_usuario, $conn);

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
    }
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Modificar Solicitud</h2>
                <a href="seguimiento.php">
                    <div class="boton-primario btn btn-primary">Volver</div>
                </a>
            </div>

            <?php if (intval($state) === 2): ?>
                <div class="alerta succes">
                    <?php echo "Solicitud modificada correctamente"; ?>
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
                        <label class="formulario-label">Solicitante:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $nombre_usuario?>">
                    </div>
                    <div>
                        <label class="formulario-label">Fecha:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $fecha?>">
                    </div>
                    <div>
                        <label class="formulario-label">Departamento:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $departamento?>">
                    </div>
                    <div>
                        <label class="formulario-label">Producto:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $nombre_producto?>">
                    </div>
                    <div>
                        <label class="formulario-label">Referencia:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $referencia?>">
                    </div>
                    <div>
                        <label class="formulario-label">Estado:</label>
                        <input class="formulario-input" type="text" disabled value="<?php echo $nombre_estado?>">
                    </div>
                    <div>
                        <label class="formulario-label">Cantidad:</label>
                        <input class="formulario-input" type="number" name="cantidad" value="<?php echo $cantidad ?>">
                    </div>

                    <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
                    <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
                    <input type="hidden" name="id" value="<?php echo $solicitud['id'] ?>">
                </form>
            </div>
        </section>
    </main>

    <!--Aqui va el pie de la pagina -->
    <?php include 'includes/footer.php'; ?>
