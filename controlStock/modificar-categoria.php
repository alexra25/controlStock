<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

// Recogemos el id pasado por la url.
$id = $_GET['id'];
$consulta = "SELECT * FROM categorias WHERE id = ${'id'}";
$resultadoConsulta = mysqli_query($conn, $consulta);
$categoria = mysqli_fetch_assoc($resultadoConsulta);

// variables de la pagina
$nombre_categoria = $categoria['nombre'];
$descripcion_categoria = $categoria['descripcion'];
$pagina = 'modificar-categoria';
$errores = [];
$state = 0;

// evento modificar categoria
if (isset($_POST['modificar'])) {
    $id_modificar = $_POST['id'];
    $nombre_categoria = $_POST['nombre'];
    $descripcion_categoria = $_POST['descripcion'];

    //comprobacion de errores
    if (!$nombre_categoria) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$descripcion_categoria) {
        $errores[] = "Debes añadir una descripcion";
    }

    if (empty($errores)) {
        $consulta = "UPDATE categorias SET nombre = '$nombre_categoria', descripcion = '$descripcion_categoria' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 1;

        if ($resultados) {
           //TODO=>Corregir setRegistro($nombre, 1, $id_usuario, $conn);

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
    }
}

// evento eliminar categoria
if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM categorias WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        setRegistro($nombre_categoria, 3, $id_usuario, $conn);

    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!-- vinculo de form_categorias -->
<?php include 'form_categorias.php'; ?>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>