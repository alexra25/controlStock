<?php

include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$errores = [];

// Consulta para registros con id_estado igual a 2
$consulta_2 = "SELECT seguimiento.*, 
            productos.nombre AS nombre_producto,
            usuarios.nombre AS nombre_usuario,
            usuarios.departamento,
            productos.referencia,
            estados.nombre_estado

            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id 
            INNER JOIN usuarios ON seguimiento.id_usuario = usuarios.id
            INNER JOIN estados ON seguimiento.id_estado = estados.id
            WHERE seguimiento.id_estado = 2
            ORDER BY seguimiento.id DESC";

// Consulta para registros con id_estado igual a 4
$consulta_4 = "SELECT seguimiento.*, 
            productos.nombre AS nombre_producto,
            usuarios.nombre AS nombre_usuario,
            usuarios.departamento,
            productos.referencia,
            estados.nombre_estado

            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id 
            INNER JOIN usuarios ON seguimiento.id_usuario = usuarios.id
            INNER JOIN estados ON seguimiento.id_estado = estados.id
            WHERE seguimiento.id_estado = 4
            ORDER BY seguimiento.id DESC";

$resultadoConsulta = mysqli_query($conn, $consulta_2);
$resultadoConsulta_2 = mysqli_query($conn, $consulta_4);

// Verificar si hay resultados en la consulta 2
if (mysqli_num_rows($resultadoConsulta) > 0) {
    $mostrarTabla1 = true;
} else {
    $mostrarTabla1 = false;
}

// Verificar si hay resultados en la consulta 4
if (mysqli_num_rows($resultadoConsulta_2) > 0) {
    $mostrarTabla2 = true;
} else {
    $mostrarTabla2 = false;
}


if (isset($_POST['orden'])) {
    if (isset($_POST['seleccionados'])) {
        $seleccionados = $_POST['seleccionados'];
        $id_estado = $_POST['id_estado'];
        $nuevo_estado = 4;
        ini_set('display_errors', 1);
        for ($i = 0; $i < count($seleccionados); $i++) {
            $id_modificar = $seleccionados[$i];
            if ($id_estado[$i] == 2) {
                $consulta = "UPDATE seguimiento SET id_estado = $nuevo_estado WHERE id = $id_modificar";
                $resultados = mysqli_query($conn, $consulta);
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        if ($resultados) {
            setRegistro($nombre, 8, $id_usuario, $conn);

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
        exit();

    } else {
        $errores[] = "Ninguna solicitud seleccionada.";
    }
}

if (isset($_POST['reponer'])) {
    if (isset($_POST['seleccionados'])) {
        $seleccionados = $_POST['seleccionados'];
        $cantidades = $_POST['cantidad'];
        $id_estado = $_POST['id_estado'];
        $id_producto = $_POST['id_producto'];
        $nuevo_estado = 5; // Supongo que este es el valor predeterminado del nuevo estado

        for ($i = 0; $i < count($seleccionados); $i++) {
            $id_modificar = $seleccionados[$i];

            $cantidad = $cantidades[$i];

            if ($id_estado[$i] == 4) {
                $nuevo_estado = 5;

                // Consulta para obtener la cantidad actual
                $query = "SELECT * FROM productos WHERE id = $id_producto[$i]";
                $resultado = mysqli_query($conn, $query);

                if ($resultado) {
                    $productoSeleccionado = mysqli_fetch_assoc($resultado);
                    $cantidadActualizada = $productoSeleccionado['cantidad'] + $cantidad;

                    // Corregir la sintaxis de la consulta de actualización
                    $consulta = "UPDATE productos SET cantidad = $cantidadActualizada WHERE id = $id_producto[$i]";
                    $resultados = mysqli_query($conn, $consulta);

                    // Corregir la sintaxis de la consulta de actualización
                    $consulta = "UPDATE seguimiento SET id_estado = $nuevo_estado WHERE id = $id_modificar";
                    $resultados = mysqli_query($conn, $consulta);

                    if (!$resultados) {
                        // Manejar errores de la consulta de actualización si es necesario
                        $errores[] = "Error al actualizar el seguimiento para el ID $id_producto[$i]";
                    }
                } else {
                    // Manejar errores de la consulta de selección si es necesario
                    $errores[] = "Error al obtener la cantidad del producto con ID $id_producto[$i]";
                }
            }
            if ($resultados) {
                setRegistro($nombre, 9, $id_usuario, $conn);

            } else {
                echo "Error al eliminar la categoría: " . mysqli_error($conn);
            }
        }

    } else {
        $errores[] = "Ninguna solicitud seleccionada.";
    }
}


// Cerrar la conexión cuando hayas terminado
$conn->close();
?>



<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!--Aqui va el contenido principal de la pagina -->

<section>
    <?php if ($mostrarTabla1): ?>
        <article>

            <div class="bloque-titulo_boton">

                <h2 class="titulo">Solicitudes Pendientes</h2>

            </div>

            <!-- mostrar los errores si existen -->
            <?php foreach ($errores as $error): ?>
                <div class="alerta error ajustar-contenido">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form method="post">
                <table class="tabla-productos2">
                    <thead>
                        <tr>
                            <th>Solicitar</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Departamento</th>
                            <th>Producto</th>
                            <th>Referencia</th>
                            <th>Cantidad</th>
                            <th>Editar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($seguimiento = mysqli_fetch_assoc($resultadoConsulta)): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="seleccionados[]" value="<?php echo $seguimiento['id']; ?>">
                                </td>
                                <td>
                                    <?php echo $seguimiento['nombre_usuario']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento['fecha']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento['departamento']; ?>
                                </td>
                                <td>
                                    <?php echo "CATEGORIA " . $seguimiento['nombre_producto']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento['referencia']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento['cantidad']; ?>
                                </td>

                                <?php
                                ?>
                                <td>
                                    <a href="modificar-solicitud.php?id=<?php echo $seguimiento['id']; ?>"><i
                                            class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a>
                                </td>

                                <input type="hidden" name="id_estado[]" value="<?php echo $seguimiento['id_estado']; ?>">
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Solicitar" name="orden">
            </form>
        </article>
    <?php endif; ?>

    <?php if ($mostrarTabla2): ?>
        <article>
            <div class="bloque-titulo_boton">

                <h2 class="titulo">Pendientes de Entrega</h2>

            </div>

            <!-- mostrar los errores si existen -->
            <?php foreach ($errores as $error): ?>
                <div class="alerta error ajustar-contenido">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form method="post">
                <table class="tabla-productos2">
                    <thead>

                        <tr>
                            <th>Solicitar</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Departamento</th>
                            <th>Producto</th>
                            <th>Referencia</th>
                            <th>Cantidad</th>
                            <th>Editar</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($seguimiento_2 = mysqli_fetch_assoc($resultadoConsulta_2)): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="seleccionados[]" value="<?php echo $seguimiento_2['id']; ?>">
                                </td>
                                <td>
                                    <?php echo $seguimiento_2['nombre_usuario']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_2['fecha']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_2['departamento']; ?>
                                </td>
                                <td>
                                    <?php echo "CATEGORIA " . $seguimiento_2['nombre_producto']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_2['referencia']; ?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_2['cantidad']; ?>
                                </td>
                                <td>
                                    <a href="modificar-solicitud.php?id=<?php echo $seguimiento_2['id']; ?>"><i
                                            class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a>
                                </td>

                                <input type="hidden" name="id_estado[]" value="<?php echo $seguimiento_2['id_estado']; ?>">
                                <input type="hidden" name="cantidad[]" value="<?php echo $seguimiento_2['cantidad']; ?>">
                                <input type="hidden" name="id_producto[]" value="<?php echo $seguimiento_2['id_producto']; ?>">
                            </tr>
                        <?php endwhile; ?>

                    </tbody>

                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Reponer" name="reponer">
            </form>
        </article>
    <?php endif; ?>
</section>







</main>



<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>