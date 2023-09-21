<?php
include "sesion.php";
include "includes/header.php";

include "includes/registrar.php";

$con = new Conexion();
$resultadoConsulta = $con->queryAll("SELECT * FROM categorias");
?>

<!-- vinculo de header y barra de navegacion -->

<!--Aqui va el contenido principal de la pagina -->
<section class="altu">
    <div class="bloque-titulo_boton">
        <h2 class="titulo">CATEGORÍAS</h2>
        <?php if (intval($id_rol) == 1 || intval($id_rol) == 2): ?>
            <a href="nueva-categoria.php">
                <div class="boton-primario btn btn-primary">Añadir</div>
            </a>
        <?php endif; ?>
    </div>

    <table class="tabla-productos2">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <?php if (intval($id_rol) == 1 || intval($id_rol) == 2 || intval($id_rol) == 3):  ?>
                    <th>Modificar</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($resultadoConsulta as $categoria){ ?>
                <tr>
                    <td class="categoria-cell" data-id="<?php echo $categoria['id']; ?>">
                        <!-- Agregar una clase y atributo "data-id" para identificar la categoría -->
                        <?php echo $categoria['nombre']; ?>
                    </td>
                    <td>
                        <?php echo $categoria['descripcion']; ?>
                    </td>
                    <?php if (intval($id_rol) == 1 || intval($id_rol) == 2 || intval($id_rol) == 3): ?>
                        <td><a href="modificar-categoria.php?id=<?php echo $categoria['id'] ?>"><i
                                    class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a></td>
                    <?php endif;  ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        // Agregar un evento de clic a las celdas de categoría
        var categoriaCells = document.querySelectorAll(".categoria-cell");
        categoriaCells.forEach(function (cell) {
            cell.style.cursor = "pointer"; // Cambiar el cursor a mano al pasar el ratón
            cell.addEventListener("click", function () {
                // Obtener el ID de la categoría desde el atributo "data-id"
                var idCategoria = this.getAttribute("data-id");

                // Redirigir a "productos-por-categoria.php" con el ID en la URL
                window.location.href = "productos-por-categoria.php?id=" + idCategoria;
            });
        });
    </script>
</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>
