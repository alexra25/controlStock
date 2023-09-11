<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
             INNER JOIN categorias ON productos.id_categoria = categorias.id";

$resultadoConsulta = mysqli_query($conn, $consulta);

$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Productos</h2>
                <a href="nuevo-producto.php">
                    <div class="btn btn-primary boton-primario">Añadir</div>
                </a>
            </div>
            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Actualizar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($productos = mysqli_fetch_assoc($resultadoConsulta)):?>
                        <tr>
                            <td><?php echo $productos['nombre']; ?></td>
                            <td><?php echo $productos['nombre_categoria']; ?></td>
                            <td><?php echo $productos['cantidad']; ?></td>
                            <td><a id="agregarContador" href="producto-cantidad.php?id=<?php echo $productos['id'] ?>"><i class="bi bi-arrow-clockwise" style="font-size: 2rem; color: black;"></i></a></td>
                            <td><a href="modificar-producto.php?id=<?php echo $productos['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </section>
    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>
