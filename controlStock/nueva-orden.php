<?php
include "conexion.php";
include "sesion.php";
//include "includes/registrar.php";

$seleccionados = $_GET['seleccionados'];
$errores = [];
$idArray = explode(',', $seleccionados);
$idArray = array_map('intval', $idArray);
$ids = implode(',', $idArray);

//$consulta = "SELECT * FROM productos WHERE id IN ($ids)";
$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
            INNER JOIN categorias ON productos.id_categoria = categorias.id
            WHERE productos.id IN ($ids)";

$resultadoConsulta = mysqli_query($conn, $consulta);

if (isset($_POST['solicitar'])) {
    $cantidades = $_POST['cantidad'];
    $productos = $_POST['productos'];
    $estados = $_POST['estados'];
    

    if (isset($_POST['cantidad'])) {
        for ($i = 0; $i < count($cantidades); $i++) {
            $id_producto = $productos[$i];
            $cantidad_solicitada = $cantidades[$i];
            $id_estado = $estados[$i];
            $pendiente_entrega = $cantidad_solicitada;

            if($id_estado == 2){
                $id_estado_producto = 3;
                $consulta = "UPDATE productos SET id_estado = '$id_estado_producto' WHERE id = $id_producto";
                $resultados_descontar = mysqli_query($conn, $consulta);
            }
            
            // Insertar en la tabla seguimiento
            $id_estado = 3;

            $consulta = "INSERT INTO seguimiento (cantidad, id_usuario, id_producto, id_estado, pendiente_entrega)
                        VALUES ('$cantidad_solicitada', '$id_usuario', '$id_producto', '$id_estado', '$pendiente_entrega')";
                        
            $resultados = mysqli_query($conn, $consulta);

        }

        if ($resultados) {
            //setRegistro($$id_estado, 7, $id_usuario, $id_producto, $id_categoria, $conn);
            header("Location: seguimiento.php");

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }

    } else {
        $errores[] = "Indicar cantidad en todos los productos.";
    }
}

// Cierra la conexión después de haber completado todas las operaciones
$conn->close();

?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <!--Aqui va el contenido principal de la pagina -->

        <section>

            <div class="bloque-titulo_boton">

                <h2 class="titulo">Nueva Orden de Compras</h2>

                <a href="notificaciones.php">

                    <div class="boton-primario btn btn-primary">Volver</div>

                </a>

            </div>

            <!-- mostrar los errores si existen -->
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form method="post">
                <table class="tabla-productos2">
                    <thead>

                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Cantidad</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>
                            <tr>
                                <td>
                                    <?php echo $productos['nombre']; ?>
                                </td>

                                <td>
                                    <?php echo $productos['nombre_categoria']; ?>
                                </td>

                                <td>
                                    <?php echo $productos['cantidad']; ?>
                                </td>

                                <td>
                                    <input class="formulario-input" type="number" value="1" min="0" name="cantidad[]">
                                    <input type="hidden" name="productos[]" value="<?php echo $productos['id'] ?>">
                                    <input type="hidden" name="estados[]" value="<?php echo $productos['id_estado'] ?>">
                                </td>

                            </tr>
                        <?php endwhile; ?>

                    </tbody>

                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Solicitar" name="solicitar">
            </form>

        </section>
    </main>

    <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>