<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

//Recogemos el id de la categoria pasada como parametro en la url
$id = $_GET['id'];

//consultas para mostrar las tablas por filtros
$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
             INNER JOIN categorias ON productos.id_categoria = categorias.id
             WHERE categorias.id = $id";

$resultadoConsulta = mysqli_query($conn, $consulta);

//Poner el titulo interactivo
$consulta2 = "SELECT nombre FROM categorias
             WHERE categorias.id = $id";

$resultadoConsulta2 = mysqli_query($conn, $consulta2);
$categoria = mysqli_fetch_assoc($resultadoConsulta2);

$titulo = strtoupper($categoria['nombre']);

$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<section>
    <div class="bloque-titulo_boton">
        <h2 class="titulo"><?php echo $titulo  ?></h2>
            <a href="index.php">
                <div class="btn btn-primary boton-primario">Atras</div>
            </a>
    </div>

    <table class="tabla-productos2">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td>
                        <?php echo $productos['nombre']; ?>
                    </td>
                    <td>
                        <?php echo $productos['codigo']; ?>
                    </td>
                    <td>
                        <?php echo $productos['cantidad']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>