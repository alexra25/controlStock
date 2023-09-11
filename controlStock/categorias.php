<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

    $consulta = "SELECT * FROM categorias";

    $resultadoConsulta = mysqli_query($conn, $consulta);


    // Cerrar la conexión cuando hayas terminado
    $conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <!--Aqui va el contenido principal de la pagina -->
        <section class="altu">

            <div class="bloque-titulo_boton">
                <h2 class="titulo">Categorías</h2>
                <a href="nueva-categoria.php">
                    <div class="boton-primario btn btn-primary">Añadir</div>
                </a>
            </div>

            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($categoria = mysqli_fetch_assoc($resultadoConsulta)):?>
                        <tr>
                            <td><?php echo $categoria['nombre']; ?></td>
                            <td><?php echo $categoria['descripcion']; ?></td>
                            <td><a href="modificar-categoria.php?id=<?php echo $categoria['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
            
        </section>
    </main>
                    
        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>