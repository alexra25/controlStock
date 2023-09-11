<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$consulta_categorias = "SELECT * FROM Categorias";
$resultados_categorias = mysqli_query($conn, $consulta_categorias);

$id = $_GET['id'];

$consulta = "SELECT * FROM productos WHERE id = ${'id'}";
$resultadoConsulta = mysqli_query($conn, $consulta);
$producto = mysqli_fetch_assoc($resultadoConsulta);
$state = 0;

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM productos WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        setRegistro($nombre, 6, $id_usuario, $conn);

    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }
}

$nombre_producto = $producto['nombre'];
$categoria_producto = $producto['id_categoria'];
$stock_producto = $producto['stock_min'];
$cantidad_producto = $producto['cantidad'];

if (isset($_POST['modificar'])) {
    $id_modificar = $_POST['id'];
    $nombre_producto = $_POST['nombre'];
    $categoria_producto = $_POST['id_categoria'];
    $stock_producto = $_POST['stock_min'];
    $cantidad_producto = $_POST['cantidad'];

    if (!$nombre_producto) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$categoria_producto) {
        $errores[] = "Debes añadir una categoria";
    }

    if (!$cantidad_producto) {
        $errores[] = "Debes añadir una cantidad";
    }

    if (!$stock_producto) {
        $errores[] = "Debes añadir una cantidad de stock minimo";
    }

    if (empty($errores)) {
        $consulta = "UPDATE productos SET nombre = '$nombre_producto', id_categoria = '$categoria_producto', stock_min ='$stock_producto', cantidad ='$cantidad_producto' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 2;

        if ($resultados) {
            setRegistro($nombre, 5, $id_usuario, $conn);

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
                <h2 class="titulo">Modificar Producto</h2>
                <a href="productos.php">
                    <div class="boton-primario btn btn-primary">Volver</div>
                </a>
            </div>

            <?php if (intval($state) === 2): ?>
                <div class="alerta succes">
                    <?php echo "Producto modificado correctamente"; ?>
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
                        <label class="formulario-label">Nombre:</label>
                        <input class="formulario-input" type="text" name="nombre"
                            value="<?php echo $nombre_producto ?>">
                    </div>

                    <div>
                        <label class="formulario-label">Categoria:</label>
                        <select class="formulario-input formulario-select" name="id_categoria">
                            <option value="">--Seleccionar--</option>
                            <?php while ($categoria = mysqli_fetch_assoc($resultados_categorias)): ?>
                                <option <?php echo $categoria_producto === $categoria['id'] ? 'selected' : ''; ?>
                                    value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div>
                        <label class="formulario-label">Stock Min:</label>
                        <input class="formulario-input" type="number" name="stock_min"
                            value="<?php echo $stock_producto ?>">
                    </div>

                    <div>
                        <label class="formulario-label">Cantidad:</label>
                        <input class="formulario-input" type="number" name="cantidad"
                            value="<?php echo $cantidad_producto ?>">
                    </div>

                    <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
                    <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
                    <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
                </form>
            </div>
        </section>
    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>