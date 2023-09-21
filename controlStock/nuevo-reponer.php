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
$consulta = "SELECT seguimiento.*, 
            productos.nombre AS nombre_producto
            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id
            WHERE seguimiento.id IN ($ids)";

$resultadoConsulta = mysqli_query($conn, $consulta);

if (isset($_POST['reponer'])) {
    if (isset($_POST['cantidades_recibidas'])) {
        $id_seguimientos = $idArray;
        $cantidades_recibidas = $_POST['cantidades_recibidas'];
        $id_estados = $_POST['estados'];
        $id_productos = $_POST['productos'];
        $cantidades_solicitadas = $_POST['cantidades_solicitadas'];



        for ($i = 0; $i < count($cantidades_recibidas); $i++) {
 
            $id_modificar = $id_seguimientos[$i];
            $cantidad = $cantidades_recibidas[$i];
            $cantidad_solicitada = $cantidades_solicitadas[$i];

            if ($id_estados[$i] == 4) {
                $nuevo_estado = 4;
                

                // Consulta para obtener la cantidad actual
                $query = "SELECT * FROM productos WHERE id = $id_productos[$i]";
                $resultado = mysqli_query($conn, $query);
                
                
                if ($resultado) {
                 
                    $productoSeleccionado = mysqli_fetch_assoc($resultado);
                    $cantidadActualizada = $productoSeleccionado['cantidad'] + $cantidad;

                    // comprobar si ha venido todas las unidades solicitadas
                    if($cantidad_solicitada == $cantidad){
                        $nuevo_estado = 5;
                        $estado_producto = 1;
                        $cantidad_solicitada = 0;

                        $consulta = "UPDATE productos SET cantidad = $cantidadActualizada, id_estado = $estado_producto WHERE id = $id_productos[$i]";

                    }else{
                        $cantidad_solicitada -= $cantidad;
                        $consulta = "UPDATE productos SET cantidad = $cantidadActualizada WHERE id = $id_productos[$i]";
                    }

                    // Corregir la sintaxis de la consulta de actualización
                    $resultados = mysqli_query($conn, $consulta);

                    // Corregir la sintaxis de la consulta de actualización
                    $consulta = "UPDATE seguimiento SET id_estado = $nuevo_estado, pendiente_entrega = $cantidad_solicitada WHERE id = $id_modificar";
                    echo $consulta;
                    $resultados = mysqli_query($conn, $consulta);


                    if (!$resultados) {
                        // Manejar errores de la consulta de actualización si es necesario
                        $errores[] = "Error al actualizar el seguimiento para el ID $id_producto[$i]";
                    }

                } else {
                    // Manejar errores de la consulta de selección si es necesario
                    $errores[] = "Error al obtener la cantidad del producto con ID $id_producto[$i]";
                }

                if ($resultados) {
                    //setRegistro($nombre, 9, $id_usuario, $conn);
                    header("Location: seguimiento.php");
    
                } else {
                    echo "Error al eliminar la categoría: " . mysqli_error($conn);
                }

            }
        }
    } else {
        $errores[] = "Ninguna solicitud seleccionada.";
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

                <h2 class="titulo">Orden de Reposicion</h2>

                <a href="seguimiento.php">

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
                 
                            <th>Solicitado</th>

                            <th>Recibido</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>

                            <tr>
                                <td>
                                    <?php echo $productos['nombre_producto']; ?>
                                </td>

                                <td>
                                    <?php echo $productos['pendiente_entrega']; ?>
                                </td>

                                <td>
                                    <input class="formulario-input" type="number" value=<?php echo $productos['pendiente_entrega']; ?> min="0" name="cantidades_recibidas[]">
                                    <input type="hidden" name="estados[]" value="<?php echo $productos['id_estado'] ?>">
                                    <input type="hidden" name="productos[]" value="<?php echo $productos['id_producto'] ?>">
                                    <input type="hidden" name="cantidades_solicitadas[]" value="<?php echo $productos['pendiente_entrega'] ?>">
                                </td>

                            </tr>
                        <?php endwhile; ?>

                    </tbody>

                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Reponer" name="reponer">
            </form>

        </section>
    </main>

    <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>