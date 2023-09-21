<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

// variables de la pagina
$nombre_categoria = '';
$descripcion_categoria = '';
$pagina = "nueva-categoria";
$errores = [];
$state = 0;

//ini_set('display_errors', 1);

// evento nueva categoria
if (isset($_POST['insertar'])) {
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
        $consulta = "INSERT INTO categorias (nombre,descripcion) values ('$nombre_categoria','$descripcion_categoria')";
        $resultados = mysqli_query($conn, $consulta);
        $id_categoria = mysqli_insert_id($conn);
    
        if ($resultados) {
            setRegistro($nombre_categoria, 3, $id_usuario, $id_categoria, $conn);

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
       
    }
    // cerrar conexion a la base de datos
    $conn->close();
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!-- vinculo de form_categorias -->
<?php include 'form_categorias.php'; ?>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>