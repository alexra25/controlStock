<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$consulta_usuarios = "SELECT * FROM proveedores";
$resultados_usuarios = mysqli_query($conn, $consulta_usuarios);

$id = $_GET['id'];

$consulta = "SELECT * FROM proveedores WHERE id = ${'id'}";
$resultadoConsulta = mysqli_query($conn, $consulta);
$proveedores = mysqli_fetch_assoc($resultadoConsulta);
$state = 0;

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM proveedores WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        header("Location: proveedores.php");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}

    $codigo = $proveedores['id'];
    $proveedor = $proveedores['proveedor'];
    $referencia = $proveedores['referencia'];
    $direccion = $proveedores['direccion'];
    $pais = $proveedores['pais'];
    $provincia = $proveedores['provincia'];
    $poblacion = $proveedores['poblacion'];
    $codPostal = $proveedores['codPostal'];
    $telefono = $proveedores['telefono'];
    $fax = $proveedores['fax'];
    $correo = $proveedores['correo'];
    $nacional = $proveedores['nacional'];

if (isset($_POST['modificar'])) {
    // Recogemos los valores donde los almacenamos y sanitizamos
    $id_modificar = $_POST['id'];
    $codigo = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $referencia = $_POST['referencia'];
    $direccion = $_POST['direccion'];
    $pais = $_POST['pais'];
    $provincia = $_POST['provincia'];
    $poblacion = $_POST['poblacion'];
    $codPostal = $_POST['codPostal'];
    $telefono = $_POST['telefono'];
    $fax = $_POST['fax'];
    $correo = $_POST['correo'];
    $nacional = $_POST['nacional'];
    

    // Verificacion de formulario
    /*if (!$codigo) {
        $errores[] = "Debes añadir un nombre proveedor";
    }*/

    if (!$proveedor) {
        $errores[] = "Debes añadir un proveedor";
    }

    if (!$referencia) {
        $errores[] = "Debes añadir una referencia";
    }

    if (!$direccion) {
        $errores[] = "Debes añadir una direccion";
    }

    if (!$pais) {
        $errores[] = "Debes añadir un pais";
    }

    if (!$provincia) {
        $errores[] = "Debes añadir una provincia";
    }

    if (!$poblacion) {
        $errores[] = "Debes añadir una poblacion";
    }

    if (!$codPostal) {
        $errores[] = "Debes añadir un codPostal";
    }

    if (!$telefono) {
        $errores[] = "Debes añadir un telefono";
    }

    if (!$fax) {
        $errores[] = "Debes añadir un fax";
    }

    if (!$correo) {
        $errores[] = "Debes añadir un email";
    }

    if (!$nacional) {
        $errores[] = "Debes añadir un nacional";
    }

    if (empty($errores)) {
        $consulta = "UPDATE proveedores SET id='$codigo',proveedor='$proveedor',referencia='$referencia',direccion='$direccion',poblacion='$poblacion',pais='$pais',provincia='$provincia',codPostal='$codPostal',telefono='$telefono',fax='$fax',correo='$correo',nacional='$nacional' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 2;

        if ($resultados) {
            setRegistro($nombre, 12, $id_usuario,$id_categoria,$id_insertado,$conn);

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
        <h2 class="titulo">Modificar Poveedor</h2>
        <a href="proveedores.php">
            <div class="boton-primario btn btn-primary">Volver</div>
        </a>
    </div>

    <?php if (intval($state) === 2): ?>
        <div class="alerta succes">
            <?php echo "Proveedor modificado correctamente"; ?>
        </div>
    <?php endif; ?>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <div class="contenido-formulario">
        <form class="formulario" method="post">
            <!--<div>
                <label class="formulario-label">Código:</label>
                <input class="formulario-input" type="text" placeholder="codigo proveedor" name="codigo"
                    value="<?php //echo $codigo ?>">
            </div>-->
            <div>
                <label class="formulario-label">Proveedor:</label>
                <input class="formulario-input" type="text" placeholder="Nombre Proveedor" name="proveedor"
                    value="<?php echo $proveedor ?>">
            </div>
            <div>
                <label class="formulario-label">Referencia:</label>
                <input class="formulario-input" type="text" placeholder="Referencia" name="referencia"
                    value="<?php echo $referencia ?>">
            </div>
            <div>
                <label class="formulario-label">Dirección:</label>
                <input class="formulario-input" type="text" placeholder="Direccion" name="direccion"
                    value="<?php echo $direccion ?>">

            </div>
            <div>
                <label class="formulario-label">País:</label>
                <input class="formulario-input" type="text" placeholder="Pais:" name="pais"
                    value="<?php echo $pais ?>">

            </div>
            <div>
                <label class="formulario-label">Población:</label>
                <input class="formulario-input" type="text" placeholder="Poblacion:" name="poblacion"
                    value="<?php echo $poblacion ?>">

            </div>
            <div>
                <label class="formulario-label">Provincia:</label>
                <input class="formulario-input" type="text" placeholder="Provincia:" name="provincia"
                    value="<?php echo $provincia ?>">

            </div>
            <div>
                <label class="formulario-label">Código Postal:</label>
                <input class="formulario-input" type="text" placeholder="codPostal:" name="codPostal"
                    value="<?php echo $codPostal ?>">

            </div>
            <div>
                <label class="formulario-label">Teléfono:</label>
                <input class="formulario-input" type="text" placeholder="telefono:" name="telefono"
                    value="<?php echo $telefono ?>">

            </div>
            <div>
                <label class="formulario-label">Fax:</label>
                <input class="formulario-input" type="text" placeholder="Fax:" name="fax"
                    value="<?php echo $fax ?>">

            </div>
            <div>
                <label class="formulario-label">Email:</label>
                <input class="formulario-input" type="text" placeholder="Correo" name="correo"
                    value="<?php echo $correo ?>">

            </div>
            <div>
                <label class="formulario-label">Nacional:</label>
                <input class="formulario-input" type="text" placeholder="Nacional:" name="nacional"
                    value="<?php echo $nacional ?>">

            </div>
            <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
            <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
            <input type="hidden" name="id" value="<?php echo $proveedores['id']?>">
        </form>
    </div>
</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>