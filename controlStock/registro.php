<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$errores = [];

    $consulta = "SELECT registro.*,
                                CASE 
                                     WHEN registro.id_producto IS NOT NULL THEN registro.id_producto
                                            ELSE registro.id_categoria
                                END AS nombre_categoria,
        productos.nombre AS nombre_producto,
        usuarios.nombre AS nombre_usuario,
        usuarios.apellido1,
        usuarios.departamento,
        productos.referencia,
        accion.nombre_accion
    FROM registro
    LEFT JOIN productos ON registro.id_producto = productos.id
    LEFT JOIN categorias ON registro.id_categoria = categorias.id
    INNER JOIN usuarios ON registro.id_usuario = usuarios.id
    INNER JOIN accion ON registro.id_accion = accion.id
    ORDER BY registro.fecha DESC";

$resultadoConsulta = mysqli_query($conn, $consulta);

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

        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Registro</h2>
            </div>
            <?php foreach ($errores as $error): ?>
                <div class="alerta error ajustar-contenido">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <form method="post">
                <table class="tabla-productos2">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Departamento</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                            <th>Producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>

                            <?php 
                                $timestamp = strtotime($productos['fecha']);

                                // Formatea el timestamp en el nuevo formato
                                $fechaFormateada = date("d-m-Y H:i", $timestamp);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $productos["nombre_usuario"] . " " .$productos["apellido1"]; ?>
                                </td>
                                <td>
                                    <?php echo $productos['departamento']; ?>
                                </td>
                                <td>
                                    <?php echo $fechaFormateada; ?>
                                </td>
                                <td>
                                    <?php echo $productos['nombre_accion']; ?>
                                </td>
                                <td>
                                    <!-- Si es categoria que muestre la categoria y si no el producto
                                         Problema es que no podemos recoger la categoria -->
                                    <?php echo /*"CATEGORIA " .*/ $productos['nombre_producto']; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form>
        </section>
    </main>
        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>