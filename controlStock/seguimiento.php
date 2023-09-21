<?php

include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$errores = [];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Consulta para registros con id_estado igual a 2
$consulta_3 = "SELECT seguimiento.*, 
            productos.nombre AS nombre_producto,
            usuarios.nombre AS nombre_usuario,
            usuarios.id_departamento,
            estados.nombre_estado

            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id 
            INNER JOIN usuarios ON seguimiento.id_usuario = usuarios.id
            INNER JOIN estados ON seguimiento.id_estado = estados.id
            WHERE seguimiento.id_estado = 3
            ORDER BY seguimiento.id DESC";

// Consulta para registros con id_estado igual a 4
$consulta_4 = "SELECT seguimiento.*, 
            productos.nombre AS nombre_producto,
            usuarios.nombre AS nombre_usuario,
            usuarios.id_departamento,
            estados.nombre_estado

            FROM seguimiento
            INNER JOIN productos ON seguimiento.id_producto = productos.id 
            INNER JOIN usuarios ON seguimiento.id_usuario = usuarios.id
            INNER JOIN estados ON seguimiento.id_estado = estados.id
            WHERE seguimiento.id_estado = 4
            ORDER BY seguimiento.id DESC";

$resultadoConsulta_3 = mysqli_query($conn, $consulta_3);
$resultadoConsulta_4 = mysqli_query($conn, $consulta_4);


$consulta_departamentos = "SELECT departamento FROM departamentos";
$resultadoConsulta_departamentos = mysqli_query($conn, $consulta_departamentos);

$departamentos = mysqli_fetch_assoc($resultadoConsulta_departamentos);

// Verificar si hay resultados en la consulta 2
if (mysqli_num_rows($resultadoConsulta_3) > 0) {
    $mostrarTabla1 = true;
} else {
    $mostrarTabla1 = false;
}

// Verificar si hay resultados en la consulta 4
if (mysqli_num_rows($resultadoConsulta_4) > 0) {
    $mostrarTabla2 = true;
} else {
    $mostrarTabla2 = false;
}

if (isset($_POST['orden'])) {
    if (isset($_POST['seleccionados'])) {
        $seleccionados = $_POST['seleccionados'];
        $id_estado = $_POST['id_estado'];
        $id_productos = $_POST['id_productos'];
        $id_proveedores = $_POST['id_proveedores'];
        $falta_proveedor = false;

        for ($i = 0; $i < count($id_proveedores); $i++) {
            if ($id_proveedores[$i] == '') {
                $falta_proveedor = true;
            }
        }

        if ($falta_proveedor == true) {
            $errores[] = "Hay proveedores sin definir";
        }

        ini_set('display_errors', 1);
        for ($i = 0; $i < count($seleccionados); $i++) {
            $id_modificar = $seleccionados[$i];
            $id_producto = $id_productos[$i];
            $id_proveedor = $id_proveedores[$i];
            if ($id_estado[$i] == 3 && $falta_proveedor == false) {

                // cambiar el estado del procucto a solicitado
                $id_estado_producto = 4;
                $nuevo_estado = 4;
                $consulta = "UPDATE productos SET id_estado = $id_estado_producto WHERE id = $id_producto";
                $resultados_descontar = mysqli_query($conn, $consulta);


                $consulta = "UPDATE seguimiento SET id_estado = $nuevo_estado WHERE id = $id_modificar";
                $resultados = mysqli_query($conn, $consulta);

                if ($resultados) {
                    $nombre = "nombre ok";
                    setRegistro($nombre, 8, $id_usuario, $id_categoria, $id_producto, $conn);

                } else {
                    echo "Error al eliminar la categoría: " . mysqli_error($conn);
                }
            }
        }

        //header("Location: " . $_SERVER['REQUEST_URI']);


    } else {
        $errores[] = "Ninguna solicitud seleccionada.";
    }
}

if (isset($_POST['pre_reponer'])) {
    if (isset($_POST['seleccionados'])) {
        $seleccionados = implode(',', $_POST['seleccionados']);
        header("Location: nuevo-reponer.php?seleccionados=$seleccionados");
        exit();

    } else {
        $errores[] = "Ningún producto seleccionado.";
    }

}

// Cerrar la conexión cuando hayas terminado
$conn->close();
?>


<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!--Aqui va el contenido principal de la pagina -->

<?php if ($mostrarTabla1 == false && $mostrarTabla2 == false): ?>
    <article>

        <div class="bloque-titulo_boton">

            <h2 class="titulo">No hay ninguna Solicitud</h2>

        </div>

    </article>
<?php endif ?>

<section>
    <?php include "conexion.php"; ?>
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
                            <th>Proveedor</th>
                            <th>Cantidad</th>
                            <th>Editar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($seguimiento = mysqli_fetch_assoc($resultadoConsulta_3)): ?>

                            <?php
                            $id_producto = $seguimiento['id_producto'];
                            $consulta_proveedor_producto = "SELECT prodProveedores.*, 
                                proveedores.*
                                FROM prodProveedores
                                INNER JOIN proveedores ON prodProveedores.id_proveedor = proveedores.id
                                INNER JOIN productos ON prodProveedores.id_producto = productos.id
                                WHERE productos.id = $id_producto";
                            $resultado_proveedor_producto = mysqli_query($conn, $consulta_proveedor_producto);
                            ?>

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
                                    <?php echo $departamentos['departamento']; ?>
                                </td>
                                <td>
                                    <?php echo "CATEGORIA " . $seguimiento['nombre_producto']; ?>
                                </td>

                                <td>
                                    <select name="id_proveedores[]">
                                        <?php if (mysqli_num_rows($resultado_proveedor_producto) > 1): ?>
                                            <option value="">--Seleccionar--</option>
                                        <?php endif; ?>
                                        <?php while ($proveedor = mysqli_fetch_assoc($resultado_proveedor_producto)): ?>
                                            <option value="<?php echo $proveedor['proveedor']; ?>">
                                                <?php echo $proveedor['proveedor']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <?php echo $seguimiento['cantidad']; ?>
                                </td>

                                <?php
                                ?>
                                <td>
                                    <a href="modificar-solicitud.php?id=<?php echo $seguimiento['id']; ?>">
                                        <iclass="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i>
                                    </a>
                                </td>

                                <input type="hidden" name="id_estado[]" value="<?php echo $seguimiento['id_estado']; ?>">
                                <input type="hidden" name="categorias[]" value="<?php echo $seguimiento['id_categoria']; ?>">
                                <input type="hidden" name="id_productos[]" value="<?php echo $seguimiento['id_producto']; ?>">
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
                            <th>Reponer</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Departamento</th>
                            <th>Producto</th>
           
                            <th>Solicitado</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($seguimiento_2 = mysqli_fetch_assoc($resultadoConsulta_4)): ?>
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
                                    <?php echo $departamentos['departamento']; ?>
                                </td>
                                <td>
                                    <?php echo "CATEGORIA " . $seguimiento_2['nombre_producto']; ?>
                                </td>

                                <td>
                                    <?php echo $seguimiento_2['pendiente_entrega']; ?>
                                </td>

                                <input type="hidden" name="id_estado[]" value="<?php echo $seguimiento_2['id_estado']; ?>">
                                <input type="hidden" name="cantidad[]" value="<?php echo $seguimiento_2['cantidad']; ?>">
                                <input type="hidden" name="id_producto[]" value="<?php echo $seguimiento_2['id_producto']; ?>">
                                <input type="hidden" name="cantidades_pendientes[]"
                                    value="<?php echo $seguimiento_2['cantidad_pendiente']; ?>">
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Reponer" name="pre_reponer">
            </form>
        </article>
    <?php endif; ?>

</section>
<?php
    // Cerrar la conexión cuando hayas terminado
    $conn->close();
    ?>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>