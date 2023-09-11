<?php

include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$errores = [];

//$consulta = "SELECT * FROM productos";
$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria 
FROM productos
INNER JOIN categorias ON productos.id_categoria = categorias.id
WHERE productos.cantidad <= productos.stock_min";

$resultadoConsulta = mysqli_query($conn, $consulta);

// Cerrar la conexión cuando hayas terminado

$conn->close();

if (isset($_POST['orden'])) {
    if (isset($_POST['seleccionados'])) {
        $seleccionados = implode(',', $_POST['seleccionados']);
        header("Location: nueva-orden.php?seleccionados=$seleccionados");
        exit();
       
    } else {
        $errores[] = "Ningún producto seleccionado.";
    }

}

?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <!--Aqui va el contenido principal de la pagina -->

        <section>

            <div class="bloque-titulo_boton">

                <h2 class="titulo">Notificaciones</h2>

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

                            <th>Nombre</th>

                            <th>Categoría</th>

                            <th>Cantidad</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="seleccionados[]" value="<?php echo $productos['id']; ?>">
                                </td>
                                <td>
                                    <?php echo $productos['nombre']; ?>
                                </td>
                                <td>
                                    <?php echo $productos['nombre_categoria']; ?>
                                </td>
                                <td>
                                    <?php echo $productos['cantidad']; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>

                </table>
                <input class="boton-primario btn btn-primary" type="submit" value="Orden Compras" name="orden">
            </form>

        </section>

    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>