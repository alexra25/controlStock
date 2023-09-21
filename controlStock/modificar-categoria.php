<?php
include "sesion.php";
include 'includes/header.php';
include "includes/registrar.php";

// Recogemos el id pasado por la url.
$id = $_GET['id'];
$consulta = "SELECT * FROM categorias WHERE id = $id";

$con = new Conexion();
$resultadoConsulta = $con->queryAll($consulta);

$categoria = $resultadoConsulta[0];

// variables de la pagina
$nombre_categoria = $categoria['nombre'];
$descripcion_categoria = $categoria['descripcion'];
$pagina = 'modificar-categoria';
$id_categoria = $id;
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
        $resultados = $con->query($consulta);
        $state = 1;

        if ($resultados) {
            setRegistro($nombre_categoria, 1, $id_usuario, $id_categoria, $con);

        } else {
            echo "Error al eliminar la categoría: ";
        }
    }
}

// evento eliminar categoria
if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM categorias WHERE id = $id_borrar";

    $resultados =  $con->queryAll($consulta);

    /*if ($resultados) {
        setRegistro($nombre_categoria, 3, $id_usuario, $id_categoria, $conn);

    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }*/
}


?>



<!-- vinculo de form_categorias -->
<?php include 'form_categorias.php'; ?>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>