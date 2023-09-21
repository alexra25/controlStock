<?php
    include "conexion.php";
    include "sesion.php";
    include "includes/registrar.php";

// consultar todas las categorias
$consulta_usuarios = "SELECT * FROM proveedores";
$resultados_usuarios = mysqli_query($conn, $consulta_usuarios);


// declarar variables de value
$errorres = [];
$codigo = '';
$proveedor = '';
$referencia = '';
$direccion = '';
$pais = '';
$provincia = '';
$poblacion = '';
$codPostal = '';
$telefono = '';
$fax = '';
$correo = '';
$nacional = '';

if (isset($_POST['insertar'])) { // Verifica si el formulario se ha enviado

    // Recogemos los valores donde los almacenamos y sanitizamos

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

    // revisar el array de errores y si esta vacio lo guarda en la base de datos
    if (empty($errores)) {
        $consulta = "INSERT INTO proveedores (proveedor, referencia, direccion, poblacion, pais, provincia, codPostal, telefono, fax, correo, nacional) 
        values ('$proveedor','$referencia','$direccion','$poblacion','$pais','$provincia','$codPostal','$telefono','$fax','$correo','$nacional')";

        $resultados = mysqli_query($conn, $consulta);

        if ($resultados) {
            setRegistro($nombre, 11, $id_usuario,$id_categoria,$id_insertado,$conn);

        } else {
             echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }

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
        <h2 class="titulo">Nuevo Proveedor</h2>
        <a href="proveedores.php">
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
            <!--<div>
                <label class="formulario-label">Código:</label>
                <input class="formulario-input" type="text" placeholder="codigo proveedor" name="codigo"
                    value="<?php echo $codigo ?>">
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
                <input class="formulario-input" type="email" placeholder="Correo" name="correo"
                    value="<?php echo $correo ?>">

            </div>
            <div>
                <label class="formulario-label">Nacional:</label>
                <input class="formulario-input" type="text" placeholder="Nacional:" name="nacional"
                    value="<?php echo $nacional ?>">

            </div>
            <input class="boton-primario btn btn-primary" type="submit" value="Insertar" name="insertar">
        </form>
    </div>
</section>

</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>